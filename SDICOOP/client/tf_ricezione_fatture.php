<?php
ini_set( "soap.wsdl_cache_enabled", 0 );
ini_set( 'soap.wsdl_cache_ttl', 0 );
include("../config.php");

$client = new SoapClient( $eptrf, array( 'cache_wsdl' => WSDL_CACHE_NONE ));

function print_output($response)
{
	if ($response == "") return "OK";

	return($response);
}

echo "<h1>Test end-point ricezione fatture da SDI</h1>";

	echo "<hr />";
	echo "<h2>Ricevi fattura</h2>";
	$response = $client->riceviFatture();
	print_r(print_output($response));

	echo "<hr />";
	echo "<h2>Notifica decorrenza termini</h2>";
	$response = $client->notificaDecorrenzaTermini();
	print_r(print_output($response));



