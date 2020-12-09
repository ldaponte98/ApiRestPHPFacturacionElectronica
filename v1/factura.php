<?php 
	include ("Framework.php"); 

	
	class Factura
	{
		public $DB;

		function __construct($foo = null)
		{
			$this->DB = new DB();
		}

		public function Enviar($id)
		{
			$error = true;
			$message = "";
			$factura = $this->DB->findBy('facturas07','doc',$id);
			if($factura){
				$message = "bien";
			}else{
				$message = "Esta factura no existe";
			}
			return [
				'error' => $error,
				'message' => $message,
				'data' => $factura
			];
		}
	}
 ?>