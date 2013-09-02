<?php echo '<h1>Persons List</h1>'; ?>

<?php
	foreach ($data as $person) {
		echo '<p><b>'.$person['name'].'</b> : '.$person['website'].'</p>';
	}
?>