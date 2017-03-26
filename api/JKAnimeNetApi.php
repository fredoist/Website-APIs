<?php
/**
 * JKANIME.net API TO SEARCH AND STREAM ANIME
 * 
 * It uses their mobile API, some animes and/or episodes may not be available.
 * Due to some unknown problems fetching their video stream link, it uses jkanime.io (sources from cdn.jkanime.us) to stream videos and search for animes.
 * 
 * (C) 2017 Freddy González.
 * 
 * This code is private, you cannot copy, share or use this code without my previous aprovation.
 */
class JKAnimeNetApi{
	protected $_PATH = 'http://jkanime.net/';
	protected $_TIME;
	protected $_FORMAT = false;
	
	public function __construct(){
		$this->_TIME = time();
	}
	/**
	 * FORMAT JSON RESPONSE PRETTY PRINT
	 */
	public function format($value){
		$this->_FORMAT = $value;
		return $this;
	}
	public function getJSON($URI, $time = false){
		$_URI = $this->_PATH . $URI;
		if($time) $_URI .= $this->_TIME;
		$agent= 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, $agent);
		curl_setopt($curl, CURLOPT_REFERER, 'http://jkanime.net/');
		curl_setopt($curl, CURLOPT_URL, $_URI);
		$data = curl_exec($curl);
		$data = json_decode($data);
		return $this->encode($data);
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
	 * GETS RECENT EPISODES
	 * 
	 * $API->recent();
	 */
	public function recent(){
		$data = $this->getJSON('doc/air/?rnd=', true);
		$data = json_decode($data);
		$feed = array();
		foreach($data as $i=>$anime){
			$feed[$i]['episode']['id'] = $anime->id;
			$feed[$i]['episode']['title'] = $anime->t;
			$feed[$i]['episode']['number'] = $anime->n;
			$feed[$i]['episode']['preview'] = $anime->i;
			$feed[$i]['episode']['thumbnail'] = $anime->tn;
			$feed[$i]['episode']['date'] = $anime->ts;
			$feed[$i]['anime']['id'] = $anime->a;
			$feed[$i]['anime']['type'] = $anime->ty;
			$feed[$i]['anime']['slug'] = $anime->sl;
		}
		return $this->encode($feed);
	}
	/**
	 * SEARCH FOR ANIMES
	 * 
	 * $API->search('masamune');
	 */
	public function search($query){
		// search keywords on jkanime.io
		$data = file_get_contents('http://ww1.jkanime.io/search.html?keyword=' . $query);
		preg_match_all('/(serie|ova)\/(.*?).html/', $data, $result);
		$animes = array();
		foreach($result[2] as $i=>$anime){
			// search previous results again on jkanime.net and returns anime information.
			$animes[$i] = json_decode($this->info($anime));
		}
		return $this->encode($animes);
	}
	/**
	 * GETS INFORMATION ABOUT AN ANIME
	 * 
	 * $API->info('masamune-kun-no-revenge');
	 */
	public function info($anime_slug){
		$data = $this->getJSON('doc/ani/' . $anime_slug . '/');
		$data = json_decode($data);
		$info = array();
		$info['id'] = $data->id;
		$info['title'] = $data->title;
		$info['slug'] = $anime_slug;
		$info['synopsis'] = $data->synopsis;
		$info['image'] = $data->image;
		$info['type'] = $data->type;
		// currently = En emision, finished = Finalizado
		$info['status'] = ($data->status == 'currently') ? 'En emisión' : 'Finalizado';
		$info['thumbnail'] = $data->thumbnail;
		/**
		 * I STILL DON'T KNOW HOW TO USE THE GENRES, BUT IT RETURNS AN ARRAY LIKE THIS -> [36,12,34,..]
		 */
		//$info['anime_genres'] = $data->genre;
		return $this->encode($info);
	}
	/**
	 * GETS EPISODE LIST FROM AN ANIME
	 * 
	 * $API->episodes('1234');
	 */
	public function episodes($anime_id){
		$data = $this->getJSON('doc/episodes/' . $anime_id . '/');
		$data = json_decode($data);
		$episodes = array();
		foreach($data as $i=>$episode){
			$episodes[$i]['id'] = $episode->id;
			$episodes[$i]['title'] = $episode->title;
			$episodes[$i]['number'] = $episode->number;
		}
		return $this->encode($episodes);
	}
	/**
	 * GETS EPISODE SOURCE (THUMBNAIL, LANGUAGE, STREAM)
	 * 
	 * $API->source('masamune-kun-no-revenge', '1');
	 */
	public function source($anime_slug, $episode_number){
		$data = $this->getJSON('doc/source/' . $anime_slug . '/' . $episode_number . '/?a=', true);
		$data = json_decode($data);
		$episode = array();
		$episode['image'] = $data->image;
		$episode['info']['previous'] = $data->pagination->before;
		$episode['info']['next'] = $data->pagination->after;
		$episode['info']['current'] = $data->pagination->current;
		$episode['label'] = $data->src[0]->label;
		$episode['language'] = $data->src[0]->language;
		// gets video url from cdn.jkanime.us
		$episode['stream'] = 'http://cdn.jkanime.us/media/' . $anime_slug . '/' . $anime_slug . '-' . $episode_number . '.mp4';
		$episode['mslug'] = $data->mslug;
		$episode['programing'] = $data->programing;
		return $this->encode($episode);
	}
	
}

?>