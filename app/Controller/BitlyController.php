<?php
class BitlyController extends AppController {
	public $name = 'bitly';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function login() {
		$this->Session->write('user.bitly', array());

		$appId = Configure::read("Bitly.clientId");
		$appSecret = Configure::read("Bitly.clientSecret");
		$callbackUrl = Configure::read("Bitly.callbackUrl");

		$dialogUrl = "https://bitly.com/oauth/authorize?client_id="
		. $appId . "&redirect_uri=" . urlencode($callbackUrl);
		$this->redirect($dialogUrl);
	}

	public function callback() {
		$this->Session->write('user.bitly', array());

		if(!isset($this->params["url"]["code"])){
			$this->redirect('/list');
		}

		$appId = Configure::read("Bitly.clientId");
		$appSecret = Configure::read("Bitly.clientSecret");
		$callbackUrl = Configure::read("Bitly.callbackUrl");
		$code = $this->params["url"]["code"];

		$data ="client_id=".$appId."&redirect_uri=".urlencode($callbackUrl)."&client_secret=".$appSecret."&code=".$code;
		
		
		$header = array(
		    "Content-Type: application/x-www-form-urlencoded",
		    "Content-Length: ".strlen($data)
		);

		$context = array(
		    "http" => array(
		        "method"  => "POST",
		        "header"  => implode("\r\n", $header),
		        "content" => $data
		    )
		);
		$url = "https://api-ssl.bitly.com/oauth/access_token";
		$accessToken = file_get_contents($url, false, stream_context_create($context));

		parse_str($accessToken, $queryParameters);
		
		if(empty($queryParameters{"login"})){
			$this->redirect('/list');
		}

		$bitlyUser = array("user"=>$queryParameters{"login"});
		$this->Session->write('user.bitly', $bitlyUser);

		$this->redirect('/list');
	}
}