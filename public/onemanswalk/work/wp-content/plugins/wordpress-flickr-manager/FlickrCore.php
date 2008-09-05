<?php
class FlickrCore {
	
	var $api_key = "0d3960999475788aee64408b64563028";
	var $secret = "b1e94e2cb7e1ff41";
	
	
	
	function call($method, $params, $sign = false, $rsp_format = "php_serial") {
		if(!is_array($params)) $params = array();
		
		$call_includes = array( 'api_key'	=> $this->api_key, 
								'method'	=> $method,
								'format'	=> $rsp_format);
		
		$params = array_merge($call_includes, $params);
		
		if($sign) $params = array_merge($params, array('api_sig' => $this->getSignature($params)));
		
		$url = "http://api.flickr.com/services/rest/?" . $this->encodeParameters($params);
		
	    return $this->getRequest($url);
	}
	
	
	
	function post($method, $params, $sign = false, $rsp_format = "php_serial") {
		if(!is_array($params) || !is_string($method) || !is_string($rsp_format) || !is_bool($sign)) return false;
		
		$call_includes = array( 'api_key'	=> $this->api_key, 
								'method'	=> $method,
								'format'	=> $rsp_format);
		
		$params = array_merge($call_includes, $params);
		
		if($sign) $params = array_merge($params, array('api_sig' => $this->getSignature($params)));
		
		$url = "http://api.flickr.com/services/rest/";
		
		return $this->postRequest($url, $params);
	}
	
	
	
	function upload($params) {
		
		if(!is_array($params) || !isset($params['photo'])) return false;
		
		$photo = $params['photo'];
		unset($params['photo']);
		
		$call_includes = array( 'api_key'	=> $this->api_key);
		
		$params = array_merge($call_includes, $params);
		$params = array_merge($params, array('photo' => $photo, 'api_sig' => $this->getSignature($params)));
		
		$url = "http://api.flickr.com/services/upload/";
		
		return $this->postRequest($url, $params);
		
	}
	
	
	
	function getRequest($url) {
		if(function_exists('curl_init')) {
			$session = curl_init($url);
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			if (curl_errno($session) == 0) {
		    	curl_close($session);
		        return unserialize($response);
		    }
			curl_close($session);
			$rsp_obj = false;
		} else {
			$handle = fopen($url, "rb");
			$contents = '';
			while (!feof($handle)) {
				$contents .= fread($handle, 8192);
			}
			fclose($handle);
			$rsp_obj = unserialize($contents);
		}
		return $rsp_obj;
	}
	
	
	
	function postRequest($url, $params) {
		if(function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		    
		    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		    curl_setopt($ch, CURLOPT_TIMEOUT,200);
		    
		    $result = curl_exec($ch);
		    
		    if (curl_errno($ch) == 0) {
		    	curl_close($ch);
		        return $result;
		    }
		    curl_close($ch);
			return false;
		} else {
			// Perform fopen POST request
			$request = array('http' => array(
	                 'method' => 'POST',
	                 'content' => $this->encodeParameters($params)
	              ));
	              
		    $ctx = stream_context_create($request);
		    $fp = @fopen($url, 'rb', false, $ctx);
		    if (!$fp) {
		       return false;
		    }
		    $response = @stream_get_contents($fp);
		    if ($response === false) {
		       return false;
		    }
		    return $response;
		}
	}
	
	
	
	function getSignature($params) {
		ksort($params);
		
		$api_sig = $this->secret;
		
		foreach ($params as $k => $v){
			$api_sig .= $k . $v;
		}
		
		return md5($api_sig);
	}
	
	
	
	function encodeParameters($params) {
		$encoded_params = array();
	
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		
		return implode('&', $encoded_params);
	}
	
	
	
	function getAuthUrl($frob, $perms) {
		$params = array('api_key' => $this->api_key, 'perms' => $perms, 'frob' => $frob);
		$params = array_merge($params, array('api_sig' => $this->getSignature($params)));
		
		$url = 'http://flickr.com/services/auth/?' . $this->encodeParameters($params);
		return $url;
	}
	
	
	
	function getPhotoUrl($photo, $size) {
		$sizes = array('square' => '_s', 'thumbnail' => '_t', 'small' => '_m', 'medium' => '', 'large' => '_b', 'original' => '_o');
		if(!isset($photo['originalformat']) && strtolower($size) == "original") $size = 'medium';
		if(($size = strtolower($size)) != 'original') {
			$url = "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}{$sizes[$size]}.jpg";
		} else {
			$url = "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['originalsecret']}{$sizes[$size]}.{$photo['originalformat']}";
		}
		return $url;
	}
	
}

?>
