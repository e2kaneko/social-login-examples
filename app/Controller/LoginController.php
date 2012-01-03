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
		}

		$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
		. $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
		. $app_secret . "&code=" . $code;

		$access_token = file_get_contents($token_url);
		$graph_url = "https://graph.facebook.com/me?" . $access_token;
		$user = json_decode(file_get_contents($graph_url));

		$this->Session->write('user.facebook', $user);

		$this->redirect('/List');
	}

	public function twitter() {
	}
}

