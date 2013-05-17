<?php echo '<h1>Contact Us</h1>'; ?>

<?php if (isset($data['thanks'])) {
	echo $data['thanks'];
}
else { 
?>
<?php echo $data['message']; ?>
<?php echo HtmlHelper::formOpen('form', 'my/contact', 'POST'); ?>
<p>Name: <br/><?php echo HtmlHelper::textInput('myname', 'name'); ?></p>
<p>Email: <br/><?php echo HtmlHelper::textInput('email', 'email'); ?></p>
<p>Subject: <br/><?php echo HtmlHelper::textInput('subject', 'subject'); ?></p>
<p>Message: <br/><?php echo HtmlHelper::textArea('message', 'message'); ?></p>
<p><?php echo HtmlHelper::buttonSubmit('button1', 'OK'); ?></p>
<?php echo HtmlHelper::formClose(); ?>
<?php } ?>