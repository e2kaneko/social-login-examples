<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Social Login Examples : <?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css('http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css');
	?>
</head>
<body>
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="#">Social Login Examples</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="hero-unit">
			<h1>Welcome!</h1>
			<p>ソーシャルネットワークのAPIを利用してログインするコードを集めるプロジェクトです。</p>
			<p>ウェブアプリケーションフレームワークに<?php echo $this->Html->link('CakePHP2.0', 'http://cakephp.jp/', array('target'=>'_blank')); ?>を、UIフレームワークに<?php echo $this->Html->link('bootstrap', 'http://twitter.github.com/bootstrap/', array('target'=>'_blank')); ?>を使っています。</p>
  		</div>



		<div class="row">
			<div class="span16">
				<?php echo $this->Session->flash(); ?>
				<?php echo $content_for_layout; ?>
			</div>
		</div>

		<div class="row">
			<div class="span16">
				<?php echo $this->element('sql_dump'); ?>
			</div>
		</div>

		<footer>
			<p>&copy; Company 2011</p>
		</footer>

	</div> <!-- /container -->
</body>
</html>