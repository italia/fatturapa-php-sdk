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

<html>
<head>
    <meta charset="utf-8">
    <title>Fattura Elettronica leggibile</title>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-italia.min.css">
    <link rel="stylesheet" type="text/css" href="css/italia-icon-font.css">   
    <script src="js/jspdf.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script>
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#content')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('Test.pdf');
            }, margins
        );
    }
</script>
</head>

<body>
        <a href="javascript:demoFromHTML()" class="button">Download PDF</a>

    <div class="invoice-box" id="content">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td>
                    <table>
                        <tr>                            
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
                <td>
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
                                Indirizzo: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Indirizzo; ?><br>
                                CAP: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->CAP; ?><br>
                                Comune: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Comune; ?><br>
                                Provincia: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Provincia; ?><br>
                                Nazione: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Nazione; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td>
                    <table>
                        <tr>
                            <td>
                                <b>Concessionario/Committente</b><br>
                                Codice Fiscale: <?php echo $data->FatturaElettronicaHeader->CessionarioCommittente->DatiAnagrafici->CodiceFiscale; ?><br>
                                Denominazione: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->DatiAnagrafici->Anagrafica->Denominazione; ?><br>
                                Indirizzo: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Indirizzo; ?><br>
                                CAP: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->CAP; ?><br>
								Comune: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Comune; ?><br>
								Provincia: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Provincia; ?><br>
								Nazione: <?php echo $data->FatturaElettronicaHeader->CedentePrestatore->Sede->Nazione; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>   
            <tr class="heading">
                <td colspan="2">
                    Corpo della fattura: dati generali
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Tipo di documento
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->TipoDocumento; ?>
                </td>
            </tr>
            <tr class="details">
                <td>
                    Divisa
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->Divisa; ?>
                </td>
            </tr> 
            <tr class="details">
                <td>
                    Data
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->Data; ?>
                </td>
            </tr>
            <tr class="details">
                <td>
                    Numero
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->Numero; ?>
                </td>
            </tr>			
            <tr class="details">
                <td>
                    Causale
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiGeneraliDocumento->Causale; ?>
                </td>
            </tr>
            <tr class="heading">
                <td colspan="2">
                    Ordine Acquisto
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Rif. num. linea
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiOrdineAcquisto->RiferimentoNumeroLinea; ?>
                </td>
            </tr>
			
            <tr class="item">
                <td>
                    ID documento
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiOrdineAcquisto->IdDocumento; ?>
                </td>
            </tr>			
            
            <tr class="item">
                <td>
                    Numero oggetto
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiOrdineAcquisto->NumItem; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCUP
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiOrdineAcquisto->CodiceCUP; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCIG
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiOrdineAcquisto->CodiceCIG; ?>
                </td>
            </tr>    
			<!-- fine ordine acquisto -->
			<!-- dati contratto -->
            <tr class="heading">
                <td colspan="2">
                    Dati contratto
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Rif. num. linea
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->RiferimentoNumeroLinea; ?>
                </td>
            </tr>
			
            <tr class="item">
                <td>
                    ID documento
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->IdDocumento; ?>
                </td>
            </tr>			
            
            <tr class="item">
                <td>
                    Numero oggetto
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->NumItem; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCUP
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->CodiceCUP; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCIG
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->CodiceCIG; ?>
                </td>
            </tr>    			
			<!-- fine dati contratto -->
			<!-- dati convenzione -->
            <tr class="heading">
                <td colspan="2">
                    Dati convenzione
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Rif. num. linea
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiConvenzione->RiferimentoNumeroLinea; ?>
                </td>
            </tr>
			
            <tr class="item">
                <td>
                    ID documento
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiConvenzione->IdDocumento; ?>
                </td>
            </tr>			
            
            <tr class="item">
                <td>
                    Numero oggetto
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiConvenzione->NumItem; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCUP
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiContratto->CodiceCUP; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCIG
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiConvenzione->CodiceCIG; ?>
                </td>
            </tr>  			
			<!-- fine dati convenzione -->
			<!-- dati ricezione -->
            <tr class="heading">
                <td colspan="2">
                    Dati ricezione
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Rif. num. linea
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiRicezione->RiferimentoNumeroLinea; ?>
                </td>
            </tr>
			
            <tr class="item">
                <td>
                    ID documento
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiRicezione->IdDocumento; ?>
                </td>
            </tr>			
            
            <tr class="item">
                <td>
                    Numero oggetto
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiRicezione->NumItem; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCUP
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiRicezione->CodiceCUP; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    CodiceCIG
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiRicezione->CodiceCIG; ?>
                </td>
            </tr> 
			<!-- fine dati ricezione -->
			<!-- inizio dati trasporto -->
           <tr class="heading">
                <td colspan="2">
                    Dati trasporto
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    ID Paese
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiTrasporto->DatiAnagraficiVettore->IdFiscaleIVAIdFiscaleIVA->IdPaese; ?>
                </td>
            </tr>
			
            <tr class="item">
                <td>
                    ID codice
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiTrasporto->DatiAnagraficiVettore->IdFiscaleIVAIdFiscaleIVA->IdCodice; ?>
                </td>
            </tr>			
            
            <tr class="item">
                <td>
                   Denominazione
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiTrasporto->DatiAnagraficiVettore->Anagrafica->Denominazione; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Data e Ora Consegna
                </td>
                
                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiGenerali->DatiTrasporto->DataOraConsegna; ?>
                </td>
            </tr>
			<!-- fine dati trasporto -->
			<!-- inizio dettaglie linee FOREACH* -->
			<tr class="heading">
				<td colspan="2">
					Dati Beni/servizio dettaglio linee
				</td>
			</tr>
			<!-- foreach DettaglioLinee -->
			<tr class="item">
				<td>
					Nr. linea
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->NumeroLinea; ?>
				</td>
			</tr>
			<tr class="item">
				<td>
					Descrizione
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->Descrizione; ?>
				</td>
			</tr>
			<tr class="item">
				<td>
					Quantita
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->Quantita; ?>
				</td>
			</tr>
			<tr class="item">
				<td>
					Prezzo Unitario
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->PrezzoUnitario; ?>
				</td>
			</tr>
			<tr class="item">
				<td>
					Prezzo totale
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->PrezzoTotale; ?>
				</td>
			</tr>
			<tr class="item">
				<td>
					Aliquota IVA
				</td>

				<td>
					<?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DettaglioLinee->AliquotaIVA; ?>
				</td>
			</tr>			
			<!-- fine foreach -->
			<!-- fine dettaglio linee -->
            <!-- inizio riepilogo -->
            <tr class="heading">
                <td colspan="2">
                    Dati riepilogo
                </td>
            </tr>
            <tr class="item">
                <td>
                    Aliquota IVA
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DatiRiepilogo->AliquotaIVA; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Imponibile Importo
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DatiRiepilogo->ImponibileImporto; ?>
                </td>
            </tr>
             <tr class="item">
                <td>
                    Imposta
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DatiRiepilogo->Imposta; ?>
                </td>
            </tr>
             <tr class="item">
                <td>
                    EsigibilitaIVA
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiBeniServizi->DatiRiepilogo->EsigibilitaIVA; ?>
                </td>
            </tr>
            <!-- fine dati riepilogo -->
            <!-- inizio DatiPagamento -->
            <tr class="heading">
                <td colspan="2">
                    Dati pagamento
                </td>
            </tr>
            <tr class="item">
                <td>
                    Condizioni pagamento
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiPagamento->CondizioniPagamento; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Modalità pagamento
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiPagamento->DettaglioPagamento->ModalitaPagamento; ?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    DataScadenzaPagamento
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiPagamento->DettaglioPagamento->DataScadenzaPagamento; ?>
                </td>
            </tr>
            <tr class="total">
                <td>
                    Importo Pagamento
                </td>

                <td>
                    <?php echo $data->FatturaElettronicaBody->DatiPagamento->DettaglioPagamento->ImportoPagamento; ?>
                </td>
            </tr>

            <tr>
                <td class="centered">
                    <small>Fattura generata dal file <?php echo(basename( $_FILES["fileToUpload"]["name"])); ?><small>
                </td>
            </tr>            
        </table>
        
    </div>
</body>
</html>