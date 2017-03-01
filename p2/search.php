<!--
CREDITS: pictures comes from the website of Don't Starve:
https://www.kleientertainment.com/games/dont-starve
-->

<!-- include form part -->
<?php include("form.php"); 
	
// Search Functionality 
	$allChar = array();

	if (!file_exists('files/data.txt')) {
		echo "No data.txt exists!";
		exit;
	} else {
	$file_pointer = fopen('files/data.txt', 'r');
	
	while (!feof($file_pointer)) { 
		$line = fgets($file_pointer); 
		$char = explode( '\t', $line ); 
		$allChar[] = new Character($char[0], $char[1], $char[2], $char[3], $char[4], $char[5], $char[6], $char[7]);
	}
	fclose($file_pointer);
	}

	$characters = $allChar;
	//read from data.txt
	if (isset($_POST['search_submit'])) {
	// Open data.txt
		$file_pointer = fopen("files/data.txt", "r"); 
		$characters = array();

		//filter the input to lowercase and prevent html interruption
		$searchName = isset($_POST['searchName']) ? htmlentities(strtolower($_POST['searchName'])) : false;
		$searchGender = isset($_POST['searchGender']) ? htmlentities(strtolower($_POST['searchGender'])) : false;
		$searchDifficulty = isset($_POST['searchDifficulty']) ? htmlentities(strtolower($_POST['searchDifficulty'])) : false;

		// find matching CREDITS: http://www.w3school.com.cn/php/func_string_strtolower.asp
		while (!feof($file_pointer)) { 
			$line = fgets($file_pointer); 

			//convert to lower case to compare CREDITS: http://stackoverflow.com/questions/16477098/how-can-i-remove-n-in-string-in-php
			$line1 = trim(preg_replace('/\s\s+/', ' ', $line));
			$lowerCaseLine = strtolower($line1); 
			$lowerCaseChar = explode('\t', $lowerCaseLine); 
			
			$nameMatching = (empty($searchName) || preg_match("/$searchName/", $lowerCaseChar[0]));
			$genderMatching = (empty($searchGender) || (strcasecmp($searchGender, $lowerCaseChar[1]) == 0));
			$difficultyMatching = (empty($searchDifficulty) || (strcasecmp($searchDifficulty, $lowerCaseChar[7]) == 0));
			$isMatch = $nameMatching && $genderMatching && $difficultyMatching;
			if ($isMatch) {
				$char = explode('\t', $line); 
				$characters[] = new Character($char[0], $char[1], $char[2], $char[3], $char[4], $char[5], $char[6], $char[7]);
			}
		}
	}
?>

<!-- Search Form -->
<div class="add_search_body">
	<div class="form_container">
	<form id="search_form" name="search_form" class="form" method="POST" action="search.php">
		<!-- Search and name fields -->
		<div class="first_line">
			<input id="searchName" type="text" placeholder="Name" name="searchName" maxlength="25" autofocus pattern="[0-9A-Za-z-_ ]*">
			<select name="searchGender" id="searchGender" class="search-select"> 
				<option value="">Gender</option>
				<option value="Female">Female</option>
				<option value="Male">Male</option>
			</select>
			<select name="searchDifficulty" id="searchDifficulty" class="search-select"> 
				<option value="">Difficulty</option>
				<option value="easy">easy</option>
				<option value="medium">medium</option>
				<option value="difficult">difficult</option>
			</select>
		</div>
		<div class="basic-profile-form">
			
			<input id="submit" class="button" type="submit" name="search_submit" value="SEARCH"> 
		</div>
	</form>
	</div>
	 <!--
	Catalog of Don't Starve Catalog
	CREDITS: all the pictures and data are from don't starve wikihttp://dontstarve.wikia.com/wiki/Don%27t_Starve_Wiki
		code from lectures in cs2300 and my project 1 about.php
		I mainly refer to: http://www.website-templates.info/homepage/free-templates/03/1/page2.html#
      	and http://www.website-templates.info/homepage/free-templates/04/1/index.html
		CREDITS: from my about.php in project1
		pictures from Don't Starve Wikia
		http://dontstarve.wikia.com/wiki/Don%27t_Starve_Wiki
	-->


	<!-- this is the sort and header part of catalog -->
	<div class="catalog">	
	<div class="catalog_header">
		<img src="assets/logo.png"  alt="logo" width="398" height="203"/>;
	</div>

	<p>CREDITS: All images from Don't Starve Wikia.</p>

	<!-- this is the display part of catalog-->
	<div class='catalog_main'>
		<?php
			
		global $characters;
		$CombineIcon = 'assets/combine.jpg';

		foreach ($characters as $char) {
			$charName = $char->name;
			$charGender = $char->gender; 
			$charHunger = $char->hunger;
			$charSanity = $char->sanity;  
			$charHealth = $char->health; 
			$charPerk = $char->perk; 				
			$charImage = $char->imageURL; 
			$charDifficulty = $char->difficulty; 
		?>
		<div class='catalog_item'>
			<div class='catalog_image'>
           		<?php echo '<img src="' . $charImage . '" alt = $charName>';?>
           	</div>
          	<!-- above is character image, below is description.-->						
           	<div class='catalog_description'>
			<div class='show_catalog'>
				<div class='status_catalog'>
					<h3 class='name'><?php echo $charName ?></h3>
              		 <?php echo '<img src="' . $CombineIcon . '" alt = status>';?>
              		 <h4>&nbsp;&raquo;<?php echo $charHunger ?>&nbsp;&nbsp;&raquo;<?php echo $charSanity ?>&nbsp;&nbsp;&raquo;<?php echo $charHealth ?></h4>
				</div>
			</div>
			<div class='hide_catalog'>
				<h3 class='description'><?php echo $charDifficulty ?> | <?php echo $charGender ?></h3>
				<h4 class='description'><?php echo $charPerk ?></h4>
			</div>
			</div>
		</div>
	<?php } ?>
	</div>	
	</div>

</div>
</body>

</html>