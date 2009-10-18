/*  Copyright 2007  Giacomo Boccardo  (email : gboccard@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 


var _logger = false;                 // scrive l'ouput nell'area di log
var _status_area;                    // id dell'elemento in cui scrivere il log
var _ms_XMLHttpRequest_ActiveX = ""; // Tipo di ActiveX da istanziare



/*
 *  Funzione per aggiungere un evento ad un elemento
 */
function addEvent(obj, evType, fn){
    if(obj.addEventListener) obj.addEventListener(evType, fn, false);
    else if(document.addEventListener && obj == window) document.addEventListener(evType, fn, false);
    else {
        if(!obj[evType]) obj[evType] = new Array;
        if(!obj[fn]) obj[fn] = fn;
        obj[evType][obj[evType].length] = obj[fn];
        obj["on" + evType] = function(){
            for(var i = 0; i < obj[evType].length; i++){
                obj[obj[evType][i]](window.event);
            }
        };
    }
}


/*
 *	getFormatterByNumber: rstituisce il nome del formatter, data la posizione nell'array dei DF
 *	INPUT:
 *		* formatterNum: indice della posizione del formatter nell'array dei DF
 *	OUTPUT:
 *		* Il nome del formatter
 *	SIDE/EFFECTS:
 *		* nulla
 */
function getFormatterByNumber(formatterNum)
{
    return DF[formatterNum].name;
}


/*
 *  getAllSheets: ottiene l'elenco dei fogli di stile presenti nella pagina
 *
 *  INPUT:
 *      * nulla
 *  OUTPUTL
 *      * Un array contenente i fogli di stile presenti nel documento
 *  SIDE-EFFECTS:
 *      * nulla
 */
function getAllSheets() {
    if( !window.ScriptEngine && navigator.__ice_version ) { return document.styleSheets; }  //FF
    if( document.getElementsByTagName ) { var Lt = document.getElementsByTagName('link'), St = document.getElementsByTagName('style');
    } else if( document.styleSheets && document.all ) { var Lt = document.all.tags('LINK'), St = document.all.tags('STYLE');
    } else { return []; } for( var x = 0, os = []; Lt[x]; x++ ) {
        var rel = Lt[x].rel ? Lt[x].rel : Lt[x].getAttribute ? Lt[x].getAttribute('rel') : '';
        if( typeof( rel ) == 'string' && rel.toLowerCase().indexOf('style') + 1 ) { os[os.length] = Lt[x]; }
    } for( var x = 0; St[x]; x++ ) { os[os.length] = St[x]; } return os;
} 


/*
 *	logger:	salva le informazioni relative a comunicazioni AJAX in un'area di testo
 *	INPUT: 
 *		* text: la stringa da scrivere nell'area di testo
 *		* clear: booleano che indica se svuotare o meno l'area di testo prima di scrivervi
 *	OUTPUT:
 *	 	* nulla
 *	SIDE-EFFECTS:
 *		* Scrive una stringa in un'area di testo
 */
function logger(text, clear) 
{
	if (_logger) 
	{
    	if (!_status_area) 
		{
        	_status_area = document.getElementById("status_area");
        }

        if (_status_area) 
		{
            if (clear) 
			{
                _status_area.value = "";
            }

            var old = _status_area.value;
            _status_area.value = text + ((old) ? "\r\n" : "") + old;
        }
    }
}


/*
 *	encode: dodifica un URI (escape e' deprecato, quindi si prova come seconda chance)
 *	
 *	INPUT: 
 *		* uri: un URI non codificato
 *	OUTPUT
 *		* una stringa contenente l'URI codificato
 * 	SIDE-EFFECTS:
 *		* nulla
 */
function encode(uri) {
    if (encodeURIComponent) {
        return encodeURIComponent(uri);
    }

    if (escape) {
        return escape(uri);
    }
}

