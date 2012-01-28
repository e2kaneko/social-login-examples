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
		$code = null;

		$dialog_url = "https://github.com/login/oauth/authorize?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl);
		$this->redirect($dialog_url);
	}

	public function callback() {
		$appId = Configure::read("Github.appId");
		$appSecret = Configure::read("Github.appSecret");
		$callbackUrl = Configure::read("Github.callbackUrl");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}else{
			// error
			$this->redirect('/list');
		}

		$token_url = "https://github.com/login/oauth/access_token?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&client_secret="
		. $appSecret . "&code=" . $code;

		$access_token = file_get_contents($token_url);
		$graph_url = "https://github.com/api/v2/json/user/show?" . $access_token;
		$user = json_decode(file_get_contents($graph_url));

		$this->Session->write('user.github', $user);

		$this->redirect('/list');
	}
}