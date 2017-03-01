<!--
CREDITS: pictures comes from the website of Don't Starve:
https://www.kleientertainment.com/games/dont-starve
-->
	
<?php include("form.php"); ?>
		
<!-- Add Form CREDITS: lecture4 from CS2300 -->

	<?php
		$delimiter = '\t';
		// Check non empty
		if (isset($_POST['add_submit']) && !empty($_POST['inputName']) && !empty($_POST['inputImage']) && !empty($_POST['inputHunger']) && !empty($_POST['inputHealth']) && !empty($_POST['inputSanity']) && !empty($_POST['inputPerk'])) {
			$file_pointer = fopen("files/data.txt", "a+") or die("Unable to open file!");
			
			// filter: htmlentities 
			$name = htmlentities($_POST['inputName']);
			$gender = htmlentities($_POST['inputGender']);
			$hunger = htmlentities($_POST['inputHunger']);
			$health = htmlentities($_POST['inputHealth']);
			$sanity = htmlentities($_POST['inputSanity']);
			$perk = htmlentities($_POST['inputPerk']);
			$image = strip_tags($_POST['inputImage']);
			$difficulty = htmlentities($_POST['inputDifficulty']);

			// Write to data.txt
			fputs($file_pointer, "\n$name$delimiter$gender$delimiter$hunger$delimiter$sanity$delimiter$health$delimiter$perk$delimiter$image$delimiter$difficulty");
			// Close data.txt
			fclose($file_pointer); 
		}
	?>
	
	<!-- CREDITS: code from CS2300 lecture2 -->
	<div class="add_search_body">
		<div class="form_container">
		<form id = "add_form" name = "add_form" class = "form" method = "POST" action = "add.php" onsubmit = "return validate()">
			<div class="first_line">
				<input id = "inputName" type = "text" placeholder="NAME" name = "inputName"/> 
				<input id = "inputHunger" type = "text" placeholder="HUNGER" name = "inputHunger"/> 
				<input id = "inputSanity" type = "text" placeholder="SANITY" name = "inputSanity"/> 
				<input id = "inputHealth" type = "text" placeholder="HEALTH" name = "inputHealth"/> 
			</div>		
  			<div class="first_line">
  				<input type="radio" name="inputGender" value = "Male" checked /><h2>Male</h2>
  				<input type="radio" name="inputGender" value = "Female" /> <h2>Female</h2>
  			</div>	
  			<div class="first_line">
  				<input type="radio" name="inputDifficulty" value = "Easy" checked /> <h2>Easy</h2>
  				<input type="radio" name="inputDifficulty" value = "Medium" /> <h2>Medium</h2>
  				<input type="radio" name="inputDifficulty" value = "Difficult" /> <h2>Difficult</h2>
			</div>	
			<textarea maxlength = "1000" id = "inputPerk" placeholder="PERK" rows="4" cols="100" name = "inputPerk"></textarea> 
			<div class="add_error">				
				<input id="inputImage" type="text" placeholder="IMAGE URL" name="inputImage"/> 
				<input id = "submit" class="button" type = "submit" name = "add_submit" value = "ADD"/> 
			</div>	
			<!-- if not valid, report errors -->
			<h3 id="add_error_message" class="add_error_message"></h3>	
		</form>	
		</div>
	</div>		
	</body>

</html>