/*
 *	decode: dedodifica un URI (unescape e' deprecato, quindi si prova come seconda chance)
 *	
 *	INPUT: 
 *		* uri: un URI codificato da "encode"
 *	OUTPUT
 *		* una stringa contenente l'URI decodificato
 * 	SIDE-EFFECTS:
 *		* nulla
 */
function decode(uri) {
    if (decodeURIComponent) {
        return decodeURIComponent(uri);
    }

    if (unescape) {
        return unescape(uri);
    }
}




/*
 *	executeReturn: funzione invocata di default per gestire la ricezione di dati nel caso in cui non ne venga specificata una al momento dell'istanziazione della comunicazione AJAX; si limita ad eseguire i dati ricevuti con "eval"
 *
 *	INPUT: 
 *		* AJAX: un oggetto XMLhttpRequest
 *	OUTPUT:
 *    	* nulla
 * 	SIDE-EFFECTS:
 *		* Esegue i dati ricevuti in responseText
 */
function executeReturn( AJAX ) 
{
	// Se la richiesta e' stata completata e lo stato della richiesta e' OK
	if (AJAX.readyState == 4 && AJAX.status == 200) 
	{
        logger('AJAXRequest completata: ' + AJAX.readyState + "/" + AJAX.status + "/" + AJAX.statusText);
		// Se si sono ottenuti dei dati dal server
	    if ( AJAX.responseText ) 
		{
		    logger(AJAX.responseText);
		    logger("-----------------------------------------------------------");
			// si eseguono i dati ricevuti
		    eval(AJAX.responseText);
	    }
    }
}






/*
 *	getXMLhttp: restituisce un oggetto XMLhttpRequest per IE o per FF&Co.
 * 
 *	INPUT: 
 *		* nulla 
 *	OUTPUT: 
 *		* un oggetto XMLhttpRequest per IE o per FF&Co, null in caso di mancato supporto
 *	SIDE-EFFECTS:
 *		* nulla
 */
function getXMLhttp()
{
    // Se si usa FF&Co. ...
    if (window.XMLHttpRequest) 
	{
		return new XMLHttpRequest();
	// ...altrimenti se si utilizza IE
    } else if (window.ActiveXObject) {

        // ...se e' stato specificato un oggetto ActiveX precedentemente...
        if (_ms_XMLHttpRequest_ActiveX) 
		{
            return new ActiveXObject(_ms_XMLHttpRequest_ActiveX);
        } else { 
			// ...altrimenti si testano le varie versioni di XMLHTTP per utilizzare la piu' recente...
		    var versions = ["Msxml2.XMLHTTP.7.0", "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP"];
        	for (var i = 0; i < versions.length ; i++) 
			{
                try {
				    // ...si prova a creare l'oggetto ActiveX...
                    return new ActiveXObject(versions[i]);
	
					// ...e, se va tutto bene, ci si salva la versione per velocizzare la creazione di richieste successive...
        /*            if ( self.AJAX ) 
					{
                        _ms_XMLHttpRequest_ActiveX = versions[i];
                        break;
                    }ml2.XMLHT
*/
                }
                catch (objException) 
				{
                	// ...atrimenti si ricomincia il ciclo e si prova una versione meno recente...
                };
            };
        }

		if ( _ms_XMLHttpRequest_ActiveX == "" ) return null;

    }
}



/*
 *	AJAXRequest: crea una richiesta AJAX.
 *
 * 	INPUT:
 *  	* method	=> 	metodo con cui effetturare la richiesta: GET o POST
 *    	* url 		=>	URL cui fare la richiesta (con eventuali parametri per la GET)
 *    	* data		=>	eventuali dati da inviare se la richiesta è POST
 *    	* process	=>	funzione da invocare alla ricezione dei dati (di default executeReturn)
 *    	* async		=>	modalita' di invio: true o false per asincrona e sincrona (di default asincrona)
 *    	* dosend	=>	0 non invia i dati, 1 si' (di default invia)
 *	OUTPUT: 
 *		* un oggetto XMLhttpRequest
 *	SIDE-EFFECTS:
 *		* nulla
 */
