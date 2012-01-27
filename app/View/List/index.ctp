<ul class="breadcrumb">
	<li class="active"><?php echo $this->Html->link("Home", array('action' => '../List'));?></li>
</ul>

<!-- Login with Facebook -->
<div>
<?php
echo $this->Html->image('socialicon/facebook.png', array('alt'=> 'Facebook', 'border' => '0', 'width'=>'16', 'height'=>'16'));
echo "&nbsp;";
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

<!-- Login with Twitter -->
<div>
<?php
echo $this->Html->image('socialicon/twitter.png', array('alt'=> 'Twitter', 'border' => '0', 'width'=>'16', 'height'=>'16'));
echo "&nbsp;";
if($this->Auth->isTwitterLogin()){
	echo $twitterUser{"user"};
}else{
	echo $this->Html->link(
			"Twitterでログイン",
			array('action' => '../twitter/login'),
			array('target' => '_self', 'escape' => false)
	);
}
?>
</div>

<!-- Login with Github -->
<div>
<?php
echo $this->Html->image('socialicon/github.png', array('alt'=> 'Github', 'border' => '0', 'width'=>'16', 'height'=>'16'));
echo "&nbsp;";
if($this->Auth->isGithubLogin()){
	echo $githubUser->user->name;
}else{
	echo $this->Html->link(
			"Githubでログイン",
			array('action' => '../Login/github'),
			array('target' => '_self', 'escape' => false)
	);
}
?>
</div>

<!-- Login with Google Plus -->
<div>
<?php
echo $this->Html->image('socialicon/google-plus.png', array('alt'=> 'Github', 'border' => '0', 'width'=>'16', 'height'=>'16'));
echo "&nbsp;";
if($this->Auth->isGooglePlusLogin()){
	echo $googlePlusUser->name->givenName . " " . $googlePlusUser->name->familyName;
}else{
	echo $this->Html->link(
			"Google+でログイン",
			array('action' => '../Login/googlePlus'),
			array('target' => '_self', 'escape' => false)
	);
}
?>
</div>

<div>
<?php
if($this->Auth->isLogin()){
	echo $this->Form->postLink(
		'すべてログアウトする',
		array('action' => '../Logout/all'),
		array('confirm' => 'ログアウトします。よろしいですか？'));
}
?>
</div>