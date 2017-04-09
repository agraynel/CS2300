<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Netlingo translator</title>
	</head>
	<body>
		<?php
			/*
			Write a PHP script to translate from net lingo to English.
			For example 	'brb' ? 'be right back'
					'cul8r' ? 'see you later'
					'imho' ? 'in my humble opinion'
					'im' ? 'I'm'
			Note that "time" should not translate to "tI'me"
			*/
			
			//References
			//http://www.netlingo.com/acronyms.php
			//http://www.phpliveregex.com/
			//http://www.phpro.org/tutorials/Introduction-to-PHP-Regex.html

			if ( isset( $_POST[ 'input' ] ) ) {
				//Next week we'll stop using this insecure method of reading the POST data
				$input = $_POST[ 'input' ];
				
				//Display the text that was input for translation
				print( "<p>Input: $input</p>" );
				
				//Modify the code below to translate
				$result = $input;

				$lingo_terms = array(
					'brb' => 'be right back',
					'cul8r' => 'see you later',
					'imho' => 'in my humble opinion',
					'im' => "I'm",
					'aak' => 'asleep at keyboard',
					'aatk' => 'always at the keyboard',
					'afk' => 'away from keyboard',
					'aob' => 'abuse of bandwidth',
					'pebcac' => 'problem exists between chair and computer',
				);
				foreach( $lingo_terms as $index => $value ) {
					$search = "/\b$index\b/i";
					$result = preg_replace( $search, $value, $result );
				}

				print( "<p>Translation: $result </p><br>" );
			}
		?>
		<form method="post">
			<p>What do you need translated from Netlingo?</p>
			<textarea rows="6" cols="60" name="input"></textarea>
			<input type="submit" value="Click to submit" />
		</form>

	</body>
</html>
