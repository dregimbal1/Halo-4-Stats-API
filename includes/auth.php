<?php
/* 
	Developed by David Regimbal
*/

// Class gains access to microsoft services and returns spartan token
Class Auth
{	
	// The page you enter your email and password
	const LOGIN_URL = "https://login.live.com/oauth20_authorize.srf?client_id=000000004C0BD2F1&scope=xbox.basic%20xbox.offline_access&response_type=code&redirect_uri=https://app.halowaypoint.com/oauth/callback&state=MAdodHRwczovL2FwcC5oYWxvd2F5cG9pbnQuY29tL2VuLXVzLw&display=touch";
	// The post action url of the form
	const LOGIN_POST = "https://login.live.com/ppsecure/post.srf?client_id=000000004C0BD2F1&scope=xbox.basic+xbox.offline_access&response_type=code&redirect_uri=https://www.halowaypoint.com/oauth/callback&state=https%253a%252f%252fapp.halowaypoint.com%252fen-US&locale=en-US&display=touch";
	// The referer to the LOGIN_URL page
	const HALO_URL = "https://app.halowaypoint.com/en-us/";
	// What the server will see you as
	const USER_AGENT = "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11";
	
	/* SPARTAN CONSTANT */
	const API_URL = "https://app.halowaypoint.com/oauth/spartanToken";
	
	function getPPFT($call){
		// Windows Hash
		/*
			Authentic string required to be passed to Microsoft when logging in
			
			Err Resp: 'email or password incorrect'
		*/
		$regex = "#name=\"PPFT\".*?value=\"(.*?)\"#";
		preg_match($regex, $call, $ppft);
		return str_replace('"', "", $ppft[1]);
	}
	function getPPSX($call){
		// Windows Passport
		/*
			Random characters of 'PassportRN' different on each page load
			
			Err Resp: 'email or password incorrect'
		*/
		$regex = "/i:['\"].*?['\"]/";
		preg_match($regex, $call, $ppsx);
		$passport = $ppsx[0];
		$passport = str_replace("'", "", $passport);
		$passport = substr($passport, 2);
		return $passport;
	}
	function getTokens(){
		// Get PPFT and PPSX
		/*
			To keep it clean for future updates and revisions
			This function calls two others to gather the tokens required to login
			
			Err Resp: 'email or password incorrect'
		*/
		$data = array();
				$ch = curl_init(self::LOGIN_URL);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);		
				curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
				curl_setopt($ch,CURLOPT_REFERER, self::HALO_URL);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				$call = curl_exec($ch);
				curl_close($ch);		
		$data['PPFT'] = $this->getPPFT($call);
		$data['PPSX'] = $this->getPPSX($call);
		$data['i3'] = rand(15000, 50000);
		return $data;
	}
	function login($email, $password){
		$data = $this->getTokens();
		$postdata = "PPFT=" . $data['PPFT'] . "&login=" . $email . "&passwd=" . $password . "&LoginOptions=3&NewUser=1&PPSX=" . $data['PPSX'] . "&type=11&i3=" . $data['i3'] . "&m1=1920&m2=1080&m3=0&i12=1&i17=0&i18=__MobileLogin|1,";
				$ch = curl_init(self::LOGIN_POST);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);		
				curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
				curl_setopt($ch,CURLOPT_REFERER, self::LOGIN_URL);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_POST, 1); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				$call = curl_exec($ch);
				curl_close($ch);		
		
		$authTokens = $this->getAuth($call);
		return $authTokens;
	}
	function getAuth($call){
		// 343i Auth Tokens
		/*
			access_token{}
			AuthenticationToken{}
			
			Err Resp: 'null'
		*/
		$data = array();
		$regex = "/var user.=.*?({.*?});/";
		preg_match($regex, $call, $tokens);
		$array = explode(":", $tokens[1]);
		// Trim down access_token
		preg_match('/".*?"|\'.*?\'/', $array[1], $access_token);
		$data['accessToken'] = str_replace("'", "", $access_token[0]);
		
		// Trim down AuthenticationToken
		preg_match('/".*?"|\'.*?\'/', $array[2], $authToken);
		$data['authenticationToken'] = str_replace("'", "", $authToken[0]);

		return $data;
	}
	function getSpartanToken($email, $password){
		$result = $this->login($email, $password);
		$data = array();
			$ch = curl_init(self::API_URL);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
			curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$call = curl_exec($ch);
			curl_close($ch);	
			$credits = explode('"', $call);
		$data['gamertag'] = $credits[7];
		$data['anaToken'] = $credits[11];
		$data['spartaToken'] = $credits[3];

		return $data;

	}
}