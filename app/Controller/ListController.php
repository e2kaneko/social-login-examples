<?php
class ListController extends AppController {
	public $name = 'List';
	public $helpers = array('Html','Form','Auth');
	public $components = array('Session');

	public function index() {
		$facebookUser = $this->Session->read('user.facebook');
		$this->set('facebookUser', $facebookUser);
		
		$twitterUser = $this->Session->read('user.twitter');
		$this->set('twitterUser', $twitterUser);
	}
}