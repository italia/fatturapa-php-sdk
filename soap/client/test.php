<?php

require_once ("../../config.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$endpoint = ENDPOINT . "marco/soap/server/test.php?wsdl";

$client = new nusoap_client($endpoint,"wsdl");
$client->setEndpoint($endpoint);
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$params = array("name" => "Marco");


$result = $client->call('prova', array('parameters' => $params), '', '', false, true);
if ($client->fault) {
    echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
} else {
    //var_dump($client);
    var_dump($result);
}

