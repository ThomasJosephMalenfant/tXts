<?php
require '../env.php';
require "../parole/BibleClass.php" ;

ob_start();
// NEXT : Structure triple :
//			if (isset(schema)) { 
//			} elseif (isset(rituel)) {
//			} else { choix de rituel }

if ( filter_input(INPUT_POST, 'schema', FILTER_SANITIZE_STRING) ) { 
	// Output du rituel
} elseif (filter_input(INPUT_POST, 'rituel', FILTER_SANITIZE_STRING)){
	// Output questionnaire schema
} else {
	// Output choix du rituel
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="180x180" href="../icones/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../icones/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../icones/favicon-16x16.png">
		<link rel="stylesheet" href="./styles.css">
 		<title>Choisir le texte</title>
	</head>
	<body>
		<div class="centrement">
			<div>
				<form method="post" autocomplete="off">
					<label for="reference">Référence :</label><br>
					<textarea id="reference" name="reference" placeholder="Par exemple : Gn 2, 2-4.7 | Mt 2-4 ..." row="2" cols="50"></textarea><br>
					<label for="affichage_versets">Versets affichés :</label>
					<input id="affichage_versets" type="checkbox" name="affichage_versets">
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</body>
	</html>
	<?php
}
ob_end_flush();
?>