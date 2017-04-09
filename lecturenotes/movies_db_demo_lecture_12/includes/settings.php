<?php
	//Array of fields used
	$fields = array(
		array( 
			'term' => 'title',
			'heading' => 'Title',
			'filter' => FILTER_SANITIZE_STRING,
		),
		array( 
			'term' => 'year',
			'heading' => 'Year',
			'filter' => FILTER_SANITIZE_NUMBER_INT,
		),
		array( 
			'term' => 'length',
			'heading' => 'Length (min)',
			'filter' => FILTER_SANITIZE_NUMBER_INT,
		),
	);

?>
