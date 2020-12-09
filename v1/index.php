<?php 
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

		default:
			echo json_encode("Opción no valida");
			break;
	}
 ?>