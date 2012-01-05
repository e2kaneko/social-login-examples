<ul class="breadcrumb">
	<li class="active"><?php echo $this->Html->link("Home", array('action' => '../List'));?></li>
</ul>

<?php

echo $this->Html->link(
		$this->Html->image('socialicon/097232-3d-transparent-glass-icon-social-media-logos-facebook-logo-square.png', array('alt'=> 'Facebookアカウントでログイン', 'border' => '0', 'width'=>'128', 'height'=>'128')),
		array('action' => '../Login/facebook'),
		array('target' => '_self', 'escape' => false)
);

if($this->Auth->isFacebookLogin()){
	echo $facebookUser->name;
}

echo $this->Html->link(
		$this->Html->image('socialicon/097304-3d-transparent-glass-icon-social-media-logos-twitter-logo-square.png', array('alt'=> 'Twitterアカウントでログイン', 'border' => '0', 'width'=>'128', 'height'=>'128')),
		array('action' => '../Login/twitter'),
		array('target' => '_self', 'escape' => false)
);

?>

<div>
<?php
if($this->Auth->isFacebookLogin()){
	echo $this->Form->postLink(
		'すべてログアウトする',
		array('action' => '../Logout/all'),
		array('confirm' => 'ログアウトします。よろしいですか？'));
}
?>
</div>