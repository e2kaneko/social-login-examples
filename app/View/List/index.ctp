<ul class="breadcrumb">
	<li class="active"><?php echo $this->Html->link("Home", array('action' => '../List'));?></li>
</ul>

<div>
<?php
echo $this->Html->image('socialicon/facebook.png', array('alt'=> 'Facebookアカウントでログイン', 'border' => '0', 'width'=>'16', 'height'=>'16'));
if($this->Auth->isFacebookLogin()){
	echo $facebookUser->name;
}else{
	echo $this->Html->link(
			"Facebookでログイン",
			array('action' => '../Login/facebook'),
			array('target' => '_self', 'escape' => false)
);
}
?>
</div>

<div>
<?php
echo $this->Html->image('socialicon/twitter.png', array('alt'=> 'Twitterアカウントでログイン', 'border' => '0', 'width'=>'16', 'height'=>'16'));
echo $this->Html->link(
		"Twitterでログイン",
		array('action' => '../Login/twitter'),
		array('target' => '_self', 'escape' => false)
);
?>
</div>

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