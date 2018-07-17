<?php
//test
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

/* Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
*/

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "xml") {
    echo "Sorry, only xml files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        read(basename($_FILES["fileToUpload"]["name"]), $target_dir);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


function read($filename, $target_dir) {
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
    $path = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . $target_dir . $filename;
    //$xml = simplexml_load_file($path);
    global $xml;
    $xml = file_get_contents($path);
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fattura Elettronica leggibile</title>
      <link rel="stylesheet" type="text/css" href="css/custom.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-italia.min.css">
      <link rel="stylesheet" type="text/css" href="css/italia-icon-font.css">   
</head>

<body>
    <script>  
        var xml = toString(" <?php echo $xml; ?> ");
        console.log(xml);

        function xmlToJson(xml) {
            alert("ok");
            // Create the return object
            var obj = {};

            if (xml.nodeType == 1) { // element
                // do attributes
                if (xml.attributes.length > 0) {
                obj["@attributes"] = {};
                    for (var j = 0; j < xml.attributes.length; j++) {
                        var attribute = xml.attributes.item(j);
                        obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
                    }
                }
            } else if (xml.nodeType == 3) { // text
                obj = xml.nodeValue;
            }

            // do children
            if (xml.hasChildNodes()) {
                for(var i = 0; i < xml.childNodes.length; i++) {
                    var item = xml.childNodes.item(i);
                    var nodeName = item.nodeName;
                    if (typeof(obj[nodeName]) == "undefined") {
                        obj[nodeName] = xmlToJson(item);
                    } else {
                        if (typeof(obj[nodeName].length) == "undefined") {
                            var old = obj[nodeName];
                            obj[nodeName] = [];
                            obj[nodeName].push(old);
                        }
                        obj[nodeName].push(xmlToJson(item));
                    }
                }
            }
            return obj;
        };
        var xmlDOM = new DOMParser().parseFromString(xml, 'text/xml');
        var json = xmlToJson(xmlDOM);
        echo(json);
    </script>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <?php echo $DatiTrasmissioneIdPaese; ?>
                            </td>
                            
                            <td>
                                <b>Dati Trasmissione</b><br>
                                Id Paese: <?php echo $DatiTrasmissioneIdPaese; ?><br>
                                Id Codice: <?php echo $DatiTrasmissioneIdCodice; ?><br>
                                Progressivo Invio: <?php echo $ProgressivoInvio; ?><br>
                                Codice Destinatario: <?php echo $CodiceDestinatario; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Cedente Prestatore</b><br>
                                Id Paese: <?php echo $CedentePrestatoreIdPaese; ?><br>
                                Id Codice: <?php echo $CedentePrestatoreIdCodice; ?><br>
                                Denominazione: <?php echo $Denominazione; ?><br>
                                Regime Fiscale: <?php echo $RegimeFiscale; ?><br>
                            </td>
                            
                            <td>
                                Indirizzo: <?php echo $CedentePrestatoreIndirizzo; ?><br>
                                CAP: <?php echo $CedentePrestatoreCap; ?><br>
                                Comune: <?php echo $CedentePrestatoreComune; ?><br>
                                Provincia: <?php echo $CedentePrestatoreProvincia; ?><br>
                                Nazione: <?php echo $CedentePrestatoreNazione; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Website design
                </td>
                
                <td>
                    $300.00
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Hosting (3 months)
                </td>
                
                <td>
                    $75.00
                </td>
            </tr>
            
            <tr class="item last">
                <td>
                    Domain name (1 year)
                </td>
                
                <td>
                    $10.00
                </td>
            </tr>
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <small>Fattura generata dal file <?php echo(basename( $_FILES["fileToUpload"]["name"])); ?><small>
                </td>
            </tr>            
        </table>
        
        <p></p>

    </div>
</body>
</html>