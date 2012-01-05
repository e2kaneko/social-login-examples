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
		App::import('Vendor','oauth', array('file'=>'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$consumerKey = Configure::read("Twitter.consumerKey");
		$consumerSecret = Configure::read("Twitter.consumerSecret");
		$callbackUrl = Configure::read("Facebook.callbackUrl");
		
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
}


