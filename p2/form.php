<!--
	CREDITS: pictures comes from the website of Don't Starve:
	https://www.kleientertainment.com/games/dont-starve
-->

<!-- Header -->
<?php include("header.php"); 

class Character { 
		public $name;
		public $gender; 
		public $hunger;
		public $sanity;
		public $health;
		public $perk;
		public $imageURL;
		public $difficulty;

		function __construct($name = "", $gender = "", $hunger = "", $sanity = "", $health = "", $perk = "", $imageURL = "", $difficulty = "") { 
			$this->name = $name;
			$this->gender = $gender;
			$this->hunger = $hunger; 
			$this->sanity = $sanity;
			$this->health = $health;
			$this->perk = $perk;
			$this->imageURL = $imageURL; 
			$this->difficulty = $difficulty; 
		}
	}
?>


<!-- this form php reads files from data.txt -->
<?php

	$characters = array();
	// check whether there is data.txt
	if (!file_exists('files/data.txt')) {
		echo "No data.txt exists!";
		exit;
	}

	$file_pointer = fopen('files/data.txt', 'r');

	while (!feof($file_pointer)) { 
		$line = fgets($file_pointer); 
		//CREDITS: http://stackoverflow.com/questions/16477098/how-can-i-remove-n-in-string-in-php
		$line1 = trim(preg_replace('/\s\s+/', ' ', $line));
		$char = explode( '\t', $line1); 
		$characters[] = new Character($char[0], $char[1], $char[2], $char[3], $char[4], $char[5], $char[6], $char[7]);
	}

	fclose($file_pointer);
?>