<?php

require_once ("../../config.php");

$endpoint = ENDPOINT . "marco/soap/server/test.php?wsdl";
$client = new nusoap_client($endpoint,"wsdl");

$params = array("name" => "Marco");

$result = $client->call('test', array('parameters' => $params), '', '', false, true);
if ($client->fault) {
    echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
} else {
    var_dump($result);
}
