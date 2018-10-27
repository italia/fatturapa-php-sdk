# fatturapa-php-sdk

fatturapa-php-sdk consente di interagire con il Sistema di Interscambio (SdI) per la trasmissione e la ricezione delle fatture in formato elettronico in base alle modalità di comunicazione rese disponibili

# SDICOOP

Consentirà di interagire attraverso i web services SOAP. 

Al momento lo sviluppo è in corso all'interno di [fatturapa-testsdi](https://github.com/italia/fatturapa-testsdi).

**fatturapa-testsdi** mette a disposizione un simulatore completo del Sistema d'Interscambio, dei trasmittenti e dei destinatari. È modulare e i suoi componenti sono pensati per essere usati indipendentemente:
- `core` usa l'ORM di Laravel (Illuminate Database) e implementa il database e i SOAP clients
- `soap` implementa i SOAP servers e usa `core`
- `rpc/packages/control` è un pacchetto Laravel che usa `core`
- `rpc/packages/ui` è un pacchetto Laravel che usa `rpc/packages/control`
- `rpc` è un app Laravel che mette insieme tutti i componenti e del sistema di test.

# SDIFTP

Consentirà di interagire tramite la trasmissione via FTP. 

# utils

contiene una serie di utilities in PHP che possono essere utilizzate all'interno delle proprie web app

