<?php
class GithubController extends AppController {
	public $name = 'github';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		// @see http://developer.github.com/v3/oauth/

		$appId = Configure::read("Github.appId");
		$appSecret = Configure::read("Github.appSecret");
		$callbackUrl = Configure::read("Github.callbackUrl");

		$dialogUrl = "https://github.com/login/oauth/authorize?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl);
		$this->redirect($dialogUrl);
	}

	public function callback() {
		$this->Session->write('user.github', array());
		
		if(!isset($this->params["url"]["code"])){
			$this->redirect('/list');
		}
		
		$appId = Configure::read("Github.appId");
		$appSecret = Configure::read("Github.appSecret");
		$callbackUrl = Configure::read("Github.callbackUrl");
		$code = $this->params["url"]["code"];

		$tokenUrl = "https://github.com/login/oauth/access_token?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
		. $appSecret . "&code=" . $code;

		$accessToken = file_get_contents($tokenUrl);
		$graphUrl = "https://github.com/api/v2/json/user/show?" . $accessToken;
		$user = json_decode(file_get_contents($graphUrl));

		$this->Session->write('user.github', $user);

		$this->redirect('/list');
	}
}