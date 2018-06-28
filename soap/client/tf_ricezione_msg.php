<?php

include("../config.php");

$client = new SoapClient( $eptft, array( 'cache_wsdl' => WSDL_CACHE_NONE ));

$response = $client->ricevutaConsegna();
echo $response;
