<?php 
	include ("Framework.php"); 
	include ("Http.php"); 
	include ("Config.php"); 

	class Factura
	{
		public $DB, $HTTP, $CONFIG;

		function __construct()
		{
			$this->DB = new DB();
			$this->HTTP = new Http();
			$this->CONFIG = new Config();
		}

		public function Enviar($id)
		{
			$error = true;
			$message = "";
			$factura = $this->DB->findBy('facturas07','doc', $id);

			if($factura){
				$message = "bien";
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

		public function XMLFactura($factura)
		{
			
		}
	}
 ?>