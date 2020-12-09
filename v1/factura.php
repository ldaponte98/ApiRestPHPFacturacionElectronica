<?php 
	include ("Framework.php"); 
	include ("Http.php"); 

	class Factura
	{
		public $DB, $Http;

		function __construct()
		{
			$this->DB = new DB();
			$this->Http = new Http();
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

			$factura = $this->Http->get("http://dev.onbeds.co/index.php?r=API/Mis_reservas&id_tercero=14196");

			return [
				'error' => $error,
				'message' => $message,
				'data' => $factura
			];
		}
	}
 ?>