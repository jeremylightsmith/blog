
jQuery(document).ready(function() {
	
	insertTabs();
	
	jQuery("#flickr-form").submit(function() { return false; });
	
	jQuery("#wfm-scope-block>label>input").change(function() {
		flickrRequest();
	});
	
	jQuery("#wfm-insert-set").change(function() {
		if (jQuery('#wfm-insert-set').is(':checked')) {
			jQuery("#wfm-set-name").focus();
		}
	});
	
	jQuery("#wfm-filter").keypress(function(e) {
		var evt = (e) ? e : window.event;
		var type = evt.type;
		var pK = e ? e.which : window.event.keyCode;
		if (pK == 13) {
			flickrRequest();
			return false;
		}
	});
	
	jQuery("select[@name='wfm-size']").change(function () {
		flickrRequest('&wfm-page=' + jQuery("#wfm-page").attr("value"));
	});
	
	prepareNavigation();
	prepareImages();
	
	jQuery("#wfm-upload-link").click(function() {
		jQuery("#sidemenu>li>a").removeClass("current");
		var url = jQuery(this).addClass("current").attr("href");
		var loadingImage = jQuery("#wfm-ajax-url").attr("value") + "/images/loading.gif";
		
		jQuery("#flickr-form").html(jQuery('<img src="' + loadingImage + '" alt="loading..." />'));
		jQuery("#flickr-form").load(url);
		
		return false;
	});
	
});


/*
 * INSERTS CODE INTO MEDIA TAB MENU SIMILAR TO:
 *		<li id="tab-flickr-upload">
 *			<a href="/wp-content/plugins/wordpress-flickr-manager/flickr-ajax.php?faction=media-upload" id="wfm-upload-link">
 *				Flickr Upload
 *			</a>
 *		</li>
 */
var insertTabs = function() {
	var uploadTab = document.createElement("li");
	uploadTab.setAttribute("id", "tab-flickr-upload");
	
	var uploadLink = document.createElement("a");
	uploadLink.setAttribute("href", jQuery("#wfm-ajax-url").attr("value") + "/flickr-ajax.php?faction=media-upload");
	uploadLink.setAttribute("id", "wfm-upload-link");
	uploadLink.appendChild(document.createTextNode('Flickr Upload'));
	
	uploadTab.appendChild(uploadLink);
	document.getElementById("sidemenu").appendChild(uploadTab);
};


var prepareNavigation = function() {
	
	var newNav = jQuery("#wfm-navigation").html();
	if(jQuery("#wfm-navigation:first").children().filter(':first').attr("id") == "wfm-navigation") {
		var newNav = jQuery("#wfm-navigation:first").children().filter(':first').html();
	}
	jQuery("#wfm-dashboard").children().filter("#wfm-navigation:first").html(newNav);
	
	newNav = jQuery("#wfm-browse-content").html();
	if(jQuery("#wfm-browse-content:first").children().filter(':first').attr("id") == "wfm-browse-content") {
		var newNav = jQuery("#wfm-browse-content:first").children().filter(':first').html();
	}
	jQuery("#flickr-form").children().filter("#wfm-browse-content:first").html(newNav);
	
	jQuery("#wfm-photoset").change(function() {
		flickrRequest();
	});
	
	jQuery("#wfm-filter-submit").click(function() {
		flickrRequest();
	});

	jQuery("#wfm-navigation>a").click(function() {
		var uri = jQuery(this).attr("href").split("?");
		
		flickrRequest(uri[uri.length-1]);
		return false;
	});
	
	jQuery("#wfm-entire-set").click(function() {
		
		var size = jQuery("select[@name='wfm-size']").val();
		var id = jQuery("select[@name='wfm-photoset']").val();
		var lightbox = "";
		
		if(jQuery("#wfm-lightbox").is(":checked")) {
			lightbox = "true";
		} else {
			lightbox = "false";
		}
		
		var setHTML = "[imgset:" + id + "," + size + "," + lightbox + "]";
		
		if(jQuery("#wfm-close").is(":checked")) {
			top.send_to_editor(setHTML);
		} else {
			var win = window.opener ? window.opener : window.dialogArguments;
			if ( !win ) win = top;
			tinyMCE = win.tinyMCE;
			if ( typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content') ) {
				tinyMCE.selectedInstance.getWin().focus();
				tinyMCE.execCommand('mceInsertContent', false, setHTML);
			} else if (win.edInsertContent) win.edInsertContent(win.edCanvas, setHTML);
		}
		
		return false;
	});
};

