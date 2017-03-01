/* Form validation
  CREDITS: 
  https://www.tutorialspoint.com/javascript/javascript_form_validations.htm
  http://www.w3schools.com/js/js_validation.asp
   http://www.w3schools.com/js/tryit.asp?filename=tryjs_validation_number
*/

// Check name valid, name should not be empty.

function validName(name) {
  //Name can have characters, spaces, numbers, underscores, dashes and name can't be all spaces
  var isValidLetter = /\S/.test(name) && /^[A-Za-z0-9\s-_]+$/.test(name);
  var isValidNameLength = (name !== '') && name.length <= 20;
  var isValidName = isValidLetter && isValidNameLength;
  if (!isValidName) {
    showError("inputName", "Please enter a valid name.");
  }
  return (isValidName);
}

//check int CREDITS: http://stackoverflow.com/questions/14636536/how-to-check-if-a-variable-is-an-integer-in-javascript
function isInt(value) {
  return (!isNaN(value)) && parseInt(Number(value)) == value && 
         (!isNaN(parseInt(value, 10)));
}

//check number valid. interger from 30 to 500.
function validNumber(field_id, number) {
  var isValidNumber = isInt(number) && number >= 30 && number <= 500;
  //updateFieldBorder(field_id, isValidNumber);
  if (!isValidNumber) {
    showError(field_id, "Please enter a valid integer from 30 to 500.");
  }
  return (isValidNumber);
}

/* check valid image url
   CREDITS:
   http://stackoverflow.com/questions/9714525/javascript-image-url-verify
*/
function validImage(imageURL) {
    var isValidImageURL = imageURL.match(/\.(jpeg|jpg|gif|png|bmp)$/) !== null;
    if (!isValidImageURL) {
      showError("inputImage", "Please enter a valid image url!");
    }
    return isValidImageURL;
}

/*
  Check valid input perks. not all spaces. 3 ~ 1000 characters.
*/
function validPerk(text) {
  var notAllSpaces = /\S/.test(text); 
  var isValidperkLength = text.length <= 120 && text.length >= 3;
  var isValidPerk = notAllSpaces && isValidperkLength;
  if (!isValidPerk) {
    showError("inputPerk", "The perk is between 3 and 120 characters and not all spaces." );
  }
  return isValidPerk;
}

// validate the form
function validate() {
  var chName = validName(document.forms.add_form.inputName.value);
  var chHunger = validNumber("inputHunger", document.forms.add_form.inputHunger.value);
  var chSanity = validNumber("inputSanity", document.forms.add_form.inputSanity.value);
  var chHealth = validNumber("inputHealth", document.forms.add_form.inputHealth.value);
  var chImage = validImage(document.forms.add_form.inputImage.value);
  var chPerk = validPerk(document.forms.add_form.inputPerk.value);
  var isValidForm = chName && chHunger && chSanity && chHealth && chImage && chPerk;

  return isValidForm;
}



// Show error message
function showError(id, errorMessage) { 
   document.getElementById("add_error_message").innerHTML = (errorMessage == "") ? "Successful added!" : errorMessage;
}