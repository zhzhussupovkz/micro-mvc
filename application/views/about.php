<?php echo '<h1>About my site</h1>'; ?>

<?php
	foreach ($data as $value) {
		echo '<p>'.$value['name'].'</p>';
}
?>