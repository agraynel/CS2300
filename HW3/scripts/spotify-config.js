// Client ID from https://developer.spotify.com/my-applications/#!/applications
var clientID = "81687044ca88427991752864f1deb660";

// redirect URL from https://developer.spotify.com/my-applications/#!/applications
var baseRedirect = "https://info2300.coecis.cornell.edu/users/yc2329sp17/www/HW3/"
var redirectURI = baseRedirect + "callback.html";

// scope variables for requesting different levels of access to the API
// you will need to modify this based on the description of the problem
// https://developer.spotify.com/web-api/authorization-guide/#scopes
var scopes = 'user-read-email user-library-read';