<?php
ini_set( "soap.wsdl_cache_enabled", 0 );
ini_set( 'soap.wsdl_cache_ttl', 0 );
include("../config.php");

/*
*	I seguenti end point vengono esposti dal trasmittente
*	per ricevere i messaggi inviati dall'SDI
*	in seguito alla trasmissione di una fattura.
*	E' possibile simulare le chiamate a questi end point dal file /client/tf_ricezione_msg.php
*/

function ricevutaConsegna() {
  
	//parse request

}

function notificaMancataConsegna() {
  
	//parse request

}

function notificaScarto() {

	//parse request

}

function notificaEsito() {

	//parse request

}

function notificaDecorrenzaTermini() {

	//parse request

}

function attestazioneTrasmissioneFattura() {

	//parse request

}

$server = new SoapServer( $tfwsdl );

$server->addFunction( "ricevutaConsegna" );
$server->addFunction( "notificaMancataConsegna" );
$server->addFunction( "notificaScarto" );
$server->addFunction( "notificaEsito" );
$server->addFunction( "notificaDecorrenzaTermini" );
$server->addFunction( "attestazioneTrasmissioneFattura" );

$server->handle();

