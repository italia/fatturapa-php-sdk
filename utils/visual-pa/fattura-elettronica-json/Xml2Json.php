<?php
// sample usage:
// curl -X POST -F 'xml=@samples/IT01234567890_FPA01.xml' http://localhost:8000/xml2json.php

declare(strict_types=1);

// Check file size
if ($_FILES["xml"]["size"] > 5*1024*1024) {
    echo "Sorry, your XML file is too large.";
    http_response_code(400);
    die;
}

require("Xml2Json.php");

$obj = new Simevo\Xml2Json($_FILES['xml']['tmp_name']);
echo $obj->result();
