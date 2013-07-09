<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->getTitle();?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="<?php echo HtmlHelper::baseUrl(); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo HtmlHelper::baseUrl(); ?>/css/main.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo HtmlHelper::baseUrl(); ?>/bootstrap/js/bootstrap.min.js"></script>
	</head>
<body>
	<div id = 'wrapper'>
		<div class = 'container'>
			<div class="navbar navbar-inverse">
			<div class="navbar-inner">
			<a class="brand" href="<?php echo HtmlHelper::newUrl(); ?>"><?php echo MyApplication::get()->params('name'); ?></a>
			<ul class="nav">
				<li class="active"><?php echo HtmlHelper::link('my', 'Home'); ?></li>
				<li><?php echo HtmlHelper::link('my/about', 'About', array('id' => 'about')); ?></li>
				<li><?php echo HtmlHelper::link('my/contact', 'Contact'); ?></li>
				<?php if (is_null(Session::init()->get('name'))) { ?>
				<li><?php echo HtmlHelper::link('my/login', 'Login'); ?></li>
				<?php } else { ?>
				<li><?php echo HtmlHelper::link('my/logout', 'Logout'); ?></li>
				<?php } ?>
			</ul>

			<form class="navbar-search pull-right">
				<input type="text" class="search-query" placeholder="Search">
			</form>
		</div>
		</div>
			<div class="row">
				<div class = 'span3'>
					<ul class="nav nav-list">
						<li class="nav-header">Menu 1</li>
						<li class="active"><a href="#">PHP</a></li>
						<li><a href="#">Python</a></li>
						<li><a href="#">Javascript</a></li>
						<li><a href="#">MongoDB</a></li>
						<li><a href="#">PostgreSQL</a></li>
						<li><a href="#">MySQL</a></li>
						<li><a href="#">Ruby</a></li>
						<li><a href="#">C/C++</a></li>
					</ul>
					<br/>

					<ul class="nav nav-list">
						<li class="nav-header">Menu 2</li>
						<li><a href="#">PHP</a></li>
						<li><a href="#">Python</a></li>
						<li><a href="#">Javascript</a></li>
						<li><a href="#">MongoDB</a></li>
						<li><a href="#">Ruby</a></li>
						<li><a href="#">C/C++</a></li>
					</ul>
				</div>
				<div class = 'span8'>
					<?php include $content; ?>
				</div>
			</div>
		</div>

		<div id = 'push'></div>
	</div>

	<div id = 'footer'>
		<div class="container">
			<p class="muted credit">Copyright &copy; <?php echo date('Y');?> by <b><?php echo MyApplication::get()->params('name');?></b>
			<br/>Design: <a href="http://twitter.github.io/bootstrap">Twitter Bootstrap</a></p>
		</div>
	</div>
</body>
</html>