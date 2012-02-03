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

	function isInstagramLogin(){
		$instagramUser = $this->read("user.instagram");
		return !empty($instagramUser);
	}

	function isGooglePlusLogin(){
		$googleUser = $this->read("user.google-plus");
		return !empty($googleUser);
	}

	function isLinkedinLogin(){
		$linkedinUser = $this->read("user.linkedin");
		return !empty($linkedinUser);
	}

	function isLogin(){
		return ($this->isInstagramLogin() || $this->isTwitterLogin() || $this->isFacebookLogin() || $this->isGithubLogin() || $this->isGooglePlusLogin());
	}
}