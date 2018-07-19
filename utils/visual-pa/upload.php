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
        $data = read(basename($_FILES["fileToUpload"]["name"]), $target_dir);
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
    $xml = new SimpleXMLElement($xml);
    return $xml;
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

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <?php ; ?>
                            </td>
                            
                            <td>
                                <b>Dati Trasmissione</b><br>
                                Id Paese: <?php echo $data->FatturaElettronicaHeader->DatiTrasmissione->IdTrasmittente->IdPaese; ?><br>
                                Id Codice: <?php echo $data->FatturaElettronicaHeader->DatiTrasmissione->IdTrasmittente->IdCodice;  ?><br>
                                Progressivo Invio: <?php echo $data->FatturaElettronicaHeader->DatiTrasmissione->ProgressivoInvio; ?><br>
                                Codice Destinatario: <?php echo $data->FatturaElettronicaHeader->DatiTrasmissione->CodiceDestinatario; ?><br>
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
                                Id Paese: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->DatiAnagrafici->IdFiscaleIVA->IdPaese; ?><br>
                                Id Codice: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->DatiAnagrafici->IdFiscaleIVA->IdCodice; ?><br>
                                Denominazione: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->DatiAnagrafici->Anagrafica->Anagrafica; ?><br>
                                Regime Fiscale: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->DatiAnagrafici->RegimeFiscale; ?><br>
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