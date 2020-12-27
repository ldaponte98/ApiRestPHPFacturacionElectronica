<?php 
	include ("Framework.php"); 
	include ("Http.php"); 
<<<<<<< HEAD
	include ("Config.php"); 

	class Factura
	{
		public $DB, $HTTP, $CONFIG;
=======
	include ("PDFDocumentos.php"); 

	class Factura
	{
		public $DB, $Http, $PDF;
>>>>>>> de4aae4437df5f5df1fdb8a08267068acbdbeef9

		function __construct()
		{
			$this->DB = new DB();
<<<<<<< HEAD
			$this->HTTP = new Http();
			$this->CONFIG = new Config();
=======
			$this->Http = new Http();
			$this->PDF = new PDFDocumentos();
>>>>>>> de4aae4437df5f5df1fdb8a08267068acbdbeef9
		}

		public function Enviar($id)
		{
			$error = true;
			$message = "";
			$factura = $this->DB->findBy('facturas07','doc', $id);

			if($factura){
				$message = "bien";
				$data = $this->XMLFactura($factura);
			}else{
				$message = "Esta factura no existe";
			}
			//$factura = $this->Http->get("http://dev.onbeds.co/index.php?r=API/Mis_reservas&id_tercero=14196");
			return [
				'error' => $error,
				'message' => $message,
				'data' => $factura
			];
		}

<<<<<<< HEAD
			//$factura = $this->HTTP->get("http://dev.onbeds.co/index.php?r=API/Mis_reservas&id_tercero=14196");
=======
		public function PDFFactura($id)
		{
			$error = true;
			$message = "";
			$factura = $this->DB->findBy('facturas07','doc', $id);
>>>>>>> de4aae4437df5f5df1fdb8a08267068acbdbeef9

			if($factura){
				return $this->PDF->Factura($factura);
			}else{
				$message = "Esta factura no existe";
			}
			//$factura = $this->Http->get("http://dev.onbeds.co/index.php?r=API/Mis_reservas&id_tercero=14196");
			return [
				'error' => $error,
				'message' => $message,
				'data' => $factura
			];
		}

		public function XMLFactura($factura)
		{
<<<<<<< HEAD
			
=======
			return '<?xml version="1.0" encoding="UTF-8"?>
			<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sts="dian:gov:co:facturaelectronica:Structures-2-1" xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2     http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd">
				<ext:UBLExtensions>
					<ext:UBLExtension>
						<ext:ExtensionContent>
							<sts:DianExtensions>
								<sts:InvoiceControl>
									<sts:InvoiceAuthorization>18760000001</sts:InvoiceAuthorization>
									<sts:AuthorizationPeriod>
										<cbc:StartDate>2019-01-19</cbc:StartDate>
										<cbc:EndDate>2030-01-19</cbc:EndDate>
									</sts:AuthorizationPeriod>
									<sts:AuthorizedInvoices>
										<sts:Prefix>SETP</sts:Prefix>
										<sts:From>990000000</sts:From>
										<sts:To>995000000</sts:To>
									</sts:AuthorizedInvoices>
								</sts:InvoiceControl>
								<sts:InvoiceSource>
									<cbc:IdentificationCode listAgencyID="6" listAgencyName="United Nations Economic Commission for Europe" listSchemeURI="urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.1">CO</cbc:IdentificationCode>
								</sts:InvoiceSource>
								<sts:SoftwareProvider>
									<sts:ProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="0" schemeName="31">890930534</sts:ProviderID>
									<sts:SoftwareID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">49fab599-4556-4828-a30b-852a910c5bb1</sts:SoftwareID>
								</sts:SoftwareProvider>
								<sts:SoftwareSecurityCode schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">ab1a6f2c40b59e7fa9479e2e829115393fb4fa24741ceaf5c1915278f89e705b641e43cc1f0a8144f4d37c3e074913a8</sts:SoftwareSecurityCode>
								<sts:AuthorizationProvider>
									<sts:AuthorizationProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="4" schemeName="31">800197268</sts:AuthorizationProviderID>
								</sts:AuthorizationProvider>
								<sts:QRCode>https://muisca.dian.gov.co/WebFacturaelectronica/paginas/VerificarFacturaElectronicaExterno.faces?TipoDocumento=1NroDocumento=PRUE980078932NITFacturador=890101815NumIdentAdquiriente=900108281Cufe=bf8b43bc09bdf01204dd2f1dcae2b51ea02e849f29257140fc00dc9b65aa953e</sts:QRCode>
							</sts:DianExtensions>
						</ext:ExtensionContent>
					</ext:UBLExtension>
				</ext:UBLExtensions>
				<cbc:UBLVersionID>UBL 2.1</cbc:UBLVersionID>
				<cbc:CustomizationID>05</cbc:CustomizationID>
				<cbc:ProfileID>DIAN 2.1</cbc:ProfileID>
				<cbc:ProfileExecutionID>2</cbc:ProfileExecutionID>
				<cbc:ID>SETP990000312</cbc:ID>
				<cbc:UUID schemeID="2" schemeName="CUFE-SHA384">bebb02b304aa0b8d65e57f52caa36fe8336636cd10e6700a6d3de6a25425d027cb100541c8664d4eee71d1ae7c642f68</cbc:UUID>
				<cbc:IssueDate>2019-06-04</cbc:IssueDate>
				<cbc:IssueTime>12:53:36-05:00</cbc:IssueTime>
				<cbc:InvoiceTypeCode>01</cbc:InvoiceTypeCode>
				<cbc:Note>Prueba Factura Electronica Datos Reales 2</cbc:Note>
				<cbc:DocumentCurrencyCode>COP</cbc:DocumentCurrencyCode>
				<cbc:LineCountNumeric>1</cbc:LineCountNumeric>
				<cac:AccountingSupplierParty>
					<cbc:AdditionalAccountID>1</cbc:AdditionalAccountID>
					<cac:Party>
						<cac:PartyName>
							<cbc:Name>Cadena S.A.</cbc:Name>
						</cac:PartyName>
						<cac:PhysicalLocation>
							<cac:Address>
								<cbc:ID>05380</cbc:ID>
								<cbc:CityName>LA ESTRELLA</cbc:CityName>
								<cbc:PostalZone>055460</cbc:PostalZone>
								<cbc:CountrySubentity>Antioquia</cbc:CountrySubentity>
								<cbc:CountrySubentityCode>05</cbc:CountrySubentityCode>
								<cac:AddressLine>
									<cbc:Line>Cra. 50 #97a Sur-180 a 97a Sur-394</cbc:Line>
								</cac:AddressLine>
								<cac:Country>
									<cbc:IdentificationCode>CO</cbc:IdentificationCode>
									<cbc:Name languageID="es">Colombia</cbc:Name>
								</cac:Country>
							</cac:Address>
						</cac:PhysicalLocation>
						<cac:PartyTaxScheme>
							<cbc:RegistrationName>Cadena S.A.</cbc:RegistrationName>
							<cbc:CompanyID schemeID="0" schemeName="31" schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">890930534</cbc:CompanyID>
							<cbc:TaxLevelCode listName="05">O-99</cbc:TaxLevelCode>
							<cac:RegistrationAddress>
							<cbc:ID>05380</cbc:ID>
								<cbc:CityName>LA ESTRELLA</cbc:CityName>
								<cbc:PostalZone>055468</cbc:PostalZone>
								<cbc:CountrySubentity>Antioquia</cbc:CountrySubentity>
								<cbc:CountrySubentityCode>05</cbc:CountrySubentityCode>
								<cac:AddressLine>
									<cbc:Line>Cra. 50 #97a Sur-180 a 97a Sur-394</cbc:Line>
								</cac:AddressLine>
								<cac:Country>
									<cbc:IdentificationCode>CO</cbc:IdentificationCode>
									<cbc:Name languageID="es">Colombia</cbc:Name>
								</cac:Country>
							</cac:RegistrationAddress>
							<cac:TaxScheme>
								<cbc:ID>01</cbc:ID>
								<cbc:Name>IVA</cbc:Name>
							</cac:TaxScheme>
						</cac:PartyTaxScheme>
						<cac:PartyLegalEntity>
							<cbc:RegistrationName>Cadena S.A.</cbc:RegistrationName>
							<cbc:CompanyID schemeID="0" schemeName="31" schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">890930534</cbc:CompanyID>
							<cac:CorporateRegistrationScheme>
								<cbc:ID>SETP</cbc:ID>
								<cbc:Name>1485596</cbc:Name>
							</cac:CorporateRegistrationScheme>
						</cac:PartyLegalEntity>
						<cac:Contact>
							<cbc:ElectronicMail>leandro.ocampo@cadena.com.co</cbc:ElectronicMail>
						</cac:Contact>
					</cac:Party>
				</cac:AccountingSupplierParty>
				<cac:AccountingCustomerParty>
					<cbc:AdditionalAccountID>1</cbc:AdditionalAccountID>
					<cac:Party>
						<cac:PartyName>
							<cbc:Name>ADQUIRIENTE DE EJEMPLO</cbc:Name>
						</cac:PartyName>
						<cac:PhysicalLocation>
							<cac:Address>
								<cbc:ID>66001</cbc:ID>
								<cbc:CityName>PEREIRA</cbc:CityName>
								<cbc:PostalZone>54321</cbc:PostalZone>
								<cbc:CountrySubentity>Risaralda</cbc:CountrySubentity>
								<cbc:CountrySubentityCode>66</cbc:CountrySubentityCode>
								<cac:AddressLine>
									<cbc:Line>CR 9 A N0 99 - 07 OF 802</cbc:Line>
								</cac:AddressLine>
								<cac:Country>
									<cbc:IdentificationCode>CO</cbc:IdentificationCode>
									<cbc:Name languageID="es">Colombia</cbc:Name>
								</cac:Country>
							</cac:Address>
						</cac:PhysicalLocation>
						<cac:PartyTaxScheme>
							<cbc:RegistrationName>ADQUIRIENTE DE EJEMPLO</cbc:RegistrationName>
							<cbc:CompanyID schemeID="3" schemeName="31" schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">1017173008</cbc:CompanyID>
							<cbc:TaxLevelCode listName="05">O-99</cbc:TaxLevelCode>
							<cac:RegistrationAddress>
								<cbc:ID>66001</cbc:ID>
								<cbc:CityName>PEREIRA</cbc:CityName>
								<cbc:PostalZone>54321</cbc:PostalZone>
								<cbc:CountrySubentity>Risaralda</cbc:CountrySubentity>
								<cbc:CountrySubentityCode>66</cbc:CountrySubentityCode>
								<cac:AddressLine>
									<cbc:Line>CR 9 A N0 99 - 07 OF 802</cbc:Line>
								</cac:AddressLine>
								<cac:Country>
									<cbc:IdentificationCode>CO</cbc:IdentificationCode>
									<cbc:Name languageID="es">Colombia</cbc:Name>
								</cac:Country>
							</cac:RegistrationAddress>
							<cac:TaxScheme>
								<cbc:ID>01</cbc:ID>
								<cbc:Name>IVA</cbc:Name>
							</cac:TaxScheme>
						</cac:PartyTaxScheme>
						<cac:PartyLegalEntity>
							<cbc:RegistrationName>ADQUIRIENTE DE EJEMPLO</cbc:RegistrationName>
							<cbc:CompanyID schemeID="3" schemeName="31" schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)">1017173008</cbc:CompanyID>
							<cac:CorporateRegistrationScheme>
								<cbc:Name>1485596</cbc:Name>
							</cac:CorporateRegistrationScheme>
						</cac:PartyLegalEntity>
						<cac:Contact>
							<cbc:ElectronicMail>leandro.sys89@gmail.com</cbc:ElectronicMail>
						</cac:Contact>
					</cac:Party>
				</cac:AccountingCustomerParty>
				<cac:PaymentMeans>
					<cbc:ID>1</cbc:ID>
					<cbc:PaymentMeansCode>10</cbc:PaymentMeansCode>
					<cbc:PaymentID>Efectivo</cbc:PaymentID>
				</cac:PaymentMeans>
				<cac:TaxTotal>
					<cbc:TaxAmount currencyID="COP">19000.00</cbc:TaxAmount>
					<cac:TaxSubtotal>
						<cbc:TaxableAmount currencyID="COP">100000.00</cbc:TaxableAmount>
						<cbc:TaxAmount currencyID="COP">19000.00</cbc:TaxAmount>
						<cac:TaxCategory>
							<cbc:Percent>19.00</cbc:Percent>
							<cac:TaxScheme>
								<cbc:ID>01</cbc:ID>
								<cbc:Name>IVA</cbc:Name>
							</cac:TaxScheme>
						</cac:TaxCategory>
					</cac:TaxSubtotal>
				</cac:TaxTotal>
				<cac:LegalMonetaryTotal>
					<cbc:LineExtensionAmount currencyID="COP">100000.00</cbc:LineExtensionAmount>
					<cbc:TaxExclusiveAmount currencyID="COP">100000.00</cbc:TaxExclusiveAmount>
					<cbc:TaxInclusiveAmount currencyID="COP">119000.00</cbc:TaxInclusiveAmount>
					<cbc:PayableAmount currencyID="COP">119000.00</cbc:PayableAmount>
				</cac:LegalMonetaryTotal>
				<cac:InvoiceLine>
					<cbc:ID>1</cbc:ID>
					<cbc:InvoicedQuantity>1.00</cbc:InvoicedQuantity>
					<cbc:LineExtensionAmount currencyID="COP">100000.00</cbc:LineExtensionAmount>
					<cac:TaxTotal>
						<cbc:TaxAmount currencyID="COP">19000.00</cbc:TaxAmount>			
						<cac:TaxSubtotal>
							<cbc:TaxableAmount currencyID="COP">100000.00</cbc:TaxableAmount>
							<cbc:TaxAmount currencyID="COP">19000.00</cbc:TaxAmount>
							<cac:TaxCategory>
								<cbc:Percent>19.00</cbc:Percent>
								<cac:TaxScheme>
									<cbc:ID>01</cbc:ID>
									<cbc:Name>IVA</cbc:Name>
								</cac:TaxScheme>
							</cac:TaxCategory>
						</cac:TaxSubtotal>
					</cac:TaxTotal>
					<cac:Item>
						<cbc:Description>Frambuesas</cbc:Description>
						<cac:StandardItemIdentification>
							<cbc:ID schemeID="001">03222314-7</cbc:ID>
						</cac:StandardItemIdentification>
					</cac:Item>
					<cac:Price>
						<cbc:PriceAmount currencyID="COP">100000.00</cbc:PriceAmount>
						<cbc:BaseQuantity unitCode="EA">1.00</cbc:BaseQuantity>
					</cac:Price>
				</cac:InvoiceLine>
			</Invoice>';
>>>>>>> de4aae4437df5f5df1fdb8a08267068acbdbeef9
		}
	}
 ?>