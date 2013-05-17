<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->getStyle();?>"/>
<title><?php echo $this->getTitle();?></title>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<p><?php echo HtmlHelper::image('logo', HtmlHelper::baseUrl().'/scripts/css/logo.png','', '64', '64'); ?></p>
		<h1><?php echo MyApplication::get()->params('name');?></h1>
	</div>

	<div id="navigation"><p><b><?php echo MyApplication::get()->params('name');?></b> - is the best site in the world!</p></div>

	<div id="leftcolumn">
		<p><?php echo HtmlHelper::link('my', 'Home'); ?></p>
		<p><?php echo HtmlHelper::link('my/about', 'About'); ?></p>
		<p><?php echo HtmlHelper::link('doc', 'Documentation'); ?></p>
		<p><?php echo HtmlHelper::link('my/contact', 'Contact'); ?></p>
	</div>

	<div id="rightcolumn">
		<?php
			include $content;
		?>
	</div>
	<div id="footer"><p>Copyright &copy; <?php echo date('Y');?> by <b><?php echo MyApplication::get()->params('name');?></b></p></div>
</div>
</body>
</html>
