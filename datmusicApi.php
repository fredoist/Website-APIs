<?php
/**
 * datmusicApi
 * 
 * Music streaming service from vk.com without authentication.
 * (C) 2017 Freddy González. All rights reserved.
 * You cannot modify, copy, share or use this code for any purpose.
 */
class datmusicApi{
	protected $_PATH = 'https://api.datmusic.xyz/';
	protected $_FORMAT = false;
	
	private function getJSON($URI){
		$_URI = $this->_PATH . $URI;
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_REFERER, 'https://datmusic.xyz/');
		curl_setopt($ch, CURLOPT_URL, $_URI);
		$data = curl_exec($ch);
		$data = json_decode($data);
		return $this->encode($data);
	}
	/**
	 * FORMAT JSON RESPONSE PRETTY PRINT
	 */
	public function format($value = true){
		$this->_FORMAT = $value;
		return $this;
	}
	/**
	 * ENCODES DATA IN JSON
	 */
	private function encode($data){
		if($this->_FORMAT){
			$JSON = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		}else{
			$JSON = json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		}
		return $JSON;
	}
	/**
	 * GET RECENT UPLOADED SONGS
	 */
	public function feed($page = 1){
		$data = $this->getJSON('search?&page=' . $page);
		return $data;
	}
	/**
	 * SEARCH FOR MUSIC
	 */
	public function search($query, $page = 1){
		$data = $this->getJSON('search?q=' . urlencode($query) . '&page=' . $page);
		return $data;
	}
}

?>