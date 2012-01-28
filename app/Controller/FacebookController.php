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
		$code = null;

		$dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl);
		$this->redirect($dialog_url);
	}

	public function callback() {
		$this->Session->write('user.facebook', array());

		$appId = Configure::read("Facebook.appId");
		$appSecret = Configure::read("Facebook.appSecret");
		$callbackUrl = Configure::read("Facebook.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}else{
			// error
			$this->redirect('/List');
		}

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