function AJAXRequest( method, url, data, process, async, dosend ) 
{
	var self = this;
	baseURL = "http://gboccard.web.cs.unibo.it/";

	// Si sostituiscono gli spazi con un "+" altrimenti, a causa delle RewriteRule, non va un piffero!!!
	url = url.replace(/%20/g,"+");

	// Si sfrutta una RewriteRule per poter interrogare siti esterni eludendo le misure di sicurezza del protocollo AJAX
	url = baseURL+"call/"+url;	

	
	// Si ottiene un oggetto XMLhttpRequest
	self.AJAX = getXMLhttp();
    
    // Se non esiste una funzione di callback, ne viene specificata una di default 
	// che si limita ad eseguire il codice ottenuto dal server
    if ( typeof process == 'undefined' ) 	process = executeReturn;

	// Se viene specificata una funzione di callback da eseguire sui valori di ritorno della richiesta AJAX...
	if ( process != null )
	{
    	self.process = process;

	    // ...si crea una funzione anonima che viene eseguita alla ricezione di una risposta dal server...
    	self.AJAX.onreadystatechange = function( ) 
		{
    		logger("AJAXRequest Handler: Stato =  " + self.AJAX.readyState);
	
			if ( self.AJAX.readyState == 4 && self.AJAX.status == 200 )
			{
				logger('AJAXRequest completata: ' + self.AJAX.readyState + "/" + self.AJAX.status + "/" + self.AJAX.statusText);
		       	if ( self.AJAX.responseText )
   		   		{
   					logger(self.AJAX.responseText);
		            logger("-----------------------------------------------------------");
				}
			}

			// ...e viene invocata la funzione per gestire i dati ricevuti
        	self.process(self.AJAX); 
    	}
	}

    // Se non viene specificato un metodo per l'invio della richiesta, si assume POST
    if ( !method )	method = "POST";
    method = method.toUpperCase();

	// Se non viene specificata la modalita' di invio, si assume ASINCRONA
    if (typeof async == 'undefined' || async == null)	async = true;

    logger("----------------------------------------------------------------------");
    logger("AJAX Request: " + ((async) ? "Async" : "Sync") + " " + method + ": URL: " + url + ", Data: " + data);

	
	// Si specificano i parametri di connessione	
   	self.AJAX.open(method, url, async);

    if (method == "POST") 
	{
        self.AJAX.setRequestHeader("Connection", "close");
        self.AJAX.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        self.AJAX.setRequestHeader("Method", "POST " + url + "HTTP/1.1");
    }

    // Fallisce solo se dosend e' false
	// Da utilizzare per l'invio di header particolari
    if ( dosend || typeof dosend == 'undefined' ) 
	{
	    if ( !data | method  == "GET") data=""; 

	   	self.AJAX.send(data);
    }

	
    return self.AJAX;
}




/*
 *	returnXML: funzione che, dato un oggetto XMLhttpRequest restituisce il risultato della chiamata in un documento XML
 *
 *	INPUT: 
 *		* AJAX: un oggetto XMLhttpRequest
 *	OUTPUT:
 *    	* Ritorna il DOM Document del documento XML risultante dalla chiamata
 * 	SIDE-EFFECTS:
 *		* nulla
 */
function returnXML ( AJAX )
{
    if (window.XMLHttpRequest)
    {
		var domParser = new DOMParser ();
		return domParser.parseFromString (AJAX.responseText, "text/xml");

    }
    else if (window.ActiveXObject)
    {
        var xmlDoc = new ActiveXObject ("Microsoft.XMLDOM");
        xmlDoc.loadXML (AJAX.responseText);
        return xmlDoc;
    }
}



/*
  /  						 			 		 \
 <			FUNZIONI VECCHIE PRE-SARISSA		  >
  \  											 /
*/





/*	
 *	emptyXMLDoc: resistuisce un documento XML...ovviamente vuoto
 *
 * 	INPUT: 
 *		* root: la radice del documento XML
 *	OUTPUT: 
 *		* Un documento XML, null in caso di errore
 *	SIDE-EFFECTS:
 *		* nulla
 */
