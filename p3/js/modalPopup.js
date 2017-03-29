//https://www.sitepoint.com/14-jquery-modal-dialog-boxes/
//https://www.w3schools.com/howto/howto_css_modals.asp
// Show delete album form popup 
function showDeleteAlbumPopup(aID) {
	console.log(albumId);
	document.getElementById('delete_album_popup').style.display = "block";
	var album = document.getElementById('#' + aID);
	document.getElementById('delete_album_id').value = aID;
}

// Hide delete album form popup
function closeDeleteAlbumPopup() {
	document.getElementById('delete_album_popup').style.display = "none";
}

//Remove photo in album
// Show delete photo form popup 
function showDeletePhotoInAlbumPopup(pID, aID) {
	document.getElementById('remove_photo_popup').style.display = "block";
	var photo = document.getElementById('#' + pID);
	document.getElementById('remove_photo_pid').value = pID;
	document.getElementById('remove_photo_aid').value = aID;
}

// Hide delete photo form popup
function closeDeletePhotoInAlbumPopup() {
	document.getElementById('remove_photo_popup').style.display = "none";
}


// Delete photo in database modal
//show
function showDeletePhotoPopup(pID) {
	document.getElementById('delete_photo_popup').style.display = "block";
	var photo = document.getElementById('##' + pID);
	document.getElementById('delete_photo_id').value = pID;
}
// hide
function closeDeletePhotoPopup() {
	document.getElementById('delete_photo_popup').style.display = "none";
}



// Edit album modal
//show
function showEditAlbumPopup(aID) {
	document.getElementById('edit_album_popup').style.display = "block";
	var album = document.getElementById('edit_album_' + aID);
	document.getElementById('edit_album_id').value = aID;
}
//hide
function closeEditAlbumPopup() {
	document.getElementById('edit_album_popup').style.display = "none";
}


//Edit photo modal
//show
function showEditPhotoPopup(pID) {
	document.getElementById('edit_photo_popup').style.display = "block";
	var photo = document.getElementById('edit_photo_' + pID);
	document.getElementById('edit_photo_id').value = pID;
}
//hide
function closeEditPhotoPopup() {
	document.getElementById('edit_photo_popup').style.display = "none";
}