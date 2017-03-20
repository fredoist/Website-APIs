<?php
/**
 * AN API TO SEARCH AND STREAM ANIME CONTENT
 * 
 * Currently supported websites:
 * 	- jkanime.net
 */
class AnimeApi{
	protected $_PATH = 'http://jkanime.net/';
	protected $_TIME;
	
	public function __construct(){
		$this->_TIME = time();
	}
	public function getJSON($URI){
		$_URI = $this->_PATH . $URI . $this->_TIME;
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_REFERER, 'http://jkanime.net/');
		curl_setopt($ch, CURLOPT_URL,$_URI);
		$data = curl_exec($ch);
		$data = json_decode($data);
		$JSON = json_encode($data, JSON_UNESCAPED_SLASHES);
		return $JSON;
	}
	/**
	 * OBTIENE LOS EPISODIOS MAS RECIENTES
	 */
	public function getFeed(){
		$data = $this->getJSON('doc/air/?rnd=');
		$data = json_decode($data);
		$feed = array();
		foreach($data as $i=>$anime){
			$feed[$i]['episode_id'] = $anime->id;
			$feed[$i]['episode_title'] = $anime->t;
			$feed[$i]['anime_id'] = $anime->a;
			$feed[$i]['episode_number'] = $anime->n;
			$feed[$i]['episode_preview'] = $anime->i;
			$feed[$i]['anime_type'] = $anime->ty;
			$feed[$i]['episode_thumbnail'] = $anime->tn;
			$feed[$i]['anime_slug'] = $anime->sl;
			$feed[$i]['episode_date'] = $anime->ts;
		}
		$JSON = json_encode($feed, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $JSON;
	}
	/**
	 * BUSCAR ANIMES
	 */
	public function search($query){
		// busca animes en jkanime.io
		$data = file_get_contents('http://ww1.jkanime.io/search.html?keyword=' . $query);
		preg_match_all('/(serie|ova)\/(.*?).html/', $data, $result);
		$animes = array();
		foreach($result[2] as $i=>$anime){
			// obtiene resultados de jkanime.net
			$animes[$i] = json_decode($this->getAniInfo($anime));
		}
		$JSON = str_replace('\n', '', json_encode($animes, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
		return $JSON;
	}
	/**
	 * OBTIENE INFORMACION SOBRE UN ANIME
	 */
	public function getAniInfo($anime_slug){
		$data = $this->getJSON('doc/ani/' . $anime_slug . '/#');
		$data = json_decode($data);
		$info = array();
		$info['anime_id'] = $data->id;
		$info['anime_title'] = $data->title;
		$info['anime_slug'] = strtolower(str_replace(' ', '-', $data->title));
		$info['anime_synopsis'] = $data->synopsis;
		$info['anime_image'] = $data->image;
		$info['anime_type'] = $data->type;
		// currently = En emision, finished = Finalizado
		$info['anime_status'] = ($data->status == 'currently') ? 'En emisión' : 'Finalizado';
		$info['anime_thumbnail'] = $data->thumbnail;
		/**
		 * AUN NO SE COMO SE USAN LOS GENEROS, DEBUELVEN ARRAY [36,12,34,..]
		 */
		//$info['anime_genres'] = $data->genre;
		$JSON = json_encode($info, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $JSON;
	}
	/**
	 * OBTIENE LISTA DE EPISODIOS DE UN ANIME
	 */
	public function getEpisodes($anime_id){
		$data = $this->getJSON('doc/episodes/' . $anime_id . '/#');
		$data = json_decode($data);
		$episodes = array();
		foreach($data as $i=>$episode){
			$episodes[$i]['episode_id'] = $episode->id;
			$episodes[$i]['episode_title'] = $episode->title;
			$episodes[$i]['episode_number'] = $episode->number;
		}
		$JSON = json_encode($episodes, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $JSON;
	}
	/**
	 * OBTIENE LA FUENTE DE UN EPISODIO IMAGEN, IDIOMA, VIDEO..
	 */
	public function getSource($anime_slug, $episode_number){
		$data = $this->getJSON('doc/source/' . $anime_slug . '/' . $episode_number . '/?a=');
		$data = json_decode($data);
		$episode = array();
		$episode['episode_image'] = $data->image;
		$episode['episode_info']['previous'] = $data->pagination->before;
		$episode['episode_info']['next'] = $data->pagination->after;
		$episode['episode_info']['current'] = $data->pagination->current;
		$episode['episode_label'] = $data->src[0]->label;
		$episode['episode_language'] = $data->src[0]->language;
		// obtiene el video de jkanime.us
		$episode['episode_stream'] = 'http://cdn.jkanime.us/media/' . $anime_slug . '/' . $anime_slug . '-' . $episode_number . '.mp4';
		$episode['episode_mslug'] = $data->mslug;
		$episode['episode_programing'] = $data->programing;
		$JSON = json_encode($episode, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $JSON;
	}
	
}

?>