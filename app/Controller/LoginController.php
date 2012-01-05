<?php
class LoginController extends AppController {
	public $name = 'Login';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function facebook() {
		$this->Session->write('user.facebook', array());

		$app_id = Configure::read("Facebook.appId");
		$app_secret = Configure::read("Facebook.appSecret");
		$my_url = Configure::read("Facebook.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}
			
		if(empty($code)) {
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
			. $app_id . "&redirect_uri=" . urlencode($my_url);
			$this->redirect($dialog_url);
		}else{
			
			// callback

			$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
			. $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
			. $app_secret . "&code=" . $code;
	
			$access_token = file_get_contents($token_url);
			$graph_url = "https://graph.facebook.com/me?" . $access_token;
			$user = json_decode(file_get_contents($graph_url));
	
			$this->Session->write('user.facebook', $user);
	
			$this->redirect('/List');
		}
	}

	public function twitter() {
		App::import('Vendor','oauth', array('file'=>'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		
		if(isset($this->params["url"]["oauth_token"])){
			$code = $this->params["url"]["oauth_token"];
		}
		
		if(!empty($code)){
			
			// callback
			
			$oAuth = new HTTP_OAuth_Consumer("jOxQUQq3wiqLZsnPwbPZMA", "D3UmNatQ7qS8D3e1Q8er536WNqLxkjbfy4TM0yLLjw4");
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
		
			$callbackUrl = "http://localhost/sb/Login/twitter";
	
			$oAuth = new HTTP_OAuth_Consumer("jOxQUQq3wiqLZsnPwbPZMA", "D3UmNatQ7qS8D3e1Q8er536WNqLxkjbfy4TM0yLLjw4");
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


