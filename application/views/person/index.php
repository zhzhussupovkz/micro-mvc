<?php echo '<h1>Persons List</h1>'; ?>

<?php
	foreach ($data as $person) {
		echo '<p><b>'.HtmlHelper::link('person/view/'.$person['id'], $person['name']).'</b> : '.$person['website'].'</p>';
	}
?>