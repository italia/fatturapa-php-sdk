<?php

require_once(__DIR__."/vendor/autoload.php");

//server trasmittente
$st 	= "https://teamdigitale1.simevo.com/marco/soap/server/";

//wsdl trasmissione fatture
$tfwsdl = "TrasmissioneFatture_v1.1.wsdl";

//wsdl ricezione fatture
$rfwsdl = "RicezioneFatture_v1.0.wsdl";

//end point trasmissione fatture trasmittente
$eptft 	= $st . "trasmissione-fatture.php?wsdl";

//end point ricezione fatture
$eptrf 	= $st . "ricezione-fatture.php?wsdl";