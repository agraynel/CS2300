//https://www.sitepoint.com/14-jquery-modal-dialog-boxes/
//https://www.w3schools.com/howto/howto_css_modals.asp
// Show delete album form popup 
function show_delete_album(aID) {
	document.getElementById('delete_album_popup').style.display = "block";
	var album = document.getElementById('#' + aID);
	document.getElementById('delete_album_id').value = aID;
}

// Hide delete album form popup
function close_delete_album() {
	document.getElementById('delete_album_popup').style.display = "none";
}

//Remove photo in album
// Show delete photo form popup 
function show_remove_album(pID, aID) {
	document.getElementById('remove_photo_popup').style.display = "block";
	var photo = document.getElementById('#' + pID);
	document.getElementById('remove_photo_pid').value = pID;
	document.getElementById('remove_photo_aid').value = aID;
}

// Hide delete photo form popup
function close_remove_album() {
	document.getElementById('remove_photo_popup').style.display = "none";
}


// Delete photo in database modal
//show
function show_delete_photo(pID) {
	document.getElementById('delete_photo_popup').style.display = "block";
	var photo = document.getElementById('##' + pID);
	document.getElementById('delete_photo_id').value = pID;
}
// hide
function close_delete_photo() {
	document.getElementById('delete_photo_popup').style.display = "none";
}



// Edit album modal
//show
function show_edit_album(aID) {
	document.getElementById('edit_album_popup').style.display = "block";
	var album = document.getElementById('edit_album_' + aID);
	document.getElementById('edit_album_id').value = aID;
}
//hide
function close_edit_album() {
	document.getElementById('edit_album_popup').style.display = "none";
}


//Edit photo modal
//show
function show_edit_photo(pID) {
	document.getElementById('edit_photo_popup').style.display = "block";
	var photo = document.getElementById('edit_photo_' + pID);
	document.getElementById('edit_photo_id').value = pID;
}
//hide
function close_edit_photo() {
	document.getElementById('edit_photo_popup').style.display = "none";
}