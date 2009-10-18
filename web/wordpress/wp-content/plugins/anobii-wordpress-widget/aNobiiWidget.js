/*  Copyright 2008  Giacomo Boccardo  (email : gboccard@gmail.com)

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
 

var uid = "";
var progress = "";
var nBooks = "";
var recent = "";
var coverSize = "";
var removeNoCover = "";
var curPath = "";

function innerContent(elementid, content){
	document.getElementById(elementid).innerHTML = content;
	/*
	if (document.getElementById && !document.all)
	{
		rng = document.createRange();
		el = document.getElementById(elementid);
		rng.setStartBefore(el);
		htmlFrag = rng.createContextualFragment(content);
		while (el.hasChildNodes())
		{
			el.removeChild(el.lastChild);
		}
		el.appendChild(htmlFrag);
	}*/
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
	// Se si usa IE...
	if (window.ActiveXObject) {
        var xml = new ActiveXObject ("Microsoft.XMLDOM");
        xml.async = false;
        xml.loadXML (xml);
        return xml;
	} else if ( window.XMLHttpRequest ) { // Se si usa FF...
        var domParser = new DOMParser();
        return domParser.parseFromString (string, "text/xml");
	// ...altrimenti...sfiga!
    } else {
        alert ("stringToXML: impossibile trasformare la stringa in un documento XML");
        return null;
    }
}


function getDomAdapter()
{
	var adapter = '';
	if ('undefined' != typeof ActiveXObject) {
		adapter = 'MS';
	} else if ('undefined' != typeof document
		&& document.implementation
		&& document.implementation.createDocument
		&& 'undefined' != typeof DOMParser)
	{
		adapter = 'default';
	}
	switch (adapter) {
		case 'MS':
			return new (function () {
				this.createDocument = function () {
					var names = ["Msxml2.DOMDocument.6.0",
						"Msxml2.DOMDocument.3.0", "MSXML2.DOMDocument",
						"MSXML.DOMDocument", "Microsoft.XMLDOM"];
					for (var key in names) {
						try {
							return new ActiveXObject(names[key]);
						} catch (e) {}
					}
					throw new Error('Unable to create DOMDocument');
				};
				this.serialize = function (doc) {
					return doc.xml;
				};
				this.parseXml = function (xml) {
					var doc = this.createDocument();
					if (!doc.loadXML(xml)) {
						throw new Error('Parse error');
					}
					return doc;
				};
			})();
		case 'default':
			return new (function () {
				this.createDocument = function () {
					return document.implementation.createDocument("", "", null);
				};
				this.serialize = function (doc) {
					return new XMLSerializer().serializeToString(doc);
				};
				this.parseXml = function (xml) {
					var doc = new DOMParser().parseFromString(xml, "text/xml");
					if ("parsererror" == doc.documentElement.nodeName) {
						throw new Error('Parse error');
					}
					return doc;
				};
			})();
		default:
			throw new Error('Unable to select the DOM adapter');
	}
};



function getElementsByClassName(elementName,className) 
{
	var allElements = document.getElementsByTagName(elementName);
	var elemColl = new Array();
	for (var i = 0; i< allElements.length; i++) 
	{
			if (allElements[i].className == className)  
				elemColl[elemColl.length] = allElements[i];
	}
	return elemColl;
}
		
