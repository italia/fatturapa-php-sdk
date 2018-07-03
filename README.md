# fatturapa-php-sdk

fatturapa-php-sdk consente di interagire con i web services del Sistema di Interscambio (SdI) per la trasmissione allo stesso delle fatture in formato elettronico

La documentazione tecnica dell'SdI è disponibile al seguente url http://www.fatturapa.gov.it/export/fatturazione/it/normativa/f-3.htm

Sostanzialmente si basa sulla SOAP extension di PHP sia come client che come server.

## Configurazione

Modificare il file soap/config.php con i propri parametri

## Accredito del canale

Si ricorda che una volta installato e configurato il server SOAP è necessario accreditare il canale http://sdi.fatturapa.gov.it/SdI2FatturaPAWeb/AccediAlServizioAction.do?pagina=accreditamento_canale
