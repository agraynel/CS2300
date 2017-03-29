/* Form validation

!!!!!!!!!!!PROJECT3 modified from validation.js in project 2　
  CREDITS: 
  https://www.tutorialspoint.com/javascript/javascript_form_validations.htm
  http://www.w3schools.com/js/js_validation.asp
   http://www.w3schools.com/js/tryit.asp?filename=tryjs_validation_number
*/

/**Strip_tag implement in javascript 
CREDIT: http://locutus.io/php/strings/strip_tags/
Modified to boolean function. Remove allowable tags.
Return false if it has tags.
Return true if it is the same after removing tags
*/


console.log("11");

//filter tags
function strip_tags (input) { //
  // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  var output = input.replace(commentsAndPhpTags, '');
  return (input == output);
}

// Check name valid, name should not be empty.
function validName(name) {
  //Photo name can have characters, spaces, numbers, underscores, dashes and name can't be all spaces
  var isValidLetter = /\S/.test(name) && /^[A-Za-z0-9\s-_]+$/.test(name);
  var isValidNameLength = (name !== '') && name.length <= 20;
  var isValidName = isValidLetter && isValidNameLength && strip_tags(name);
  return (isValidName);
}

//Check valid input introduction. 0 ~ 100 characters. can be empty
function validIntro(text) {
  //var notAllSpaces = /\S/.test(text); 
  var isValidLength = text.length <= 100;
  var isValidIntro = strip_tags(text) && isValidLength;
  return isValidIntro;
}

/** add album part*/

// validate the add album form
function validateAlbum() {
  var aName = validName(document.forms.add_form.album_name.value);
  var aIntro = validIntro(document.forms.add_form.album_intro.value);
  if (!aName) {
    showError("add_error_message", "Please enter a valid name.");
  }
  if (!aIntro) {
    showError("add_error_message", "Please enter a valid introduction between 0 ~ 100 characters!");
  }
  if (isValidAlbum) {
    showError("add_error_message", "Album added!");
  }
  return isValidAlbum;
}

/** ======================================================================================================
    ======================================================================================================
upload photos part*/

/* check it is a valid image file
   CREDITS:
   Extract the file name from the path:
    http://stackoverflow.com/questions/857618/javascript-how-to-extract-filename-from-a-file-input-control
*/
function validImage(file) {
  var startIndex = (file.indexOf('\\') >= 0 ? file.lastIndexOf('\\') : file.lastIndexOf('/'));
    var filename = file.substring(startIndex);
    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
        filename = filename.substring(1);
    }
  //console.log(filename);
  var isvalidImage = filename.endsWith(".jpg") || filename.endsWith(".png") || filename.endsWith(".bmp") || filename.endsWith(".gif") || filename.endsWith(".jpge");
  return isvalidImage;
}

// validate the upload photo form
function validatePhoto() {
  var pName = validName(document.forms.upload_photo.photo_name.value);
  // CREDITS http://stackoverflow.com/questions/1804745/get-the-filename-of-a-fileupload-in-a-document-through-javascript
  var file = document.getElementById("photo_file_upload").value;
  var pImage = validImage(file);
  //console.log(file);
  var pIntro = validIntro(document.forms.upload_photo.photo_intro.value);
  if (!pName) {
    showError(add_error_message1, "Please enter a valid name.");
  }
  if (!pIntro) {
    showError(add_error_message1, "Please enter a valid introduction between 0 ~ 100 characters!");
  }
  if (!pImage) {
    showError(add_error_message1, "Please upload a valid image!");
  }
  var isValidPhoto = pName && pImage && pIntro;
  return isValidPhoto;
}

//when file path has already existed, show error! 
function file_exist_error() {
  showError("add_error_message1", "The file path already exists!");
}

//no mistakes and tell the user the photo has been upload!
function photo_upload_text() {
  showError("add_error_message1", "Photo uploaded successfully!");
}

/** ======================================================================================================
    ======================================================================================================
log in part*/

/*
  Check valid input password. 0 ~ 255 characters. cannot be empty
*/
function validPassword(text) {
  //var notAllSpaces = /\S/.test(text); 
  var isValidLength = text.length <= 255 && text.length > 0;
  var isValidPassword = strip_tags(text) && isValidLength;
  return isValidPassword;
}

// validate the upload photo form
function validLogin() {
  var uName = validName(document.forms.login_form.username.value);
  if (!uName) {
    showError("login_error_message", "Please enter a valid name.");
  }
  var uPass = validPassword(document.forms.login_form.password.value);
  if (!uPass) {
    showError("login_error_message", "Please enter a valid password");
  }
  var isValidLogin = uName && uPass;
  if (isValidLogin) {
    showError("login_error_message", "Log in successfully");
  }
  console.log(isValidLogin);
  return isValidLogin;
}

//EDIT PART
// validate edit photo function
function validEditPhoto() {
  var pName = validName(document.forms.edit_photo_form.edit_photo_name.value);
  var pIntro = validIntro(document.forms.edit_photo_form.edit_photo_intro.value);
  console.log(pName);
  console.log(pIntro);
  if (!pName) {
    showError("edit_photo_error", "Please enter a valid name.");
  }
  if (!pIntro) {
    showError("edit_photo_error", "Please enter a valid introduction between 0 ~ 100 characters!");
  }
  var isValidPhoto = pName && pIntro;
  if (isValidPhoto) {
    showError("edit_photo_error", "Photo Edited!");
  }
  return isValidPhoto;
}

//validate edit album function
function validEditAlbum() {
  var aName = validName(document.forms.edit_album_form.edit_album_name.value);
  var aIntro = validIntro(document.forms.edit_album_form.edit_album_intro.value);
  if (!aName) {
    showError("edit_album_error", "Please enter a valid name.");
  }
  if (!aIntro) {
    showError("edit_album_error", "Please enter a valid introduction between 0 ~ 100 characters!");
  }
  var isValidAlbum = aName && aIntro;
  if (isValidAlbum) {
    showError("edit_album_error", "Album Edited!");
  }
  return isValidAlbum;
}

// Show error message in field id
function showError(id, errorMessage) { 
   document.getElementById(id).innerHTML = errorMessage;
}

