<?php

ini_set( "soap.wsdl_cache_enabled", 0 );
ini_set( 'soap.wsdl_cache_ttl', 0 );
// carica classi composer
require_once(__DIR__."/vendor/autoload.php");
require_once(__DIR__."/soap/soap_handler.php");

define("ENDPOINT","https://teamdigitale1.simevo.com/");

//server trasmittente
$st     = "https://teamdigitale1.simevo.com/marco/soap/server/";

//wsdl trasmissione fatture
$tfwsdl = "TrasmissioneFatture_v1.1.wsdl";

//wsdl ricezione fatture
$rfwsdl = "RicezioneFatture_v1.0.wsdl";

//end point trasmissione fatture trasmittente
$eptft  = $st . "trasmissione-fatture.php?wsdl";

//end point ricezione fatture
$eptrf  = $st . "ricezione-fatture.php?wsdl";