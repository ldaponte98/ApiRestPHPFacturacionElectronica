<?php 
	include ("Framework.php"); 
	include ("Http.php"); 
	include ("Config.php"); 
	include ("PDFDocumentos.php"); 

	class Factura
	{
		public $DB, $DB_COMPANIA, $HTTP, $CONFIG, $PDF;


		function __construct()
		{
			
			$this->HTTP = new Http();
			$this->CONFIG = new Config();
			$this->PDF = new PDFDocumentos();
		}

		public function Enviar($id_factura, $tabla, $id_compania, $ano)
		{
			$error = true;
			$message = "";
			$this->DB_COMPANIA = new DB("apge_".$id_compania."_".$ano);
			$factura = $this->DB_COMPANIA->findBy($tabla,'doc', $id_factura);

			if($factura){
				$message = "bien";
				$data = $this->XMLFactura($factura);
				$data = base64_encode($data);
				$this->HTTP->content_type = "text/plain";
				$this->HTTP->header_extra = "efacturaAuthorizationToken : ".$this->CONFIG->software_token;
				$message = $this->HTTP->post($this->CONFIG->routes->enviar_documento, $data);
			}else{
				$message = "Esta factura no existe";
			}
			//$factura = $this->HTTP->get("http://dev.onbeds.co/index.php?r=API/Mis_reservas&id_tercero=14196");
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
			$factura = $this->DB->findBy('facturas07','doc', $id);

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
	}
		
