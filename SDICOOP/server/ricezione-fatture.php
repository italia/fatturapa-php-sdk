<?php
ini_set( "soap.wsdl_cache_enabled", 0 );
ini_set( 'soap.wsdl_cache_ttl', 0 );
include("../config.php");

/*
*	I seguenti end point vengono esposti dal trasmittente
*	per ricevere le fatture inviate tramite SDI
*	E' possibile simulare le chiamate a questi end point dal file /client/tf_ricezione_fatture.php
*/

function riceviFatture() {
  
	//parse request

}

function notificaDecorrenzaTermini() {
  
	//parse request

}


$server = new SoapServer( $rfwsdl );

$server->addFunction( "riceviFatture" );
$server->addFunction( "notificaDecorrenzaTermini" );
$server->handle();

