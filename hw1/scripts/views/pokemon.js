/**

	This is the declaration of a Pokemon class
	It is designed to output each pokemon within a cell on the page
	You will be required to use the constructor and the render function
	from this class in questions 4 and 5.

	You are not to touch this file.
**/


class Pokemon {
	// class constructor, keep renderer as "full" as the compressed view
	// was not implmeneted for this homework
	constructor(name, weight, sprites, stats, types, renderer) {
		this.name = name;
		this.weight = weight;
		this.sprites = sprites;
		this.stats = stats;
		this.types = types;
		this.renderer = renderer;
	}

	// call this render function to return the html output
	get render() {
		return this.renderFull();
	}

	// returns the html to be rendered on the page
	// called from the render getter function above
	renderFull() {
		var stats = this.renderStats();
		var types = this.renderTypes();
		return '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">\
					<div class="cell">\
						<img src="'+ this.sprites.front_shiny +'"/> \
						<div class="title">'+this.name+'</div> \
						<div class="weight"> Weight: '+this.weight+'</div> \
						<div class="stats"> Stats '+stats+'</div> \
						<div class="types"> Types '+types+'</div> \
					</div>\
				</div>';
	}

	// Builds the list items of types for each pokemon
	renderTypes() {
		var stringBuilder = "";
		this.types.forEach(function(item) {
			stringBuilder+='<div class="item">'+item.type.name+'</div>';
		});
		return stringBuilder;
	}

	// Builds the list items of stats for each pokemon
	renderStats() {
		var stringBuilder = "";
		this.stats.forEach(function(item) {
			stringBuilder+='<div class="item">'+item.stat.name+': '+'<div class="int">'+item.base_stat+'</div>'+'</div>';
		});
		return stringBuilder;
	}
}