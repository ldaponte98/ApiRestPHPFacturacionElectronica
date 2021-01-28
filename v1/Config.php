<?php 
	class Config
	{
		public $rango_facturacion = "fc8eac422eba16e22ffd8c6f94b3f40a6e38162c";
		public $software_id = "49fab599-4556-4828-a30b-852a910c5bb1"; //ID DE CADENA
		public $software_nit = "890930534";
		public $software_token = "9334fbf0-4611-494d-9f91-46e2fc8afcd5";
		public $nit_empresa = "1065566411"; //NIT DE MI EMPRESA

		public $routes = [
			'enviar_documento' => 'https://apivp.efacturacadena.com/staging/vp-hab/documentos/proceso/alianzas'
		];

		function __construct()
		{
			$this->routes = (object) $this->routes; 
		}
	}
 ?>