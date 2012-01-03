<?php

echo $this->Html->link(
		$this->Html->image('socialicon/097232-3d-transparent-glass-icon-social-media-logos-facebook-logo-square.png', array('alt'=> 'Facebookアカウントでログイン', 'border' => '0', 'width'=>'128', 'height'=>'128')),
		array('action' => 'Login/Facebook'),
		array('target' => '_self', 'escape' => false)
);

echo $this->Html->image('socialicon/097304-3d-transparent-glass-icon-social-media-logos-twitter-logo-square.png', array('alt'=> 'Twitterアカウントでログイン', 'border' => '0', 'width'=>'128', 'height'=>'128'));

?>