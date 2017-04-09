/**
	Render template for song
	Do not touch or modify this file.
	Will be used in parts 2 and 3
**/

class Song {
	constructor(count, name, artist, album, preview) {
		this.count = count;
		this.name = name;
		this.artist = artist;
		this.ablum = album;
		this.preview = preview;
	}

	// call this render function to return the html output
	get render() {
		return this.renderFull();
	}

	// returns the html to be rendered on the page
	// called from the render getter function above
	renderFull() {
		return '<tr class="song" data-href="'+ this.preview + '">\
					<th scope="row">'+ this.count+'</th>\
					<td class="name">'+ this.name +'</td>\
					<td class="artist">'+ this.artist +'</td>\
          			<td class="album">'+ this.ablum +'</td>\
        		</tr>';
	}
}