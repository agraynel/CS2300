// Sample function for modeling how to get back data from API
function getUserData(accessToken) {
    return $.ajax({
        url: 'https://api.spotify.com/v1/me',
        headers: {
           'Authorization': 'Bearer ' + accessToken
        }
    });
}

// you must complete this function for part 2
function getLibrary(accessToken) {
	return $.ajax({
        url: 'https://api.spotify.com/v1/me/tracks?limit=50',
        headers: {
           'Authorization': 'Bearer ' + accessToken
        }
    });

}

// you must complete this function for part 3
function search(accessToken, term) {
    console.log(term);
    return $.ajax({
        url: 'https://api.spotify.com/v1/search',
        data: {
            q: term,
            type: 'track'
        },
        headers: {
           'Authorization': 'Bearer ' + accessToken
        }
    });
}