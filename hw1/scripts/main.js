/**

	INFO/CS 2300 Spring 2017 - Homework 1
	Created By: Batya Zamansky and Brandon Giraldo

	This is main.js, the file (and only file) you will edit to test your work.

	This file has 5 problems, each outlined in a comment. You must write your solutions
	between //START CODE QX and //END CODE QX for each question.

	The first code in this file is an ajax call to a local resource, pokemon.json. You will need to use
	this again for questions 4 and 5. Feel free to reuse --- START * --- to --- END * --- when
	building your solutions for those questions.

	Do not edit data/pokemon.json or pokemon.js. Again, this is the only file you will need to edit.

	You can (and are encouraged to) use console.log() to debug your work as you work along. Also check
	the DOM using the inspector to know exactly where your html result is going to be outputted to. Use
	jQuery as necessary. (exception in question 2 with show/hide functions)

	Though there are not any PHP files in this assignment, you must run it on a
	server (local on your computer or on the course server) since there is an
	ajax call to a resource. Most browsers will throw
	an error if you try to load data from an external source while not running on a server.
	You can read more about that here:

	https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS

	Have fun!

**/

window.onload = function() {
	// --- START OF AJAX CALL ---

	// ajax call to pokemon.json
	var request = $.ajax({
		type: 'GET',
		url: "data/pokemon.json",
		dataType: "json"
	});

	// When the call is complete, we have access to the data
	request.done(function(data) {
		// This is your array of pokemon, the data was converted into an object array
		var pokemonArray = $.map(data, function(value, index) {
    		return [value];
		});
		// show the array of pokemon objects
		console.log(pokemonArray);
		// Loop over the objects in the array
		pokemonArray.forEach(function(item) {
			// making a new instance of the Pokemon object while looping over the pokemon objects from
			// the array. Be sure to look at the properties of each object in the console.
			var pokemon = new Pokemon(item.name, item.weight, item.sprites, item.stats, item.types, "full");
			// jquery to append the html to the .row class, need to call render on pokemon object to get html
			$(".results .row").append(pokemon.render);
		});
	});

	// --- END OF AJAX CALL ---

	/**
		Question 1 - Changing font-size
		10 points

		Change the font size of the pokemon weight and pokemon item elements
		based on the selected value of #font-select

		target the .item and .weight classes
	**/
	$("#font-select").change(function() {
		// START CODE Q1
		var size = $("#font-select").find(":selected").val();
		$(".weight").css("font-size", size+"px");
		$(".item").css("font-size", size+"px");
		// CREDITS: http://www.360doc.com/content/11/0320/19/4359026_102948793.shtml

		// END CODE Q1

	});

	/**
		Question 2 - Show/Hide
		10 points

		Show/hide the all sprite images when the box is checked/unchecked.

		Do not use jQuery show / hide functions, cell text formatting needs to be retained.

		In other words, the sprites should not be 'visible'.
	**/
	$("#hide-sprites").change(function() {
		// START CODE Q2
		if(document.getElementById('hide-sprites').checked) {
    		$(".cell img").css("visibility","hidden");
		} else {
    		$(".cell img").css("visibility","visible");
		}
		// END CODE Q2

	})

	/**
		Question 3 - Adding a font-size
		15 points

		Add a font size to the select menu if the input is a number.
		You must check that it is a number.
		Look at the DOM to make sure you append the value to the right drop down menu.
		Also validate that it is between 5 - 22, otherwise ignore it completely

		Clear the add-font text field once the accepted number has been appended to
		the right drop down menu

		It is OK if the resulting selections do not display in order
	**/
	$("#add-font-size").click(function(){
		// START CODE Q3
		var newfont = $("#fontSizeInput").val(); 
		
		$("input[id='fontSizeInput']").val("");  
		if ($.isNumeric(newfont) && newfont <= 22 && newfont >= 5) {
			$("#font-select").append("<option value = " + newfont + " > " + newfont + " pixels</option>");
		}
		// END CODE Q3

	});

	/**
		Question 4 - Search
		25 points

		Filter by pokemon name. You will need to make an ajax call to pokemon.json
		You need to check the inputed value from search field against the name of
		each pokemon from the returned ajax call.

		The search should be case insensitive. Searching for "Wa" or "wa" should display Wartortle.

		When search is cleared, show all pokemon as would appear on first load

		Be sure to clear existing entries from the display before appending new items to the DOM

		Look at --- START * --- to --- END * ---
	**/
	$(".search").keyup(function() {
		// START CODE Q4
		var searchName = $("#inlineFormInputGroup").val().toLowerCase(); 
		$(".results .row").empty();
			// ajax call to pokemon.json
		var request = $.ajax({
			type: 'GET',
			url: "data/pokemon.json",
			dataType: "json"
		});

		// When the call is complete, we have access to the data
		request.done( function(data) {
			// This is your array of pokemon, the data was converted into an object array
			var pokemonArray = $.map(data, function(value, index) {
    			return [value];
			});
			// show the array of pokemon objects
			
			pokemonArray.forEach(function(item) {
				// making a new instance of the Pokemon object while looping over the pokemon objects from
				// the array. Be sure to look at the properties of each object in the console.
				var pokemon = new Pokemon(item.name, item.weight, item.sprites, item.stats, item.types, "full");
				var pokemonName = pokemon.name.toLowerCase();
				if(pokemonName.includes(searchName)) { 
					// jquery to append the html to the .row class, need to call render on pokemon object to get html
					$(".results .row").append(pokemon.render);
				}
			});
		});
		// END CODE Q4


	});

	/**
		Question 5 - Sort by
		40 points (10 points for each sort)

		For name, alphabetical
		For Weight, largest first
		For Stats, largest sum of all stats first
		For Types, most types first

		You will need to make an ajax call to pokemon.json
		You need to check the inputed value from the DOM
		against a field (or newly computed field) of the pokemon from the returned call

		Be sure to clear existing entries from the display before appending new items to the DOM

		You should use either a series of if else statements or case statements to handle
		either of the 4 types of sorting. If the default option is selected, dont to anything.

		This resource may be helpful in organizing the data
		https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/sort
	**/
	$("#sort-select").change(function() {
		// START CODE Q5
		var sortType = $("#sort-select").find(":selected").val();
		$(".results .row").empty();

			// ajax call to pokemon.json
		var request = $.ajax({
			type: 'GET',
			url: "data/pokemon.json",
			dataType: "json"
		});

		// When the call is complete, we have access to the data
		request.done( function(data) {
			// This is your array of pokemon, the data was converted into an object array
			var pokemonArray = $.map(data, function(value, index) {
    			return [value];
			});
			// show the array of pokemon objects
			console.log(pokemonArray);
			// Loop over the objects in the array

			if(sortType == "name") { 
				pokemonArray.sort(function(a, b) {
					return +(a.name.toLowerCase() > b.name.toLowerCase()) || +(a.name.toLowerCase() === b.name.toLowerCase()) - 1;
				})
			}

			if(sortType == "weight") { 
				pokemonArray.sort(function(a, b) {
					return b.weight - a.weight;
				})
			}

			if(sortType == "statistics") { 
				pokemonArray.sort(function(a, b) {
					var suma = 0;
					var sumb = 0;
					for (var i = 0, len = a.stats.length; i < len; i++) {
  						suma += a.stats[i].base_stat;
					}

					for (var i = 0, len = b.stats.length; i < len; i++) {
  						sumb += b.stats[i].base_stat;
					}
					return sumb - suma;
				})
			}

			if(sortType == "types") { 
				pokemonArray.sort(function(a, b) {
					return b.types.length - a.types.length;
				})
			}

			pokemonArray.forEach(function(item) {
				var pokemon = new Pokemon(item.name, item.weight, item.sprites, item.stats, item.types, "full");
				// jquery to append the html to the .row class, need to call render on pokemon object to get html
				$(".results .row").append(pokemon.render);
			});
		});

		// END CODE Q5

		// Remember to upload this file to your server account and upload ready.js to CMS
		// to indicate you are ready for grading

	});

}