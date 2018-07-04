<?php
require_once ("../../config.php");

$soap = new soap_server();
$soap->debug_flag = false;

$endpoint = ENDPOINT . "marco/soap/test.php";
$soap->configureWSDL('RicezioneFatture_v1');
$soap->wsdl->schemaTargetNamespace = $endpoint;
$soap->register("test",
                array('name'=>'xsd:string'),
                array('return'=>'xsd:string')               
            );

$soap->service(isset($HTTP_RAW_POST_DATA) ?
               $HTTP_RAW_POST_DATA : '');

function test($msg){
      return "ecco: $msg";
}