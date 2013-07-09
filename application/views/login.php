<?php echo '<h1>Login</h1>'; ?>

<?php if (isset($data['auth'])) {
	echo '<div class="alert '.$data['type'].'">';
	echo $data['auth'];
	echo '</div>';
}
else {
	echo '<p class="text-info">';
	echo 'Please fill out the following form for login:';
	echo '</p>';
?>
<?php echo HtmlHelper::formOpen('my/login', 'POST'); ?>
<p><label> Name: </label><?php echo HtmlHelper::textInput('username'); ?></p>
<p><label> Password: </label><?php echo HtmlHelper::passInput('password'); ?></p>
<p><?php echo HtmlHelper::buttonSubmit('Login', array('class' => 'btn btn-primary')); ?></p>
<?php echo HtmlHelper::formClose(); ?>
<?php } ?>