function convert2Xhtml(theHtml) 
{
	var html;
	html = theHtml;

	// Make xhtml compatible
	html = html.replace(/<.*>?>/g,function(m,p,s){return m.replace(/\s(\w+=)([#\w,;]+)/g,function(m,p,s){return ' ' + p.toLowerCase() + '"' + s+ '"';});});

	html = html.replace(/<(\/?\w+)([^>]*>)/g,function(m,p,s){return '<' + p.toLowerCase()+ s;});

	html = html.replace(/<(meta|base|basefont|param|link|img|br|hr|area|input)([^>]*)>/g,function(m,p,s){return m.indexOf(' />') == -1 ? '<' + p + s + ' />' : m;});

	// Add empty ALT if not present in the IMG tag
	html = html.replace(/<(img)([^>]*)\/>/g,function(m,p,s){return m.indexOf('alt=') == -1 ? '<' + p + s + ' alt="" />' : m;});
	return html;
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
    		//logger("AJAXRequest Handler: Stato =  " + self.AJAX.readyState);

			if ( self.AJAX.readyState == 4 && self.AJAX.status == 200 )
			{
				//logger('AJAXRequest completata: ' + self.AJAX.readyState + "/" + self.AJAX.status + "/" + self.AJAX.statusText);
		       	if ( self.AJAX.responseText )
   		   		{
   					//logger(self.AJAX.responseText);
		            //logger("-----------------------------------------------------------");
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

    //logger("----------------------------------------------------------------------");
    //logger("AJAX Request: " + ((async) ? "Async" : "Sync") + " " + method + ": URL: " + url + ", Data: " + data);


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




function evalRet(httpReq)
{
	//alert("HELLO ---> "+ httpReq.readyState +";"+ httpReq.status);
    if ( httpReq.readyState == 4 && httpReq.status == 200 ) {

		httpReqResult = httpReq.responseText;
		
		// Si evita document.write alla fine
		httpReqResult = httpReqResult.substring(0, httpReqResult.indexOf("document"));
							
		// Nella variabile b_txt c'è tutta la stringa con i risultati	
		
		
		eval(httpReqResult);
	
		b_txt = b_txt.replace(/&/g,"&amp;");

		
		// Si corregge il tag <img> in <img />
		b_txt = convert2Xhtml(b_txt);
		
		b_txt = "<div>"+b_txt+"</div>";
	

		/*
		<ul class="item_cell">
			<li class="cover">
				<a target="_blank" href="http://www.anobii.com/books/017686bfdec521ec85/">
		PUO NON ESSERCI ->	<img src="http://image.anobii.com/anobi/image_item.php?type=1&amp;isbn=8845290638" alt="Lo hobbit" title="Lo hobbit" />
				</a>
			</li>
			<li class="title">
				<a target="_blank" href="http://www.anobii.com/books/017686bfdec521ec85/">Lo hobbit</a>
			</li>
			<li class="author">John R. R. Tolkien</li>
		</ul>
		*/
		
		//xml = getXMLhttp();
		//xml = stringToXML(b_txt);

		// Nella variabile b_txt c'è tutta la stringa con i risultati	
		var xml = getDomAdapter().parseXml(b_txt);
		
	
	    uls = xml.getElementsByTagName('ul');
		
		var content = "";
		
		for (var i=0; i<uls.length; i++)
		{
			lis = uls[i].getElementsByTagName("li");
			
			coverUrl = "http://image.anobii.com/anobi/image_medium/no_image_small.gif";

			// C'e' il "li" della cover
			if ( lis.length == 3 )
			{
				startIndex = 1;
				coverUrl = ( lis[0].getElementsByTagName("img").length > 0) ? lis[0].getElementsByTagName("img")[0].getAttribute("src") : "http://image.anobii.com/anobi/image_medium/no_image_small.gif";
			}
			else
			{
				startIndex = 0;
			}
			

			if ( (lis.length != 3 && ! this.removeNoCover) || (lis.length == 3 && lis[startIndex].getElementsByTagName("a")[0].firstChild) )
			{
				anobiiUrl = lis[startIndex].getElementsByTagName("a")[0].getAttribute("href");
				title = lis[startIndex].getElementsByTagName("a")[0].firstChild.nodeValue;
				
				author="an unknown author";
				if (lis[startIndex+1].firstChild != null)	author = lis[startIndex+1].firstChild.nodeValue ;
		
				content += "<a href=\""+anobiiUrl+"\">";
				content += "<img src=\"" + coverUrl + "\" alt=\"" + title + ", by " + author + "\" title=\""+ title + ", by " + author + "\" />";
				content += "</a>";
			}

		}

		innerContent("anobiiBooks", content);

		// Gestione tasto reload
		//document.getElementById("anobiiReload").addEventListener("click", reload, false);

	}

}


function anobiiReload(e)
{
	//e.preventDefault();
	anobiiInit(this.curPath, this.uid, this.progress, this.nBooks, this.recent, this.coverSize, this.removeNoCover);
}


function anobiiInit(curPath, uid, progress, nBooks, recent, coverSize, removeNoCover)
{
	this.uid = uid;
	this.progress = progress;
	this.nBooks = nBooks;
	this.recent = recent;
	this.coverSize = coverSize;
	this.removeNoCover = removeNoCover;
	this.curPath = curPath;

	if ( uid == "" )
	{
		innerContent("anobiiBooks", "You must configure the plugin");
		return;
	}	
	urlAnobii = this.curPath+"proxy.php?uid="+this.uid+"&progress="+this.progress+"&nBooks="+this.nBooks+"&recent="+this.recent+"&coverSize="+this.coverSize+"&iHateIE="+Math.random();

	AJAXRequest("GET", urlAnobii, null, evalRet, true, 1);
}
