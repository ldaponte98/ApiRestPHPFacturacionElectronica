<?php 
	function cors() {
	    // Allow from any origin
	    if (isset($_SERVER['HTTP_ORIGIN'])) {
	        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	        // you want to allow, and if so:
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }

	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            // may also be using PUT, PATCH, HEAD etc
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	        exit(0);
	    }
	}
	cors();
	//CONTROLLERS DE LA API
	include ("Factura.php");
	$facturaController = new Factura;

	$opcion = strtolower($_GET['opcion']);

	//ACA SE MANEJARA EL SISTEMA DE RUTAS DE LA API
	switch ($opcion) {
		case 'enviar_factura':
			$id = $_GET['id']; // Es necesario recibir este campo por get
			echo json_encode($facturaController->Enviar($id));
			break;
		case 'pdf_factura':
			$id = $_GET['id']; // Es necesario recibir este campo por get
			echo $facturaController->PDFFactura($id);
			break;

		default:
			echo json_encode("Opción no valida");
			break;
	}
 ?>