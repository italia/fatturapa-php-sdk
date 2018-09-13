<?php
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
    $xml = simplexml_load_file($path);
    
    //FatturaElettronicaHeader - DatiTrasmissione
    global $DatiTrasmissioneIdPaese; 
    global $DatiTrasmissioneIdCodice;
    global $ProgressivoInvio;
    global $FormatoTrasmissione;
    global $CodiceDestinatario;

    $DatiTrasmissioneIdPaese = $xml->FatturaElettronicaHeader[0]->DatiTrasmissione[0]->IdTrasmittente[0]->IdPaese;
    $DatiTrasmissioneIdCodice = $xml->FatturaElettronicaHeader[0]->DatiTrasmissione[0]->IdTrasmittente[0]->IdCodice;
    $ProgressivoInvio = $xml->FatturaElettronicaHeader[0]->DatiTrasmissione[0]->ProgressivoInvio;
    $FormatoTrasmissione =  $xml->FatturaElettronicaHeader[0]->DatiTrasmissione[0]->FormatoTrasmissione;
    $CodiceDestinatario =  $xml->FatturaElettronicaHeader[0]->DatiTrasmissione[0]->CodiceDestinatario;

    //FatturaElettronicaHeader - CedentePrestatore
    global $CedentePrestatoreIdPaese; 
    global $CedentePrestatoreIdCodice;
    global $Denominazione;
    global $RegimeFiscale;
    global $CedentePrestatoreIndirizzo;
    global $CedentePrestatoreCap;
    global $CedentePrestatoreComune;
    global $CedentePrestatoreProvincia;
    global $CedentePrestatoreNazione;

    $CedentePrestatoreIdPaese = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->DatiAnagrafici[0]->IdFiscaleIVA[0]->IdPaese;
    $CedentePrestatoreIdCodice = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->DatiAnagrafici[0]->IdFiscaleIVA[0]->IdCodice;
    $Denominazione = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->DatiAnagrafici[0]->Anagrafica[0]->Denominazione;
    $RegimeFiscale = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->DatiAnagrafici[0]->RegimeFiscale;
    $CedentePrestatoreIndirizzo = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->Sede[0]->Indirizzo;
    $CedentePrestatoreCap = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->Sede[0]->CAP;
    $CedentePrestatoreComune = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->Sede[0]->Comune;
    $CedentePrestatoreProvincia = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->Sede[0]->Provincia;
    $CedentePrestatoreNazione = $xml->FatturaElettronicaHeader[0]->CedentePrestatore[0]->Sede[0]->Nazione;
    
    global $CessionarioCommittenteCodicefiscale;
    global $Anagrafica;
    global $IndirizzoCessionario;
    global $CapCessionario;
    global $ComuneCessionario;
    global $ProvinciaCessionario;
    global $NazioneCessionario;
    

    // CessionarioCommittente
    $CessionarioCommittenteCodicefiscale = $xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->DatiAnagrafici[0]->CodiceFiscale;
    $Anagrafica = $xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->DatiAnagrafici[0]->Anagrafica[0]->Denominazione;
    $Anagrafica = $xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->DatiAnagrafici[0]->Anagrafica[0]->Denominazione;
    $IndirizzoCessionario=$xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->Sede[0]->Indirizzo;
    $CapCessionario=$xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->Sede[0]->CAP;
    $ComuneCessionario=$xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->Sede[0]->Comune;
    $ProvinciaCessionario=$xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->Sede[0]->Provincia;
    $NazioneCessionario=$xml->FatturaElettronicaHeader[0]->CessionarioCommittente[0]->Sede[0]->Nazione;

    //FatturaElettronicaBody - Dati Generali Documento 
    global $TipoDocumentoBody; 
    global $DivisaBody;
    global $DataBody;
    global $NumeroBody;
    global $CausaleBody;

    $TipoDocumentoBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiGeneraliDocumento[0]->TipoDocumento;
    $DivisaBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiGeneraliDocumento[0]->Divisa;
    $DataBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiGeneraliDocumento[0]->Data;
    $NumeroBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiGeneraliDocumento[0]->Numero;
    $CausaleBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiGeneraliDocumento[0]->Causale;

    //FatturaElettronicaBody - Dati Ordine Acquisto 
    global $RiferimentoNumero; 
    global $IdDocumentoBody;
    global $NumItemBody;

    $RiferimentoNumero = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiOrdineAcquisto[0]->RiferimentoNumeroLinea;
    $IdDocumentoBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiOrdineAcquisto[0]->IdDocumento;
    $NumItemBody = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiOrdineAcquisto[0]->NumItem;

    //FatturaElettronicaBody - Dati trasporto
    global $IdPaeseTrasporto;
    global $IdCodiceTrasporto;
    global $AnagraficaTrasporto;
    global $DataOra;

    $IdPaeseTrasporto = $xml->FatturaElettronicaBody[0]->DatiGenerali->DatiTrasporto[0]->DatiAnagraficiVettore[0]->IdFiscaleIVA[0]->IdPaese;
    $IdCodiceTrasporto =$xml->FatturaElettronicaBody[0]->DatiGenerali->DatiTrasporto[0]->DatiAnagraficiVettore[0]->IdFiscaleIVA[0]->IdCodice;
    $AnagraficaTrasporto =$xml->FatturaElettronicaBody[0]->DatiGenerali->DatiTrasporto[0]->DatiAnagraficiVettore[0]->Anagrafica[0]->Denominazione;
    $DataOra =$xml->FatturaElettronicaBody[0]->DatiGenerali->DatiTrasporto[0]->DataOraConsegna;

    //FatturaElettronicaBody - Righe della fattura

    global $NumeroLineaRiga;
    global $DescrizioneRiga;
    global $QuantitaRiga;
    global $PrezzoUnitarioRiga;
    global $PrezzoTotaleRiga;
    global $AliquotaIVARiga;

    $NumeroLineaRiga =$xml->FatturaElettronicaBody[0]->DatiBeniServizi;

    //FatturaElettronicaBody - Dati riepilogo fattura

    global $AliquotaIVARiepilogo;
    global $ImponibileImportoRiepilogo;
    global $ImpostaRiepilogo;
    global $EsigibilitaIVARiepilogo;

    $AliquotaIVARiepilogo =$xml->FatturaElettronicaBody[0]->DatiBeniServizi->DatiRiepilogo->AliquotaIVA;
    $ImponibileImportoRiepilogo =$xml->FatturaElettronicaBody[0]->DatiBeniServizi->DatiRiepilogo->ImponibileImporto;
    $ImpostaRiepilogo =$xml->FatturaElettronicaBody[0]->DatiBeniServizi->DatiRiepilogo->Imposta;
    $EsigibilitaIVARiepilogo =$xml->FatturaElettronicaBody[0]->DatiBeniServizi->DatiRiepilogo->EsigibilitaIVA;


    //FatturaElettronicaBody - Dati pagamento

    global $CondizioniPagamentoRiepilogo;
    global $ModalitaPagamentoRiepilogo;
    global $DataScadenzaPagamentoRiepilogo;
    global $ImportoPagamentoRiepilogo;
    
    $CondizioniPagamentoRiepilogo =$xml->FatturaElettronicaBody[0]->DatiPagamento->CondizioniPagamento;
    $ModalitaPagamentoRiepilogo=$xml->FatturaElettronicaBody[0]->DatiPagamento->DettaglioPagamento->ModalitaPagamento;
    $DataScadenzaPagamentoRiepilogo=$xml->FatturaElettronicaBody[0]->DatiPagamento->DettaglioPagamento->DataScadenzaPagamento;
    $ImportoPagamentoRiepilogo=$xml->FatturaElettronicaBody[0]->DatiPagamento->DettaglioPagamento->ImportoPagamento;


}

