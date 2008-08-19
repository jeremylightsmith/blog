<?php
ini_set('display_errors', 0);
require_once("../../../../wp-config.php");
header('Content-Type: text/javascript');
header('Cache-Control: no-cache');
header('Pragma: no-cache');
global $flickr_manager;
?>

hs.graphicsDir = '<?php 
$p = parse_url($flickr_manager->getAbsoluteUrl()); 
echo $p['path'];
?>/images/graphics/';
hs.outlineType = 'rounded-white';


function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			oldonload();
			func();
		};
	}
}

function prepareWFMImages() {
	var anchors = document.getElementsByTagName('a');
	
	// loop through all anchor tags
	for (var i=0; i < anchors.length; i++){
		var anchor = anchors[i];
		
		var relAttribute = String(anchor.getAttribute('rel'));
		
		if (anchor.getAttribute('href') && (relAttribute.toLowerCase().match('flickr-mgr'))){
		
			anchor.onclick = function () {
				var save_url = this.getAttribute("href");
				hs.captionText = this.getAttribute("title");
				var image = this.getElementsByTagName('img');
				image = image[0];
				var testClass = image.getAttribute("class");
				if(testClass === null) {
					testClass = image.getAttribute("className");
				}
				
				if(testClass.match("flickr-original")) {
					this.setAttribute("href", image.getAttribute("longdesc"));
				} else {
					var image_link = image.getAttribute("src");
					var imageSize = "";
					if(testClass) {
						var testResult = testClass.match(/flickr\-small|flickr\-medium|flickr\-large/);
						switch(testResult.toString()) {
							case "flickr-large":
								imageSize = "_b";
								break;
							case "flickr-medium":
								imageSize = "";
								break;
							case "flickr-small":
								imageSize = "_m";
								break;
						}
					}
					
					if(image_link.match(/[s,t,m]\.jpg/)) {
						image_link = image_link.split("_");
						image_link.pop();
						image_link[image_link.length - 1] = image_link[image_link.length - 1] + imageSize + ".jpg";
						image_link = image_link.join("_");
					} else if(!image_link.match(/b\.jpg/)) {
						image_link = image_link.split(".");
						image_link.pop();
						image_link[image_link.length - 1] = image_link[image_link.length - 1] + imageSize + ".jpg";
						image_link = image_link.join(".");
					}
					this.setAttribute("href", image_link);
				}
				var save_return = hs.expand(this);
				this.setAttribute("href", save_url);
				return save_return;
			};
			
		}
	}

}


/*
 * INSERTS CODE INTO MEDIA TAB MENU SIMILAR TO:
 *		<div id="controlbar" class="highslide-overlay controlbar">
 *			<a href="#" class="previous" onclick="return hs.previous(this)" title="Previous (left arrow key)"></a>
 *			<a href="#" class="next" onclick="return hs.next(this)" title="Next (right arrow key)"></a>
 *			<a href="#" class="highslide-move" onclick="return false" title="Click and drag to move"></a>
 *			<a href="#" class="close" onclick="return hs.close(this)" title="Close"></a>
 *		</div>
 */
function addControlbar() {
	
	var controlBar = document.createElement("div");
	controlBar.setAttribute("id", "controlbar");
	controlBar.setAttribute("class", "highslide-overlay controlbar");
	
	var previousButton = document.createElement("a");
	previousButton.setAttribute("href", "#");
	previousButton.setAttribute("class", "previous");
	previousButton.setAttribute("title", "Previous (left arrow key)");
	previousButton.onclick = function() {
		return hs.previous(this);
	};
	controlBar.appendChild(previousButton);
	
	var nextButton = document.createElement("a");
	nextButton.setAttribute("href", "#");
	nextButton.setAttribute("class", "next");
	nextButton.setAttribute("title", "Next (right arrow key)");
	nextButton.onclick = function() {
		return hs.next(this);
	};
	controlBar.appendChild(nextButton);
	
	var moveButton = document.createElement("a");
	moveButton.setAttribute("href", "#");
	moveButton.setAttribute("class", "highslide-move");
	moveButton.setAttribute("title", "Click and drag to move");
	moveButton.onclick = function() {
		return false;
	};
	controlBar.appendChild(moveButton);
	
	var closeButton = document.createElement("a");
	closeButton.setAttribute("href", "#");
	closeButton.setAttribute("class", "close");
	closeButton.setAttribute("title", "Close");
	closeButton.onclick = function() {
		return hs.close();
	};
	controlBar.appendChild(closeButton);
	
	
	var bodyElement = document.getElementsByTagName("body");
	bodyElement = bodyElement[0];
	bodyElement.appendChild(controlBar);
	
}

//addLoadEvent(addControlbar);
addLoadEvent(prepareWFMImages);
