<!-- riccardo git flow -->
<?php
$countries = array(
  "IT",
  "BE", 
  "BG",
  "CY",
  "CZ", 
  "DK", 
  "EE", 
  "FI", 
  "FR", 
  "DE", 
  "GR", 
  "HU", 
  "IE", 
  "AT",
  "LV", 
  "LT", 
  "LU", 
  "MT", 
  "NL", 
  "PL", 
  "PT", 
  "RO", 
  "SK", 
  "SI", 
  "ES", 
  "SE", 
  "GB");
  
  
if(isset($_POST['country']) && isset($_POST['vat'])) {
	$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
	var_dump($client->checkVat(array(
	  'countryCode' => $_POST['country'],
	  'vatNumber' => $_POST['vat'],
	)));
}

echo "<form method='post' action=''>";
echo "<label>Country</label> <select name='country'>";

	foreach($countries as $c) {
	  
	  echo "<option value='" . $c . "'>" . $c . "</option>";
	  
	}
	  
echo "</select><br /><br />";

echo "<label>VAT number</label> <input type='text' name='vat' value=''>";
echo "<br /><br /><input type='submit' value='submit'>";
echo "</form>";