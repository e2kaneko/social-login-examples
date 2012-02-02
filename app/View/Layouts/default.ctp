<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Social Login Examples : <?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap.plus');
	?>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="i-bar"></span>
					<span class="i-bar"></span>
					<span class="i-bar"></span>
         		</a>
				<a class="brand" href="#">Social Login Examples</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="https://github.com/e2kaneko/SocialLoginExamples" target="_blank">View project on Github</a></li>
						<li><a href="http://travis-ci.org/#!/e2kaneko/SocialLoginExamples" target="_blank">View project CI on Travis</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>

		<div class="row">
			<div class="span16">
				<?php echo $this->element('sql_dump'); ?>
			</div>
		</div>
		
		<hr>

		<footer>
			<p>&copy; Company 2012</p>
		</footer>

	</div> <!-- /container -->
</body>
</html>