function isDefined(variable) {
    return (typeof(variable) == "undefined") ? false : true;
}

var prepareImages = function() {
	
	jQuery("div.flickr-img>img").click(function() {
		
		var id = jQuery(this).parent().attr("id").split("-")[1];
		var src = jQuery("#url-" + id).attr("value");
		var title = jQuery(this).attr("alt");
		var owner = jQuery("#owner-" + id).attr("value"); // nsid and account name '|' separated
		var license = jQuery("#license-" + id);
		var wrapBefore = decodeURIComponent(jQuery("#wfm-insert-before").attr("value"));
		var wrapAfter = decodeURIComponent(jQuery("#wfm-insert-after").attr("value"));
		var size = jQuery("select[@name='wfm-lbsize']").val();
		
		var imgHTML = '';
		
		if(jQuery("#wfm-blank").val() == "true") {
			var target = ' target="_blank" ';
		} else {
			var target = '';
		}
		
		if(jQuery("#wfm-lightbox").is(":checked")) {
			var longdesc = ' ';
			if(isDefined(jQuery(this).attr("longdesc"))) {
				longdesc = 'longdesc="' + jQuery(this).attr("longdesc") + '" ';
			}
			
			if(jQuery("#wfm-insert-set").is(":checked")) {
				var rel = ' rel="flickr-mgr[' + jQuery("#wfm-set-name").val() + ']" ';
			} else {
				var rel = ' rel="flickr-mgr" ';
			}
			imgHTML = '<a href="http://www.flickr.com/photos/' + owner.split("|")[0] + "/" + id + '/" class="flickr-image" ' + target + ' title="' + this.alt + '"';
			imgHTML = imgHTML + rel + '><img src="' + src + '" alt="' + this.alt + '" class="' + size + '" ' + longdesc + '/></a>';
		} else {
			imgHTML = '<a href="http://www.flickr.com/photos/' + owner.split("|")[0] + "/" + id + '/" class="flickr-image"' + target + 'title="' + this.alt + '"' + '>';
			imgHTML = imgHTML + '<img src="' + src + '" alt="' + this.alt + '" /></a>';
		}
		
		if(license.attr("href")) {
			imgHTML = imgHTML + "<br /><small><a href='" + license.attr("href") + "' title='" + license.attr("title") + "' rel='license' " + target + ">" + license.html() + "</a> by <a href='http://www.flickr.com/people/"+owner.split("|")[0]+"/'"+ target +">"+owner.split("|")[1]+"</a></small>";
		}
		
		if(isDefined(wrapBefore) && wrapBefore !== 'undefined') {
			imgHTML = wrapBefore + imgHTML;
		}
		if(isDefined(wrapAfter) && wrapAfter !== 'undefined') {
			imgHTML = imgHTML + wrapAfter;
		}
		
		if(jQuery("#wfm-close").is(":checked")) {
			top.send_to_editor(imgHTML);
		} else {
			var win = window.opener ? window.opener : window.dialogArguments;
			if ( !win ) win = top;
			tinyMCE = win.tinyMCE;
			if ( typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content') ) {
				tinyMCE.selectedInstance.getWin().focus();
				tinyMCE.execCommand('mceInsertContent', false, imgHTML);
			} else if (win.edInsertContent) win.edInsertContent(win.edCanvas, imgHTML);
		}
		
	});
	
};


function flickrRequest(params) {
	var url = appendParameters(jQuery("#wfm-ajax-url").attr("value") + "/flickr-ajax.php?faction=media-browse");
	if(params) {
		url = url + params;
	}
	var loadingImage = jQuery("#wfm-ajax-url").attr("value") + "/images/loading.gif";
	
	jQuery("#wfm-browse-content").html(jQuery('<img src="' + loadingImage + '" alt="loading..." />'));
	jQuery("#wfm-navigation").load(url + " #wfm-navigation", { type: "GET" }, prepareNavigation);
	jQuery("#wfm-browse-content").load(url + " #wfm-browse-content", { type: "GET" }, prepareImages);
	
}

function appendParameters(url) {
	url = url + "&wfm-scope=" + jQuery("input[@name='wfm-scope']:checked").val();
	url = url + "&wfm-filter=" + jQuery("input[@name='wfm-filter']").val();
	url = url + "&wfm-photoset=" + jQuery("select[@name='wfm-photoset']").val();
	url = url + "&wfm-size=" + jQuery("select[@name='wfm-size']").val();
	
	return url;
}
