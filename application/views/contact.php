<?php echo '<h1>Contact Us</h1>'; ?>

<?php if (isset($data['thanks'])) {
	echo '<div class="alert alert-success">';
	echo $data['thanks'];
	echo '</div>';
}
else { 
?>
<p class="text-info">
	<?php echo $data['message']; ?>
</p>
<?php echo HtmlHelper::formOpen('my/contact', 'POST' , array('id' => 'myform')); ?>
<p><label> Name: </label><?php echo HtmlHelper::textInput('name'); ?></p>
<p><label> Email: </label><?php echo HtmlHelper::textInput('email'); ?></p>
<p><label> Subject: </label><?php echo HtmlHelper::textInput('subject'); ?></p>
<p><label> Message: </label><?php echo HtmlHelper::textArea('message', array('rows' => '10', 'cols' => '10')); ?></p>
<p><?php echo HtmlHelper::buttonSubmit('Contact' , array('class' => 'btn btn-primary')); ?></p>
<?php echo HtmlHelper::formClose(); ?>
<?php } ?>