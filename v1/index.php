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
			$mes = $_GET['mes']; // Es necesario recibir este campo por get
			$id_compania = $_GET['id_compania']; // Es necesario recibir este campo por get
			$ano = $_GET['ano']; // Es necesario recibir este campo por get
			echo $facturaController->Enviar($id, $mes, $id_compania, $ano);
			break;
		case 'pdf_factura':
			$id = $_GET['id']; // Es necesario recibir este campo por get
			echo $facturaController->PDFFactura($id);
			break;
		case 'base64':
			//$data = $_POST['documento']; 
			echo json_encode($_POST);//$facturaController->ConvertirBase64($data);
			break;

		case 'ver_factura':
			$id = $_GET['id']; // Es necesario recibir este campo por get
			$mes = $_GET['mes']; // Es necesario recibir este campo por get
			$id_compania = $_GET['id_compania']; // Es necesario recibir este campo por get
			$ano = $_GET['ano']; // Es necesario recibir este campo por get
			echo $facturaController->VerData($id, $mes, $id_compania, $ano);
			break;


		default:
			echo json_encode("Opción no valida");
			break;
	}
 ?>