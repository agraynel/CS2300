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

console.log("hi");

function strip_tags (input) { // eslint-disable-line camelcase
  // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  var output = input.replace(commentsAndPhpTags, '');
  return (input == output);
}

/** add album part*/
// Check name valid, name should not be empty.
function validName(name) {
  //Photo name can have characters, spaces, numbers, underscores, dashes and name can't be all spaces
  var isValidLetter = /\S/.test(name) && /^[A-Za-z0-9\s-_]+$/.test(name);
  var isValidNameLength = (name !== '') && name.length <= 20;
  var isValidName = isValidLetter && isValidNameLength && strip_tags(name);
  if (!isValidName) {
    showError("Please enter a valid name.");
  }
  return (isValidName);
}

/*
  Check valid input introduction. 0 ~ 100 characters. can be empty
*/
function validIntro(text) {
  //var notAllSpaces = /\S/.test(text); 
  var isValidLength = text.length <= 100;
  var isValidIntro = strip_tags(text) && isValidLength;
  if (!strip_tags(text)) {
    showError("No injection!" );
  }
  if (!isValidLength) {
    showError("No more than 100 characters!" );
  }
  return isValidIntro;
}

// validate the add album form
function validateAlbum() {
  var aName = validName(document.forms.add_form.album_name.value);
  var aIntro = validIntro(document.forms.add_form.album_intro.value);
  var isValidAlbum = aName && aIntro;
  if (isValidAlbum) {
    showError("Album added!");
  }
  return isValidAlbum;
}

// Show error message
function showError(errorMessage) { 
   document.getElementById("add_error_message").innerHTML = errorMessage;
}


/** ======================================================================================================
    ======================================================================================================
upload photos part*/

// Check name valid, name should not be empty.
function validName1(name) {
  //Photo name can have characters, spaces, numbers, underscores, dashes and name can't be all spaces
  var isValidLetter = /\S/.test(name) && /^[A-Za-z0-9\s-_]+$/.test(name);
  var isValidNameLength = (name !== '') && name.length <= 20;
  var isValidName = isValidLetter && isValidNameLength && strip_tags(name);
  if (!isValidName) {
    showError1("Please enter a valid name.");
  }
  return (isValidName);
}

/*
  Check valid input introduction. 0 ~ 100 characters. can be empty
*/
function validIntro1(text) {
  //var notAllSpaces = /\S/.test(text); 
  var isValidLength = text.length <= 100;
  var isValidIntro = strip_tags(text) && isValidLength;
  if (!strip_tags(text)) {
    showError1("No injection!" );
  }
  if (!isValidLength) {
    showError1("No more than 100 characters!" );
  }
  return isValidIntro;
}

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
  console.log(filename);
  var isvalidImage = filename.endsWith(".jpg") || filename.endsWith(".png") || filename.endsWith(".bmp") || filename.endsWith(".gif") || filename.endsWith(".jpge");
  if (!isvalidImage) {
    showError1("Please upload a valid image!");
    return false;
  }
  return true;
}

// validate the upload photo form
function validatePhoto() {
  var pName = validName1(document.forms.upload_photo.photo_name.value);
  // CREDITS http://stackoverflow.com/questions/1804745/get-the-filename-of-a-fileupload-in-a-document-through-javascript
  var file = document.getElementById("photo_file_upload").value;
  var pImage = validImage(file);
  console.log(file);
  var pIntro = validIntro1(document.forms.upload_photo.photo_intro.value);
  var isValidPhoto = pName && pImage && pIntro;
  return isValidPhoto;
}

//when file path has already existed, show error! 
function file_exist_error() {
  showError1("The file path already exists!");
}

//no mistakes and tell the user the photo has been upload!
function photo_upload_text() {
  showError1("Photo uploaded successfully!");
}

// Show error message
function showError1(errorMessage) { 
   document.getElementById("add_error_message1").innerHTML = errorMessage;
}

