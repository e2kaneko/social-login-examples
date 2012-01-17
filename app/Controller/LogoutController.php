<?php
class LogoutController extends AppController {
	public $name = 'Logout';
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function all() {
		$this->Session->delete('user.facebook');
		$this->Session->delete('user.twitter');
		$this->Session->delete('user.github');
		$this->Session->delete('user.google-plus');
		$this->Session->destroy();
		$this->redirect('/List');
	}
}

