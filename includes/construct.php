<?php
/* 
	Developed by David Regimbal
*/
Class Request
{
	const ServicesListUrl = "https://settings.svc.halowaypoint.com/RegisterClientService.svc/register/webapp/AE5D20DCFA0347B1BCE0A5253D116752";
	
	public function __construct($spartanToken, $gamertag){
		$this->settings = array(
			'spartan' => $spartanToken,
			'gamertag' => $gamertag,
			'game' => "h4",
			'language' => "en-US"
		);
		//var_dump($settings);
	}

	function getServiceList(){
	
		$gamertag = $this->settings['gamertag'];
		$lang = $this->settings['language'];
		$game = $this->settings['game'];
		
		$opts = array(
		  'https'=>array(
			'method'=>"GET",
			'header'=>"X-343-Authorization-Spartan:" . $this->settings['spartan']
		  )
		);
		$context = stream_context_create($opts);		
		$contents = file_get_contents(self::ServicesListUrl, false, $context);
		$search = array('{gamertag}', '{language}', '{game}');
		$replace = array($gamertag, $lang, $game);
		$new_contents = str_replace($search, $replace, $contents);
		$results = new SimpleXMLElement($new_contents);

		$list = array();
		foreach( $results->ServiceList->children('d2p1', true)->KeyValueOfstringstring as $pair ){
			$key = (string)$pair->Key;
			$value = (string)$pair->Value;
			
			$list[$key] = $value;

		}
		//var_dump($list);
		return $list;

	}	
	
	function get($key, $param = NULL){
	
		// What stat url do they want?
		$list = $this->getServiceList();
		$url = $list[$key];
		
		if( $key == "GetGameDetails" ){
			$url = str_replace('{gameid}', $param, $url);
		}

		$data = array();
				$ch = curl_init($url);				
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);		
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11');
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-343-Authorization-Spartan:' . $this->settings['spartan']
				));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				$call = curl_exec($ch);
				curl_close($ch);

		$results = simplexml_load_string($call);
	
		$array = (array)$results;
		// Add player's Spartan Body image
		$gamertag = $this->settings['gamertag'];
		$array['spartanBody'] = "https://spartans.svc.halowaypoint.com/players/$gamertag/h4/spartans/fullbody?target=large";
		
		
		return $array;
	}
	
	function asset($image, $size){
		$game = $this->settings['game'];
		$formatted = str_replace("{size}", $size, $image);
		$url = "<img src='https://assets.halowaypoint.com/games/$game/damage-types/v1/$formatted' />";		
		return $url;
	}
	function rankAsset($image, $size){
		$formatted = str_replace("{size}", $size, $image);
		$game = $this->settings['game'];
		$url = "<img src='https://assets.halowaypoint.com/games/$game/ranks/v1/$formatted' />";		
		return $url;
	}
	function emblemAsset($image, $size){
		$formatted = str_replace("{size}", $size, $image);
		$game = $this->settings['game'];
		$url = "https://emblems.svc.halowaypoint.com/$game/emblems/$formatted";		
		return $url;
	}
	function mapAsset($image, $size){
		$formatted = str_replace("{size}", $size, $image);
		$game = $this->settings['game'];
		$url = "https://assets.halowaypoint.com/games/$game/maps/v1/$formatted";
		return $url;
	}
	
	
}
