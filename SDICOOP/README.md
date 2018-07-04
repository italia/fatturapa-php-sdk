# SDICOOP php sdk

il presente pacchetto consente di interagire con i web services del Sistema di Interscambio (SdI) per la trasmissione e la ricezione delle fatture in formato elettronico

La documentazione tecnica dell'SdI è disponibile al seguente url http://www.fatturapa.gov.it/export/fatturazione/it/normativa/f-3.htm

Sostanzialmente si basa sulla SOAP extension di PHP sia come client che come server.

## Configurazione

Modificare il file soap/config.php con i propri parametri

## Accredito del canale
Si ricorda che una volta installato e configurato il server SOAP è necessario accreditare il canale http://sdi.fatturapa.gov.it/SdI2FatturaPAWeb/AccediAlServizioAction.do?pagina=accreditamento_canale

## Test WSDL con Postman
1. Inserire nell'URL la path dell'endpoint. Se si utilizza un WSDL inserire il suo path.
2. Impostare la richiesta con metodo POST.
3. Aprire l'editor raw e settare il body type come "text/xml".
4. Nel body inserire l'xml per richiamare la funzione SOAP inserendo Envelope, Header e Body della funzione.
```
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:hs="PATH–WSDL">
 <soapenv:Header></soapenv:Header>
 <soapenv:Body>
 <hs:NOME_FUNZIONE>
 <hs:VARIABILE>VALORE</hs:VARIABILE>
 </hs:NOME_FUNZIONE>
 </soapenv:Body>
</soapenv:Envelope>
```
5. Invia richiesta e fai debug