if($DatiTrasmissioneIdPaese != ""): ?>


<div class="content-wrapper" style="min-height: 1126px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    <div class="invoice-box">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
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

                <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Cessionario Committente</b><br>
                                Codice Fiscale: <?php echo $CessionarioCommittenteCodicefiscale; ?><br>
                                Anagrafica: <?php echo $Anagrafica; ?><br>
                                Indirizzo: <?php echo $IndirizzoCessionario; ?><br>
                                CAP: <?php echo $CapCessionario; ?><br>
                                Comune: <?php echo $ComuneCessionario; ?><br>
                                Provincia: <?php echo $ProvinciaCessionario; ?><br>
                                Nazione: <?php echo $NazioneCessionario; ?><br>
                                
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
                                <b>Dati Generali Documento</b><br>
                                Dati Documento: <?php echo $TipoDocumentoBody; ?><br>
                                Divisa: <?php echo $DivisaBody; ?><br>
                                Data: <?php echo $DataBody; ?><br>
                                Numero: <?php echo $NumeroBody; ?><br>
                         
                                Causale: <?php echo $CausaleBody; ?><br>
                                Riferimento Numero Linea: <?php echo $RiferimentoNumero; ?><br>
                                Id Documento: <?php echo $IdDocumentoBody; ?><br>
                                Numero Item: <?php echo $NumItemBody; ?><br>
                               
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
                                            <b>Dati Trasporto</b><br>
                                            Id Paese: <?php echo $IdPaeseTrasporto; ?><br>
                                            Id Codice: <?php echo $IdCodiceTrasporto; ?><br>
                                            Anagrafica: <?php echo $AnagraficaTrasporto; ?><br>
                                            Data Ora Consegna: <?php echo $DataOra; ?><br>
                                        
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

