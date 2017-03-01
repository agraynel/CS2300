/**
	
	This file was used to grab pokemon from the API.
	It has nothing to do with this homework assignment.
	Do not import, edit, or use this file.
	
**/

// pull 20 pokemon from the API
function pullPokemon(){
	//pokemon variable is stored in pokemon.json
	return pokemon;
}

// search for pokemon name
function searchPokemon(name){
	// if the pokemon is not in the database, return error
	if (!pokemon[name]){
		return "Pokemon not found";
	}
	return pokemon[name];
}

// returns sprite url of pokemon if it exists
function pokemonImage(name){
	// if the pokemon is not in the database, return error
	if (!pokemon[name]) {
		return "Pokemon not found";
	}
	return pokemon[name]['sprites']['front_default'];
}

// get pokemon moves if pokemon exists
function pokemonMoves(name){
	// if the pokemon is not in the database, return error
	if (!pokemon[name]) {
		return "Pokemon not found";
	}
	var moves = pokemon[name]['moves'];
	var moveNames = [];
	for (var i = 0; i < moves.length; i++) {
		moveNames.push(moves[i]['move']['name']);
	}
	return moveNames;
}

// filter pokemon with the move 'move'
function getPokemonWithMove(move){
	// pokemon with the move
	var hasMove = {};
	// get the pokemon (the keys)
	var poke = Object.keys(pokemon);
	// check each pokemon for the move
	for (var i = 0; i < poke.length; i++) {
		var moves = pokemonMoves(poke[i]);
		// if this pokemon has the move, add it to the return list
		if (moves.indexOf(move) != -1) {
			hasMove[poke[i]] = pokemon[poke[i]];
		}
	}
	return hasMove;
}