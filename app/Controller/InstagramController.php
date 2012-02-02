<?php
class InstagramController extends AppController {
	public $name = 'instagram';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		$this->Session->write('user.instagram', array());

		$appId = Configure::read("Instagram.appId");
		$appSecret = Configure::read("Instagram.appSecret");
		$callbackUrl = Configure::read("Instagram.callbackUrl");

		$dialogUrl = "https://api.instagram.com/oauth/authorize/?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&response_type=code";
		$this->redirect($dialogUrl);
	}

	public function callback() {
		$this->Session->write('user.instagram', array());

		if(!isset($this->params["url"]["code"])){
			$this->redirect('/list');
		}

		$appId = Configure::read("Instagram.appId");
		$appSecret = Configure::read("Instagram.appSecret");
		$callbackUrl = Configure::read("Instagram.callbackUrl");
    	$accessTokenUri = 'https://api.instagram.com/oauth/access_token';
		$code = $this->params["url"]["code"];

		$post = "client_id=".$appId."&client_secret=".$appSecret."&grant_type=authorization_code&redirect_uri=".$callbackUrl."&code=".$code;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $accessTokenUri);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$json = json_decode(curl_exec($ch));
		curl_close($ch);

		$data = array();
		$data{"username"} = $json->user->username;

		$this->Session->write('user.instagram', $data);

		$this->redirect('/list');
	}
}