function emptyXMLdoc(root)
{
    var xml;
	// Se si usa IE...
    if ( window.ActiveXObject ) {
        xml = new ActiveXObject("Microsoft.XMLDOM");
	// ...altrimenti se si usa FF...
    } else if ( document.implementation && document.implementation.createDocument ) {
        xml = document.implementation.createDocument("","",null);
	// ...altrimenti...sfiga!
    } else {
        alert("emptyXMLDoc: impossibile creare un documento XML vuoto");
        return null;
    }

    return xml;
}



/*
 *	stringToXML: data una stringa che contiene XML, restituisce un documento XML
 *
 *	INPUT: 
 *		* string: una stringa contente XML
 *	OUTPUT: 
 *		* Un documento XML, null in caso di errore
 * 	SIDE-EFFECTS:
 *		* nulla
 */
function stringToXML(string)
{
	// Si rimuove tutto quello che causa danni!!! (cioe' tutto quello prima di ?xml... e dopo la chiusura dell'ultimo elemento
	string = string.substring(string.indexOf("<"), string.lastIndexOf(">")+1);

	// Se si usa FF...
    if ( window.XMLHttpRequest ) {
        var domParser = new DOMParser();
        return domParser.parseFromString (string, "text/xml");
	// ...altrimenti se si usa IE...
    } else if (window.ActiveXObject) {
        var xml = new ActiveXObject ("Microsoft.XMLDOM");
        xml.async = false;
        xml.loadXML (xml);
        return xml;
	// ...altrimenti...sfiga!
    } else {
        alert ("stringToXML: impossibile trasformare la stringa in un documento XML");
        return null;
    }
}

/*
 *	i8IE_responseXML: come la funzione sopra stringToXML, gestisce il bug di IE che non permette di usare responseXML
 *
 *  INPUT: 
 * 		* httpreq: un oggetto XMLhttpRequest
 *  OUTPUT: 
 *		* Un documento XML, null in caso di errore
 *	SIDE-EFFECTS:
 *		* nulla	
 */
function i8IE_responseXML(httpreq)
{
	// Se si usa FF&Co. ...
	if ( document.implementation && document.implementation.createDocument ) {
		xml = httpreq.responseXML;
	// ...altrimenti se si usa IE...
	} else if (window.ActiveXObject){
		// ...si crea un elemento qualsiasi...
		var xml = document.createElement('xml');
		// ...nel quale si inserisce responseText...
		xml.setAttribute('innerHTML',httpreq.responseText);
		// ...si imposta un id per recuperarlo in seguito...
		xml.setAttribute('id','_xml');
		// ...si aggiunte l'elemento al body...
		document.body.appendChild(xml);
		// ...per sicurezza si mette responseText all'interno dell'elemento...
		document.getElementById('_xml').innerHTML = httpreq.responseText;
		// ...si recupera l'elemento e lo si salva in una variabile...
		xml = document.getElementById('_xml');
		// ...si rimuove l'elemento...
		document.body.removeChild(document.getElementById('_xml'));
	// ...altrimenti...sfiga!
	}else{
		alert("i8IE_responseXML: il browser non supporta XML");
		return null;
	}

	return xml;
}

/*
 *	XMLtoString: dato un documento XML, lo restituisce sottoforma di stringa
 *
 *	INPUT: 
 *		* xmlDoc: un documento XML
 * 	OUTPUT: 
 *		* Una stringa rappresentante il documento XML
 *	SIDE-EFFETS:
 *		* nulla
 */
function XMLtoString(xmlDoc)
{
	// Se si usa IE...
    if (xmlDoc.xml) {
		return xmlDoc.xml;
	// ...altrimenti se si usa FF...
    } else {
		 return (new XMLSerializer()).serializeToString(xmlDoc);
	}

}


/*
  /   /						 			 		 \
 <   /		FUNZIONI VECCHIE PRE-SARISSA		  >
  \ / 											 /
*/
