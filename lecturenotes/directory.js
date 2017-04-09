//Declare a variable called "request" outside the functions so the variable is global
var request;

//Runs once the HTML is loaded but not necessarily all the images
$(document).ready(function() {
	//Initialize the request variable to null
	request = null;
	//Assign the function findNetIDInfo to the keyup event of the input
	$("#netid").on( "keyup", findNetIDInfo );
});

function findNetIDInfo() {
	//If there is an active request out to the server, 
	//abandon it in preparation for starting over
	if (request) {
		request.abort();
	}
	//Get the value of the netID from the input
	var netIdFromForm = $("#netid").val();
	//Prepare the data by putting it in JSON format
	var dataToSend = { netid: netIdFromForm };
	//Initiate the ajax call
	request = $.ajax( {
		url: "includes/directory_lookup.php",
		type: "get",
		data: dataToSend,
		dataType: "json"
	} );
	//Set the displayNetIDInfo function to run after a successful response
	request.done(displayNetIDInfo);	
}
//runs on a successful response (which may include an error message )
function displayNetIDInfo(response) {
	//Define an array of nodes to clear of text
	var result_nodes = Array("error", "first_name", "last_name", "email");

	//Set the text to an empty string
	for (i in result_nodes) {
		$("#"+result_nodes[i]).text("");
	}

	// Each json entry will be of the form "nodeid" : "value".  
	// Use this fact to stuff the values in the node with the id of index.
	for (i in response) {
		$("#"+i).text( response[ i ] );
	}				
}
