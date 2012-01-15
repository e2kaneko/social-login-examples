<?php
App::uses('SessionHelper', 'View/Helper');

class AuthHelper extends SessionHelper {
	function isFacebookLogin() {
		$facebookUser = $this->read("user.facebook");
		return !empty($facebookUser);
	}
	
	function isTwitterLogin(){
		$twitterUser = $this->read("user.twitter");
		return !empty($twitterUser);
	}
	
	function isGithubLogin(){
		$githubUser = $this->read("user.github");
		return !empty($githubUser);
	}
	
	function isLogin(){
		return ($this->isTwitterLogin() || $this->isFacebookLogin() || $this->isGithubLogin());
	}
}