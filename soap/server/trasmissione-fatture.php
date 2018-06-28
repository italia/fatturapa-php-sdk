<?php
ini_set( "soap.wsdl_cache_enabled", 0 );
ini_set( 'soap.wsdl_cache_ttl', 0 );

include("../config.php");

function ricevutaConsegna() {
  
	//parse request

}

function notificaMancataConsegna() {
  
	//parse request

}

$server = new SoapServer( $tfwsdl );

$server->addFunction( "ricevutaConsegna" );
$server->addFunction( "notificaMancataConsegna" );

$server->handle();

