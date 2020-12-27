<?php 
require_once '../vendor/autoload.php';


class PDFDocumentos
{

	public function Factura($factura)
	{
		$data["nombre_empresa"] = "Empresa xxx-xxx";
		$data["nit"] = $factura->doc;
		$data["direccion"] = $factura->doc;
		$data["telefono"] = $factura->doc;
		$data["email"] = $factura->doc;
		$data["tipo_documento"] = $factura->doc;
		$data["num_documento"] = $factura->doc;
		$data["nombre_cliente"] = $factura->doc;
		$data["direccion_cliente"] = $factura->doc;
		$data["fecha_documento"] = $factura->doc;
		$data["telefono_cliente"] = $factura->doc;
		$data["identificacion_cliente"] = $factura->
		$data["texto_informativo"] = "Actividad económica 8621 tarifa Ica 9.66 por mil RESOLUAUTORIZACIÓN CIÓN DIAN DE FACTURACIÓN NO 18762014787909 FECHA 2019-05-28 RANGO DEL 01 A
10000 PREFIJO IVA RÉGIMEN ESPECIAL NO SOMOS GRANDES CONTRIBUYENTES. Factura impresa por computador por OnBeds S.A.S";

		$path_view = "Documentos/Factura.html";
		$html = file_get_contents($path_view);
		$html = $this->ReemplazarDataHTML($data, $html);
		$this->GenerarPDF($html);
	}

	public function ReemplazarDataHTML($data, $html)
	{
		$new_html = $html;
		foreach ($data as $key => $value) {
			$new_html = str_replace("{".$key."}", $value, $new_html);
		}
		return $new_html;
	}

	public function GenerarPDF($html)
	{
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
}
 ?>