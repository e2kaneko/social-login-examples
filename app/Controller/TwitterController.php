<?php
class TwitterController extends AppController {
	public $name = 'twitter';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		App::import('Vendor','pear', array('file'=>'pear'.DS.'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$this->Session->write('user.twitter', array());
		
		$consumerKey = Configure::read("Twitter.consumerKey");
		$consumerSecret = Configure::read("Twitter.consumerSecret");
		$callbackUrl = Configure::read("Twitter.callbackUrl");

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

	public function callback() {
		App::import('Vendor','pear', array('file'=>'pear'.DS.'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$this->Session->write('user.twitter', array());
		
		$consumerKey = Configure::read("Twitter.consumerKey");
		$consumerSecret = Configure::read("Twitter.consumerSecret");
		$callbackUrl = Configure::read("Twitter.callbackUrl");

		if(isset($this->params["url"]["oauth_token"])){
			$code = $this->params["url"]["oauth_token"];
		}else{
			// error
			$this->redirect('/list');
		}

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

		$this->redirect('/list');
	}
}