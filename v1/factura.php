<?php 
	include ("Framework.php"); 
	include ("Http.php"); 
	include ("Config.php"); 
	include ("PDFDocumentos.php"); 

	class Factura
	{
		public $DB, $HTTP, $CONFIG, $PDF, $DATABASE_COMPANY , $MONTH;


		function __construct()
		{
			$this->HTTP = new Http();
			$this->CONFIG = new Config();
			$this->PDF = new PDFDocumentos();
		}

		public function Enviar($id_factura, $month, $id_compania, $ano)
		{
			$error = true;
			$message = "";
			$this->DATABASE_COMPANY = "apge_".$id_compania."_".$ano;
			$DB = new DB($this->DATABASE_COMPANY);
			$factura = $DB->findBy("factura".$month,'doc', $id_factura);
			if($factura){
				$message = "bien";
				$data = $this->XMLFactura($factura, $id_compania);
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
				'data' => $factura
			];
		}

		public function PDFFactura($id)
		{
			$error = true;
			$message = "";
			$DB = new DB($this->DATABASE_COMPANY);
			$factura = $DB->findBy('facturas07','doc', $id);

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
			$DB_GENERAL = new DB("apge");
			$DB_COMPANY = new DB($this->DATABASE_COMPANY);
			$company = $DB_GENERAL->findBy("params_cadena",'codcompa', $id_company);

			$data_factura["num_resolucion"] = $company->num_resolucion;
			$data_factura["fecha_inicio_resolucion"] = $company->fecha_inicio_resolucion;
			$data_factura["fecha_fin_resolucion"] = $company->fecha_fin_resolucion;
			$data_factura["prefijo_resolucion"] = $company->prefijo_resolucion;
			$data_factura["rango_desde_numeracion"] = $company->rango_desde_numeracion;
			$data_factura["rango_hasta_numeracion"] = $company->rango_hasta_numeracion;
			$data_factura["llave_tecnica_empresa"] = $company->llave_tecnica;
			$data_factura["test_set_id_empresa"] = $company->test_set_id;

			$data_factura["prefijo_mas_num_doc"] = $factura->doc;
			$data_factura["fecha_factura"] = date('Y-m-d', strtotime($factura->fecha));
			$data_factura["hora_factura"] = date('H:i:s', strtotime($factura->hora));;
			$data_factura["nota_1"] = $factura->observ;

			$data_factura["nit_empresa"] = $company->nit;
			$data_factura["nombre_empresa"] = $company->descripcion;
			$data_factura["codigo_municipio_empresa"] = $company->codmun;
			$data_factura["nombre_municipio_empresa"] = $company->ciudad;
			$data_factura["codigo_postal_municipio_empresa"] = $company->codpos;
			$data_factura["nombre_departamento_empresa"] = $company->codpos;
			$data_factura["codigo_departamento_empresa"] = $company->codpos;
			$data_factura["direccion_empresa"] = $company->direccion;
			$data_factura["matricula_mercantil_empresa"] = $indefinido;
			$data_factura["email_empresa"] = $company->email;

			$data_factura["nit_cliente"] = $factura->nitc;
			$data_factura["email_cliente"] = $factura->email;
			$data_factura["nombre_cliente"] = ;
			$data_factura["codigo_municipio_cliente"] = ;
			$data_factura["nombre_municipio_cliente"] = ;
			$data_factura["codigo_postal_municipio_cliente"] = ;
			$data_factura["nombre_departamento_cliente"] = ;
			$data_factura["codigo_departamento_cliente"] = ;
			$data_factura["direccion_cliente"] = ;			
			$data_factura["matricula_mercantil_cliente"] = ;

			$data_factura["xml_formas_pago"] = $this->XMLFormasPago($factura);
			$data_factura["tipo_forma_pago"] = ;
			$data_factura["forma_pago"] = ;
			$data_factura["descripcion_forma_pago"] = ;
			$data_factura["total_detalles"] = ;
			$data_factura["total_factura_sin_impuesto"] = ;
			$data_factura["total_factura_con_impuesto"] = ;
			$data_factura["total_pagado"] = ;


			$data_factura["detalle_cantidad"] = ;
			$data_factura["detalle_valor_total"] = ;
			$data_factura["detalle_motivo_descuento"] = ;
			$data_factura["detalle_porcentaje_descuento"] = ;
			$data_factura["detalle_valor_descuento"] = ;
			$data_factura["detalle_valor_base"] = ;
			$data_factura["detalle_valor_impuesto"] = ;
			$data_factura["detalle_valor_base"] = ;
			$data_factura["detalle_valor_impuesto"] = ;
			$data_factura["detalle_porcentaje_impuesto"] = ;
			$data_factura["detalle_codigo_impuesto"] = ;
			$data_factura["detalle_descripcion_impuesto"] = ;
			$data_factura["detalle_producto_descripcion"] = ;
			$data_factura["detalle_producto_codigo"] = ;
			$data_factura["detalle_producto_valor"] = ;
			$data_factura["detalle_cantidad"] = ;
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
				$data["tipo_forma_pago"] = 1; //efectivo
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
					$data["forma_pago"] = 13;//credito dian
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
			$DB_COMPANY = new DB($this->DATABASE_COMPANY)
			$detalles = $DB_COMPANY->findAllBy($tabla, $nombre_columna, $value)
			$html = file_get_contents($path_view);
			$html = $this->ReemplazarDataHTML($data, $html);
		}

		public function ReemplazarDataHTML($data, $html)
		{
			$new_html = $html;
			foreach ($data as $key => $value) {
				$new_html = str_replace("{".$key."}", $value, $new_html);
			}
			return $new_html;
		}
	}
		
