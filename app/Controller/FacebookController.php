<?php
class FacebookController extends AppController {
	public $name = 'facebook';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		$this->Session->write('user.facebook', array());

		$appId = Configure::read("Facebook.appId");
		$appSecret = Configure::read("Facebook.appSecret");
		$callbackUrl = Configure::read("Facebook.callbackUrl");

		$dialogUrl = "http://www.facebook.com/dialog/oauth?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl);
		$this->redirect($dialogUrl);
	}

	public function callback() {
		$this->Session->write('user.facebook', array());

		if(!isset($this->params["url"]["code"])){
			$this->redirect('/list');
		}

		$appId = Configure::read("Facebook.appId");
		$appSecret = Configure::read("Facebook.appSecret");
		$callbackUrl = Configure::read("Facebook.callbackUrl");
		$code = $this->params["url"]["code"];

		$tokenUrl = "https://graph.facebook.com/oauth/access_token?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
		. $appSecret . "&code=" . $code;

		$accessToken = file_get_contents($tokenUrl);
		$graphUrl = "https://graph.facebook.com/me?" . $accessToken;
		$user = json_decode(file_get_contents($graphUrl));

		$this->Session->write('user.facebook', $user);

		$this->redirect('/list');
	}
}