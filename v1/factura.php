<?php 
	include ("Framework.php"); 
	include ("Http.php"); 
	include ("Config.php"); 
	include ("PDFDocumentos.php"); 

	class Factura
	{
		public $DB, $HTTP, $CONFIG, $PDF, $DATABASE_COMPANY ;

		public $mes_facturacion = "";
		function __construct()
		{
			$this->HTTP = new Http();
			$this->CONFIG = new Config();
			$this->PDF = new PDFDocumentos();
		}

		public function Enviar($id_factura, $mes, $id_compania, $ano)
		{
			$error = true;
			$message = "";
			$this->DATABASE_COMPANY = "apge_".$id_compania."_".$ano;
			$this->mes_facturacion = $mes;
			$DB = new DB($this->DATABASE_COMPANY);
			$factura = $DB->findBy("facturas".$mes,'doc', $id_factura);
			if($factura){
				$message = "bien";
				$data = $this->XMLFactura($factura, $id_compania);
				return $data;
				$data = base64_encode($data);
				$this->HTTP->content_type = "text/plain";
				$this->HTTP->header_extra = "efacturaAuthorizationToken : ".$this->CONFIG->software_token;
				$message = $this->HTTP->post($this->CONFIG->routes->enviar_documento, $data);
			}else{
				$message = "Esta factura no existe";
			}
			return [
				'error' => $error,
				'message' => $message,
				'data' => $data
			];
		}

		public function VerData($id_factura, $mes, $id_compania, $ano)
		{
			$error = true;
			$message = "";
			$this->DATABASE_COMPANY = "apge_".$id_compania."_".$ano;
			$this->mes_facturacion = $mes;
			$DB = new DB($this->DATABASE_COMPANY);
			$factura = $DB->findBy("facturas".$mes,'doc', $id_factura);
			if($factura){
				$data = $this->XMLFactura($factura, $id_compania);
				var_dump($this->ConvertirBase64($data));
				return $data;
			}else{
				return "Esta factura no existe";
			}
		}

		public function PDFFactura($id_factura, $mes, $id_compania, $ano)
		{
			$error = true;
			$message = "";
			$this->DATABASE_COMPANY = "apge_".$id_compania."_".$ano;
			$DB = new DB($this->DATABASE_COMPANY);
			$factura = $DB->findBy('facturas'+$mes,'doc', $id_factura);

			if($factura){
				return $this->PDF->Factura($factura);
			}else{
				$message = "Esta factura no existe";
			}
			return [
				'error' => $error,
				'message' => $message,
				'data' => $factura
			];
		}

		public function ConvertirBase64($data)
		{
			return base64_encode($data);
		}


		public function XMLFactura($factura, $id_company)
		{
			$DB_GENERAL = new DB($this->CONFIG->name_database_general);
			$DB_COMPANY = new DB($this->DATABASE_COMPANY);
			$company_params = $DB_GENERAL->findBy("params_cadena",'codcompa', $id_company);
			$client = $DB_COMPANY->findBy("terceros",'nit', $factura->nitc);
			$company = $DB_GENERAL->findBy("companias",'codcompa', $id_company);

			$data_factura["num_resolucion"] = $company_params->num_resolucion;
			$data_factura["fecha_inicio_resolucion"] = $company_params->fecha_inicio_resolucion;
			$data_factura["fecha_fin_resolucion"] = $company_params->fecha_fin_resolucion;
			$data_factura["prefijo_resolucion"] = $company_params->prefijo_resolucion;
			$data_factura["rango_desde_numeracion"] = $company_params->rango_inicio_resolucion;
			$data_factura["rango_hasta_numeracion"] = $company_params->rango_hasta_resolucion;
			$data_factura["llave_tecnica_empresa"] = $company_params->llave_tecnica;
			$data_factura["test_set_id_empresa"] = $company_params->test_set_id;

			$data_factura["prefijo_mas_num_doc"] = $factura->doc;
			$data_factura["fecha_factura"] = date('Y-m-d', strtotime($factura->fecha));
			$data_factura["hora_factura"] = date('H:i:s', strtotime($factura->hora));;
			$data_factura["nota_1"] = $factura->observ;

			$municipio_empresa = $this->BuscarMunicipio($company->codmun);

			$data_factura["nit_empresa"] = str_replace(".", "", explode("-", $company->nit)[0]);
			$data_factura["nombre_empresa"] = $company->descripcion;
			$data_factura["codigo_municipio_empresa"] = $municipio_empresa->codigo;
			$data_factura["nombre_municipio_empresa"] = $municipio_empresa->nombre;
			$data_factura["codigo_postal_municipio_empresa"] = ""; //No definido en DB
			$data_factura["nombre_departamento_empresa"] = "".$municipio_empresa->departamento->descripcion;
			$data_factura["codigo_departamento_empresa"] = "".$municipio_empresa->departamento->codigo;
			$data_factura["direccion_empresa"] = $company->direccion;
			$data_factura["matricula_mercantil_empresa"] = $company->matricula_mercantil;
			$data_factura["email_empresa"] = $company->email;

			$municipio_cliente = $this->BuscarMunicipio($client->mun);
			$data_factura["nit_cliente"] = $client->nit;
			$data_factura["email_cliente"] = $client->correo;
			$data_factura["nombre_cliente"] = $client->nombre." ".$client->ape1." ".$client->ape2;
			$data_factura["codigo_municipio_cliente"] = "".$municipio_cliente->codigo;
			$data_factura["nombre_municipio_cliente"] = "".$municipio_cliente->nombre;
			$data_factura["codigo_postal_municipio_cliente"] = ""; //No definido en DB
			$data_factura["nombre_departamento_cliente"] = "".$municipio_cliente->departamento->descripcion;
			$data_factura["codigo_departamento_cliente"] = "".$municipio_cliente->departamento->codigo;
			$data_factura["direccion_cliente"] = "".$client->dir;			
			$data_factura["matricula_mercantil_cliente"] = "";//$client->; No definido en la BD

			$data_factura["xml_formas_pago"] = $this->XMLFormasPago($factura);
		
			$data_factura["total_detalles"] = $factura->subtotal;
			$data_factura["total_factura_sin_impuesto"] = $factura->total - $factura->ret_f -  $factura->iva -  $factura->inc -  $factura->ret_iva -  $factura->ret_ica;
			$data_factura["total_factura_con_impuesto"] = $factura->total;
			$data_factura["total_pagado"] = $factura->total;


			$data_factura["xml_detalles"] = $this->XMLFacturaDetalles($factura);

			$path_view = "XMLS/FacturaVenta.xml";
			$html = file_get_contents($path_view);
			$xml = $this->ReemplazarDataHTML($data_factura, $html);
			return $xml;
		}

		public function XMLFormasPago($factura)
		{
			$xml = "";
			$path_view = "XMLS/FacturaVentaFormaPago.xml";
			$html = file_get_contents($path_view);
			//CAMBIAR PARA VALIDAR POR VALOR DE CADA CAMPO
			if($factura->fp == "Efectivo"){
				$data["tipo_forma_pago"] = 1; //efectivo
				$data["forma_pago"] = 10;//efectivo dian
				$data["descripcion_forma_pago"] = "Efectivo";
				$xml = $this->ReemplazarDataHTML($data, $html);
			}

			if($factura->fp == "Banco"){
				$data["tipo_forma_pago"] = 42; //efectivo
				$data["forma_pago"] = 10;//efectivo dian
				$data["descripcion_forma_pago"] = "Efectivo";
				$xml = $this->ReemplazarDataHTML($data, $html);
			}
			//

			if($factura->fp == "Varias"){
				if($factura->efectivo > 0){
					$data["tipo_forma_pago"] = 1; //efectivo
					$data["forma_pago"] = 10;//efectivo dian
					$data["descripcion_forma_pago"] = "Efectivo";
					$xml .= $this->ReemplazarDataHTML($data, $html);
				}
				if($factura->banco > 0){
					$data["tipo_forma_pago"] = 1; //efectivo
					$data["forma_pago"] = 42;//consignacion bancaria dian
					$data["descripcion_forma_pago"] = "Consignación bancaria";
					$xml .= $this->ReemplazarDataHTML($data, $html);
				}
				if($factura->credito > 0){
					$data["tipo_forma_pago"] = 2; //credito
					$data["forma_pago"] = 30;//credito dian
					$data["descripcion_forma_pago"] = "Credito";
					$xml .= $this->ReemplazarDataHTML($data, $html);
				}
				if($factura->otrafp > 0){
					$data["tipo_forma_pago"] = 1; //efectivo
					$data["forma_pago"] = 10;//efectivo dian
					$data["descripcion_forma_pago"] = "Otra forma de pago";
					$xml .= $this->ReemplazarDataHTML($data, $html);
				}
			}

			return $xml;
		}

		public function XMLFacturaDetalles($factura)
		{
			$path_view = "XMLS/FacturaVentaDetalle.xml";
			$DB_COMPANY = new DB($this->DATABASE_COMPANY);
			$detalles = $DB_COMPANY->findAllBy("detafac".$this->mes_facturacion, "doc", $factura->doc);

			$xml = "";
			$html = file_get_contents($path_view);
			//CAMBIAR PARA VALIDAR POR VALOR DE CADA CAMPO
			foreach ($detalles as $detalle) {
				$data["detalle_cantidad"] = $detalle->cantf;
				$data["detalle_valor_total"] = $detalle->vtotal;
				$data["detalle_motivo_descuento"] = ""/*.$detalle->*/; //No definido
				$data["detalle_porcentaje_descuento"] = floatval($detalle->pdes);
				$data["detalle_valor_descuento"] = (floatval($detalle->vub) * floatval($detalle->pdes));
				$data["detalle_valor_base"] = floatval($detalle->vub);
				$data["detalle_valor_impuesto"] = (floatval($detalle->vui) - floatval($detalle->vub));

				$data["detalle_producto_descripcion"] = "".$detalle->nom;
				$data["detalle_producto_codigo"] = "".$detalle->cod;
				$data["detalle_producto_valor"] = floatval($detalle->vub);
				$data["detalle_cantidad"] = "".$detalle->cantf;

				$path_view = "XMLS/FacturaVentaDetalleImpuesto.xml";
				$html_impuesto = file_get_contents($path_view);

				$data["xml_impuestos"] = "";
				if(floatval($detalle->piva) != 0){
					$valor_impuesto = round(($detalle->piva / 100) *  floatval($detalle->vub));
					$data_impuesto["detalle_valor_impuesto"] = $valor_impuesto;
					$data_impuesto["detalle_valor_base"] = floatval($detalle->vub);
					$data_impuesto["detalle_porcentaje_impuesto"] = floatval($detalle->piva);
					$data_impuesto["detalle_codigo_impuesto"] = "01";
					$data_impuesto["detalle_descripcion_impuesto"] = "IVA";
					$data["xml_impuestos"] .= $this->ReemplazarDataHTML($data_impuesto, $html_impuesto);
				}

				if(floatval($detalle->pinc) != 0){
					$valor_impuesto = ($detalle->pinc / 100) *  floatval($detalle->vub);
					$data_impuesto["detalle_valor_impuesto"] = $valor_impuesto;
					$data_impuesto["detalle_valor_base"] = floatval($detalle->vub);
					$data_impuesto["detalle_porcentaje_impuesto"] = floatval($detalle->piva);
					$data_impuesto["detalle_codigo_impuesto"] = "04";
					$data_impuesto["detalle_descripcion_impuesto"] = "INC";
					$data["xml_impuestos"] .= $this->ReemplazarDataHTML($data_impuesto, $html_impuesto);
				}

				$xml .= $this->ReemplazarDataHTML($data, $html);
			}
			return $xml;
			
		}

		public function ReemplazarDataHTML($data, $html)
		{
			$new_html = $html;
			foreach ($data as $key => $value) {
				$new_html = str_replace("{".$key."}", $value, $new_html);
			}
			return $new_html;
		}

		public function BuscarMunicipio($mun)
		{
			$DB_GENERAL = new DB($this->CONFIG->name_database_general);
			$municipio = $DB_GENERAL->findBy("mun",'codmun', $mun);
			$departamento = $DB_GENERAL->findBy("dptos",'codigo', $municipio->coddep);

			return (object) [
				'codigo' => $mun,
				'nombre' => $municipio->descripcion,
				'departamento' => $departamento
			];
		}
	}
		
