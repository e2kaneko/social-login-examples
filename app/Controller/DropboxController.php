<?php
class DropboxController extends AppController {
	public $name = 'dropbox';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		App::import('Vendor','pear', array('file'=>'pear'.DS.'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$this->Session->write('user.dropbox', array());
		
		$consumerKey = Configure::read("Dropbox.consumerKey");
		$consumerSecret = Configure::read("Dropbox.consumerSecret");
		$callbackUrl = Configure::read("Dropbox.callbackUrl");

		$oAuth = new HTTP_OAuth_Consumer($consumerKey, $consumerSecret);
		$httpRequest = new HTTP_Request2();
		$httpRequest->setConfig("ssl_verify_peer", false);
		$consumerRequest = new HTTP_OAuth_Consumer_Request;
		$consumerRequest->accept($httpRequest);
		$oAuth->accept($consumerRequest);
		$oAuth->getRequestToken("https://api.dropbox.com/1/oauth/request_token", $callbackUrl);

		$authorizeUrl = $oAuth->getAuthorizeURL("https://www.dropbox.com/1/oauth/authorize", array("oauth_callback"=>$callbackUrl));

		$this->Session->write('oauth_request_token', $oAuth->getToken());
		$this->Session->write('oauth_request_token_secret', $oAuth->getTokenSecret());

		header("Location: " . $authorizeUrl);

		die();
	}

	public function callback() {

		if(!isset($this->params["url"]["oauth_token"])){
			$this->redirect('/list');
		}
		
		App::import('Vendor','pear', array('file'=>'pear'.DS.'HTTP'.DS.'OAuth'.DS.'Consumer.php'));

		$this->Session->write('user.dropbox', array());
		
		$consumerKey = Configure::read("Dropbox.consumerKey");
		$consumerSecret = Configure::read("Dropbox.consumerSecret");
		$callbackUrl = Configure::read("Dropbox.callbackUrl");

		$code = $this->params["url"]["oauth_token"];

		$oAuth = new HTTP_OAuth_Consumer($consumerKey, $consumerSecret);
		$httpRequest = new HTTP_Request2();
		$httpRequest->setConfig("ssl_verify_peer", false);
		$consumerRequest = new HTTP_OAuth_Consumer_Request;
		$consumerRequest->accept($httpRequest);
		$oAuth->accept($consumerRequest);

		$oAuthToken = $code;
		$oAuth->setToken($oAuthToken);
		$oAuth->setTokenSecret($this->Session->read("oauth_request_token_secret"));
		$oAuth->getAccessToken("https://api.dropbox.com/1/oauth/access_token");
		
		$accessToken = $oAuth->getToken();
		$accessTokenSecret = $oAuth->getTokenSecret();
		
		// @see https://dev.twitter.com/docs/api/1/get/account/verify_credentials
		$oAuth->setToken($accessToken);
		$oAuth->setTokenSecret($accessTokenSecret);
		$response = $oAuth->sendRequest("https://api.dropbox.com/1/account/info", array(), "GET");

		$response2 = $response->getResponse();
		$user = json_decode($response2->getBody());
		
		$dropboxUser = array("user"=>$user->display_name);
		$this->Session->write('user.dropbox', $dropboxUser);

		$this->redirect('/list');
	}
}