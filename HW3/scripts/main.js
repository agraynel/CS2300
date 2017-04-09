//CREDIT: http://jsfiddle.net/JMPerez/62wafrm7/

$(document).ready(function() {
    // login function to kick off the authorization
    function login(callback) {
    	// builds the login URL for user after clicking login button
        function buildLoginUrl(clientID, redirectURI, scopes) {
            // variables from from spotify-config.js
            // make sure to append them to this URL string
            // you may need to encode the values. IE, wrap the variable
            // in a url encorder function
            console.log(clientID);
            console.log(redirectURI);
            console.log(scopes);
            /**
            return 'https://accounts.spotify.com/authorize?client_id=' + clientID +
              '&redirect_uri=' + redirectURI +
              '&scope=' + scopes +
              '&response_type=token';
            */
            return 'https://accounts.spotify.com/authorize?client_id=' + clientID +
              '&redirect_uri=' + encodeURIComponent(redirectURI) +
              '&scope=' + encodeURIComponent(scopes) +
              '&response_type=token';
        }
        /**
            return 'https://accounts.spotify.com/authorize' + 
            '?response_type=code' +
            '&client_id=' + clientID +
            (scopes ? '&scope=' + encodeURIComponent(scopes) : '') +
            '&redirect_uri=' + encodeURIComponent(redirectURI);
        }
        }
    	*/

    	// the callback window sends the hashed accessToken back here
        // leave this alone
        window.addEventListener("message", function(event) {
            var hash = JSON.parse(event.data);
            if (hash.type == 'access_token') {
                // execute the callback function, passing the accesstoken in
                callback(hash.access_token);
            }
        }, false);
        
        // window sizes for login, leave this alone
        var width = 450,
            height = 730,
            left = (screen.width / 2) - (width / 2),
            top = (screen.height / 2) - (height / 2);

        // open window with custom built URL
        // You need to change the first parameter to be 
        // the the fully build custom URL.
        var w = window.open(buildLoginUrl(clientID, redirectURI, scopes),'Spotify','menubar=no,location=no,resizable=no,scrollbars=no,status=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);
        
    }
    
    // event listeners
    $("#login").click(function() {
        // call the login function, we'll get back the accessToken from it
        loginButton = document.getElementById('login');
        login(function(accessToken) {
            // callback function from login, gives us the accessToken

            //** START PART 1 **//

            // Use the getUserData function in api-calls.js to log the user's basic data
            // in the JS console. Remember, this function returns a reference to an ajax call.
            // Also remove the login button if you do in fact get a response from the call.

            //-- YOUR CODE HERE FOR PART 1 (Access user data) --//

            getUserData(accessToken).then(function(response) {
                loginButton.style.display = 'none';
                console.log(response);
            });
          
            //-- END CODE HERE FOR PART 1 (Access user data) --//

            //** END PART 1 **//

            //** START PART 2 HERE **//

            // Part 2 involves getting 50 tracks from the users saved tracks, displaying them
            // in the table, and then streaming the preview audio using the HTML 5 media
            // player on the page on double click.

            // First, make sure you have the right scopes to access a users saved tracks
            // you can add this to the scopes array in your config.js file.

            // Second, hit the right API endpoint that gets a users tracks. This means completing
            // the getLibrary function in api-calls.js. Call this function

            // Third, make sure you pull 50 from the API within the function.

            // Fourth, output the tracks from the JSON object into HTML using the Song object in song.js
                // Be sure to print to the DOM to take a look at the object first.
                // Once you create a song object, calling .render on it will output the data as an HTML string
                // This is very, very similar to Homework 1.
                // The table must increment from 1 - 50, you will manually define the index for each song object
                // and make sure it gets outputted on the table.

            // Fifth, each song should play the preview on double click of the song row.
                // Use jQuery, and inspect the DOM to get the audio track out of the DOM
                // change the source of the media player, then play the song by invoking the media player in JS
                // You also need to change the wrapper around the media player that holds the name and artist for the song
                // Again, use jQuery to do this.

            //-- YOUR CODE HERE FOR PART 2 (50 tracks + audio playback) --//

            //get songs and populate them
            getLibrary(accessToken).then(function(response) {
                var SongArray = response.items;
                console.log(SongArray);

                //incrementing the index from 1 to 50 as count
                var i = 0;

                SongArray.forEach(function(item) {
                    // making a new instance of the song object while looping over the song objects from the array.
                    var track = item.track;

                    //get an array of artists
                    var artistsArray = track.artists;
                    var artists = new Array();
                        artistsArray.forEach(function(item) {
                            artists.push(item.name);
                        });
                    //create song object
                    var song = new Song(++i, track.name, artists, track.album.name, track.preview_url, "full");

                    // jquery to append the html to the .row class, need to call render on pokemon object to get html
                    $("tbody").append(song.render);
                });

                //change the mediaplayer when double click a song row!
                $(".song").dblclick(function() {
                    //change preview src
                    var thispreview = $(this).attr('data-href');
                    var audioplayer = $('.player');
                    audioplayer.attr('src', thispreview).attr('autoload','auto').attr('autoplay', true);
                    //console.log(audioplayer);

                    //change text
                    var thisname = $(this)[0].cells[1].innerText;
                    var thisartist = $(this)[0].cells[2].innerText;
                    console.log(thisartist);
                    $('.artistDisplay').text("- " + thisartist); 
                    $('.titleDisplay').text(thisname); 
                });
            });            

            //-- END CODE HERE FOR PART 2 (50 tracks + audio playback) --//

            //** END PART 2 **//

            //** START PART 3 HERE **//

            // Part 3 involves searching songs across all of spotify. This will run every time
            // a new key is pressed in the search field.

            $(".form-control").keyup(function() {
                // First, grab the value from the field
            
                // Second, clear the current table body
            
                // Third, write the search function from the api-call.js, dont forget to pass in the access token
                // its ok to only show 20 results at a time. Again this returns an ajax call
                // look at response and make sure you can view the object on each keystroke
                // The endpoint you want to hit is v1/search and the type is track.
            
                // Fourth, output the JSON object into HTML using the Song object in song.js
                    // Be sure to print to the DOM to take a look at the object first.
                    // Once you create a song object, calling .render on it will output it to HTML
                    // This is very, very similar to Homework 1.
                    // The table must increment from 1 - 20, you will manually create the index for each song object
                    // and make sure it gets outputted on the table.
            
                // Fifth, each song should play the preview on double click of the song row.
                    // Use jQuery, and inspect the DOM to get the audio track out of the DOM
                    // change the source of the media player, then play the song by invoking the media player in JS
                    // You also need to change the wrapper around the media player that holds the name and artist for the song
                    // Again, use jQuery to do this.

                //-- YOUR CODE HERE FOR PART 3 (Search) --//

                var searchInput = $(".form-control").val().toLowerCase();
                console.log(searchInput);
                $("tbody").empty();  
                if (searchInput == "") {
                    $("tbody").empty(); 
                } else {
                //http://stackoverflow.com/questions/3794919/replace-all-spaces-in-a-string-with
                //var replaced = searchInput.split(' ').join('%20');
                //searchInput = encodeURIComponent(searchInput);
                //console.log(searchInput);
                search(accessToken, searchInput).then(function(response) {
                    console.log(response);
                    var SongArray = response.tracks.items;
                    console.log(SongArray);

                    //incrementing the index from 1 to 50 as count
                    var i = 0;

                    SongArray.forEach(function(item) {
                        // making a new instance of the song object while looping over the song objects from the array.   
                        //get an array of artists
                        var artistsArray = item.artists;
                        var artists = new Array();
                            artistsArray.forEach(function(item) {
                                artists.push(item.name);
                            });
                        //create song object
                        var song = new Song(++i, item.name, artists, item.album.name, item.preview_url, "full");

                        // jquery to append the html to the .row class, need to call render on pokemon object to get html
                        $("tbody").append(song.render);
                    });

                    //change the mediaplayer when double click a song row!
                    $(".song").dblclick(function() {
                        //change preview src
                        var thispreview = $(this).attr('data-href');
                        var audioplayer = $('.player');
                        audioplayer.attr('src', thispreview).attr('autoload','auto').attr('autoplay', true);
                        //console.log(audioplayer);

                        //change text
                        var thisname = $(this)[0].cells[1].innerText;
                        var thisartist = $(this)[0].cells[2].innerText;
                        console.log(thisartist);
                        $('.artistDisplay').text("- " + thisartist); 
                        $('.titleDisplay').text(thisname); 
                    });
                });
                }
            
            });
            //** END PART 3 **//
		});
    });
});