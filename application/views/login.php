<?php echo '<h1>Login</h1>'; ?>

<?php if (isset($data['auth'])) {
	echo $data['auth'];
}
else { 
?>
<?php echo HtmlHelper::formOpen('form', 'my/login', 'POST'); ?>
<p>Name: <br/><?php echo HtmlHelper::textInput('myname', 'username'); ?></p>
<p>Email: <br/><?php echo HtmlHelper::passInput('password', 'password'); ?></p>
<p><?php echo HtmlHelper::buttonSubmit('button1', 'Login'); ?></p>
<?php echo HtmlHelper::formClose(); ?>
<?php } ?>