<tr class="information">
                            <td colspan="4">
                            <table class="table">
  <thead>
    <tr>
      <th scope="col">N° Linea</th>
      <th scope="col">Descrizione</th>
      <th scope="col">Quantita</th>
      <th scope="col">Prezzo Unitario</th>
      <th scope="col">Prezzo Totale</th>
      <th scope="col">Aliquota IVA</th>
    </tr>
  </thead>
  <tbody>

<?php 

foreach($NumeroLineaRiga->DettaglioLinee as $rigaFattura){ 
    
    //var_dump( $rigaFattura); 
    
    ?>

    <tr>
      <th scope="row"><?php echo $rigaFattura->NumeroLinea; ?></th>
      <td><?php echo $rigaFattura->Descrizione; ?></td>
      <td><?php echo $rigaFattura->Quantita; ?></td>
      <td><?php echo $rigaFattura->PrezzoUnitario; ?></td>
      <td><?php echo $rigaFattura->PrezzoTotale; ?></td>
      <td><?php echo $rigaFattura->AliquotaIVA; ?></td>
    </tr>

<?php } ?> 

  </tbody>
</table>
                            </td>
                        </tr>

<tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Dati Riepilogo</b><br>
                                Aliquota IVA: <?php echo $AliquotaIVARiepilogo; ?><br>
                                Imponibile Importo: <?php echo $ImponibileImportoRiepilogo; ?><br>
                                Imposta: <?php echo $ImpostaRiepilogo; ?><br>
                                Esigibilità IVA: <?php echo $EsigibilitaIVARiepilogo; ?><br>
                         
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
                                <b>Dati Pagamento</b><br>
                                Condizioni Pagamento: <?php echo $CondizioniPagamentoRiepilogo; ?><br>
                                Modalità Pagamento: <?php echo $ModalitaPagamentoRiepilogo; ?><br>
                                Data Scadenza Pagamento: <?php echo $DataScadenzaPagamentoRiepilogo; ?><br>
                                Importo Pagamento Riepilogo :  <?php echo $ImportoPagamentoRiepilogo; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

 

    </div>

<?php endif ?>
