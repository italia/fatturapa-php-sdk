<?php

$client = new SoapClient( "http://localhost/soap/organization.wsdl", array( 'cache_wsdl' => WSDL_CACHE_NONE ) );
$responseLogin = $client->login( 'test_user', 'test_password' );
$response = $client->doFilter( "test" );
var_dump($responseLogin);
var_dump($response);