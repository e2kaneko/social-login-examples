<div class="hero-unit">
	<h1>Welcome!</h1>
	<p>ソーシャルネットワークのAPIを利用してログインするコードを集めるプロジェクトです。</p>
	<p>ウェブアプリケーションフレームワークに<?php echo $this->Html->link('CakePHP2.0', 'http://cakephp.jp/', array('target'=>'_blank')); ?>を、UIフレームワークに<?php echo $this->Html->link('bootstrap', 'http://twitter.github.com/bootstrap/', array('target'=>'_blank')); ?>を使っています。</p>
</div>

<div class="row">
	<div class="span16">

		<div class="row">
			<div class="span3">

				<!-- Login with Facebook -->
				<?php
				echo $this->Html->image('socialicon/facebook.png', array('alt'=> 'Facebook', 'border' => '0', 'width'=>'16', 'height'=>'16'));
				echo "&nbsp;";
				if($this->Auth->isFacebookLogin()){
					echo $facebookUser->name;
				}else{
					echo $this->Html->link(
							"Facebookでログイン",
							array('action' => '../facebook/login'),
							array('target' => '_self', 'escape' => false)
					);
				}
				?>

			</div>
			<div class="span3">

				<!-- Login with Twitter -->
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
			<div class="span3">

				<!-- Login with Github -->
				<?php
				echo $this->Html->image('socialicon/github.png', array('alt'=> 'Github', 'border' => '0', 'width'=>'16', 'height'=>'16'));
				echo "&nbsp;";
				if($this->Auth->isGithubLogin()){
					echo $githubUser->user->name;
				}else{
					echo $this->Html->link(
							"Githubでログイン",
							array('action' => '../github/login'),
							array('target' => '_self', 'escape' => false)
					);
				}
				?>

			</div>
			<div class="span3">

				<!-- Login with Google Plus -->
				<?php
				echo $this->Html->image('socialicon/google-plus.png', array('alt'=> 'Google+', 'border' => '0', 'width'=>'16', 'height'=>'16'));
				echo "&nbsp;";
				if($this->Auth->isGooglePlusLogin()){
					echo $googlePlusUser->name->givenName . " " . $googlePlusUser->name->familyName;
				}else{
					echo $this->Html->link(
							"Google+でログイン",
							array('action' => '../google_plus/login'),
							array('target' => '_self', 'escape' => false)
					);
				}
				?>

			</div>
		</div>
		
		<div class="row">
			<div class="span3">

				<!-- Login with Instagram -->
				<?php
				echo $this->Html->image('socialicon/instagram.png', array('alt'=> 'Instagram', 'border' => '0', 'width'=>'16', 'height'=>'16'));
				echo "&nbsp;";
				if($this->Auth->isInstagramLogin()){
					echo $instagramUser{"username"};
				}else{
					echo $this->Html->link(
							"Instagramでログイン",
							array('action' => '../instagram/login'),
							array('target' => '_self', 'escape' => false)
					);
				}
				?>

			</div>
		    <div class="span3">
				&nbsp;
			</div>
		    <div class="span3">
				&nbsp;
			</div>
		    <div class="span3">
				&nbsp;
			</div>
		</div>

		<div class="row">
			<div class="span16" style="margin-top:10px;">

				<?php
					if($this->Auth->isLogin()){
						echo $this->Html->link(
								'<i class="icon-exclamation-sign"></i> すべてログアウト',
								array('action' => '../Logout/all'),
								array('target' => '_self', 'escape' => false, 'class' => 'btn btn-small')
						);
					}else{
						echo $this->Html->link(
								'<i class="icon-exclamation-sign"></i> すべてログアウト',
								"javascript:return false;",
								array('target' => '_self', 'escape' => false, 'class' => 'btn btn-small disabled')
						);
					}
				?>

			</div>
		</div>
	</div>
</div>

