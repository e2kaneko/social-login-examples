<?php
class LoginController extends AppController {
	public $name = 'Login';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function facebook() {
		$this->Session->write('user.facebook', array());

		$appId = Configure::read("Facebook.appId");
		$appSecret = Configure::read("Facebook.appSecret");
		$callbackUrl = Configure::read("Facebook.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}
			
		if(empty($code)) {
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl);
			$this->redirect($dialog_url);
		}else{
				
			// callback

			$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
			. $appSecret . "&code=" . $code;

			$access_token = file_get_contents($token_url);
			$graph_url = "https://graph.facebook.com/me?" . $access_token;
			$user = json_decode(file_get_contents($graph_url));

			$this->Session->write('user.facebook', $user);

			$this->redirect('/List');
		}
	}

	public function twitter() {
		App::import('Vendor','pear', array('file'=>'pear'.DS.'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$consumerKey = Configure::read("Twitter.consumerKey");
		$consumerSecret = Configure::read("Twitter.consumerSecret");
		$callbackUrl = Configure::read("Twitter.callbackUrl");

		if(isset($this->params["url"]["oauth_token"])){
			$code = $this->params["url"]["oauth_token"];
		}

		if(!empty($code)){
				
			// callback
			$oAuth = new HTTP_OAuth_Consumer($consumerKey, $consumerSecret);
			$httpRequest = new HTTP_Request2();
			$httpRequest->setConfig("ssl_verify_peer", false);
			$consumerRequest = new HTTP_OAuth_Consumer_Request;
			$consumerRequest->accept($httpRequest);
			$oAuth->accept($consumerRequest);

			$oAuthToken = $code;
			$oAuth->setToken($oAuthToken);
			$oAuth->setTokenSecret($this->Session->read("oauth_request_token_secret"));
			$oAuthVerifier = $this->params["url"]["oauth_verifier"];
			$oAuth->getAccessToken("https://api.twitter.com/oauth/access_token", $oAuthVerifier);

			$accessToken = $oAuth->getToken();
			$accessTokenSecret = $oAuth->getTokenSecret();

			// @see https://dev.twitter.com/docs/api/1/get/account/verify_credentials
			$oAuth->setToken($accessToken);
			$oAuth->setTokenSecret($accessTokenSecret);
			$response = $oAuth->sendRequest("http://twitter.com/account/verify_credentials.xml", array(), "GET");
			$responseXml = simplexml_load_string($response->getBody());
				
			$twitterUser = array("user"=>(string)$responseXml->name);
			$this->Session->write('user.twitter', $twitterUser);

			$this->redirect('/List');
				
		}else{

			$oAuth = new HTTP_OAuth_Consumer($consumerKey, $consumerSecret);
			$httpRequest = new HTTP_Request2();
			$httpRequest->setConfig("ssl_verify_peer", false);
			$consumerRequest = new HTTP_OAuth_Consumer_Request;
			$consumerRequest->accept($httpRequest);
			$oAuth->accept($consumerRequest);
			$oAuth->getRequestToken("https://api.twitter.com/oauth/request_token", $callbackUrl);

			$authorizeUrl = $oAuth->getAuthorizeURL("https://api.twitter.com/oauth/authorize");

			$this->Session->write('oauth_request_token', $oAuth->getToken());
			$this->Session->write('oauth_request_token_secret', $oAuth->getTokenSecret());

			header("Location: " . $authorizeUrl);
				
			die();
		}
	}

	public function github() {
		// @see http://developer.github.com/v3/oauth/

		$this->Session->write('user.github', array());

		$appId = Configure::read("Github.appId");
		$appSecret = Configure::read("Github.appSecret");
		$callbackUrl = Configure::read("Github.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}
			
		if(empty($code)) {
			$dialog_url = "https://github.com/login/oauth/authorize?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl);
			$this->redirect($dialog_url);
		}else{
				
			// callback

			$token_url = "https://github.com/login/oauth/access_token?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
			. $appSecret . "&code=" . $code;

			$access_token = file_get_contents($token_url);
			$graph_url = "https://github.com/api/v2/json/user/show?" . $access_token;
			$user = json_decode(file_get_contents($graph_url));
				
			$this->Session->write('user.github', $user);

			$this->redirect('/List');
		}
	}

		public function google() {
		// @see http://code.google.com/intl/ja/apis/accounts/docs/OAuth2.html

		$this->Session->write('user.google', array());

		$appId = Configure::read("Google.appId");
		$appSecret = Configure::read("Google.appSecret");
		$callbackUrl = Configure::read("Google.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}
			
		if(empty($code)) {
			$dialog_url = "https://accounts.google.com/o/oauth2/auth?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&response_type=code&scope=https://www.googleapis.com/auth/plus.me";

			$this->redirect($dialog_url);
		}else{
				
			// callback

			$token_url = "https://accounts.google.com/o/oauth2/token?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
			. $appSecret . "&code=" . $code . "&grant_type=authorization_code";
			
			$access_token = file_get_contents($token_url);
			$graph_url = "https://www.googleapis.com/oauth2/v1/userinfo?" . $access_token;
			$user = json_decode(file_get_contents($graph_url));
				
			$this->Session->write('user.google', $user);

			$this->redirect('/List');
		}
	}

}