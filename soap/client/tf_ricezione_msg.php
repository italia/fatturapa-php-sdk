<?php
include("../config.php");

$client = new SoapClient( $eptft, array( 'cache_wsdl' => WSDL_CACHE_NONE ));

function print_output($response)
{
	if ($response == "") return "OK";

	return($response);
}

echo "<h1>Test ricezione msg da SDI in seguito ad invio fattura</h1>";

echo "<hr />";
echo "<h2>Ricevuta consegna</h2>";
$response = $client->ricevutaConsegna();
print_r(print_output($response));

echo "<hr />";
echo "<h2>Notifica mancata consegna</h2>";
$response = $client->notificaMancataConsegna();
print_r(print_output($response));

echo "<hr />";
echo "<h2>Notifica scarto</h2>";
$response = $client->notificaScarto();
print_r(print_output($response));

echo "<hr />";
echo "<h2>Notifica esito</h2>";
$response = $client->notificaEsito();
print_r(print_output($response));

echo "<hr />";
echo "<h2>Notifica decorrenza termini</h2>";
$response = $client->notificaDecorrenzaTermini();
print_r(print_output($response));

echo "<hr />";
echo "<h2>Attestazione trasmissione fattura</h2>";
$response = $client->attestazioneTrasmissioneFattura();
print_r(print_output($response));


