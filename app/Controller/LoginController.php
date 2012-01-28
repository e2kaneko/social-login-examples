<?php
class LoginController extends AppController {
	public $name = 'Login';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function googlePlus() {
		// @see http://code.google.com/intl/ja/apis/accounts/docs/OAuth2.html

		$appId = Configure::read("GooglePlus.appId");
		$appSecret = Configure::read("GooglePlus.appSecret");
		$callbackUrl = Configure::read("GooglePlus.callbackUrl");
		$googlePlusApiKey = Configure::read("GooglePlus.plusApiKey");
		$code = null;

		if(isset($this->params["url"]["code"])){
			$code = $this->params["url"]["code"];
		}
			
		if(empty($code)) {
			$dialog_url = "https://accounts.google.com/o/oauth2/auth?client_id="
			. $appId . "&redirect_uri=" . urlencode($callbackUrl) . "&response_type=code&scope=https://www.googleapis.com/auth/plus.me";

			$this->redirect($dialog_url);
		}else{

			// callback

			$tokenUrl = "https://accounts.google.com/o/oauth2/token";

			$tokenPostData = array(
				"client_id"=>$appId,
				"redirect_uri"=>$callbackUrl,
				"client_secret"=>$appSecret,
				"code"=>$code,
				"grant_type"=>"authorization_code",
			);
			$tokenPostData = http_build_query($tokenPostData, "", "&");

			//header
			$header = array(
			    "Content-Type: application/x-www-form-urlencoded",
			    "Content-Length: ".strlen($tokenPostData)
			);
				
			$context = array(
			    "http" => array(
			        "method"  => "POST",
			        "header"  => implode("\r\n", $header),
			        "content" => $tokenPostData
			)
			);
				
			$accessToken = file_get_contents($tokenUrl, false, stream_context_create($context));
			$accessToken = json_decode($accessToken);
			$accessToken = $accessToken->access_token;
				
			$graph_url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $accessToken;
			$user = json_decode(file_get_contents($graph_url));
				
			$userUrl = "https://www.googleapis.com/plus/v1/people/{$user->id}?fields=name&pp=1&key={$googlePlusApiKey}";
			$userData = file_get_contents($userUrl);
			$googlePlusUser = json_decode($userData);

			$this->Session->write('user.google-plus', $googlePlusUser);

			$this->redirect('/list');
		}
	}

}