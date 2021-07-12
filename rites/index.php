<?php
require_once '../env.php';
require_once "../commun/classes/BibleClass.php" ;

$rituels_disponibles = array(
	"Parole" => array(
		"Nom" => "Parole",
		"Description" => "Célébration de la parole du Chemin néo-catéchuménal." ,
		"Path" => "chemin_parole.php"
	),
	"Funérailles" => array(
		"Nom" => "Funérailles",
		"Description" => "Célébration des funérailles chrétiennes (rituel ANNÉE) ",
		"Path" => "funerailles.php"
	),
	"Baptême" => array(
		"Nom" => "Baptême",
		"Description" => "Célébration du baptême (rituel ANNÉE) ",
		"Path" => "bapteme.php"
	)
) ;

ob_start();

if ( filter_input(INPUT_POST, 'schema', FILTER_SANITIZE_STRING) ) { 
	$choix = $rituels_disponibles[filter_input(INPUT_POST, 'rituel', FILTER_SANITIZE_STRING)] ;
	require_once $choix["Path"] ;
	$rituel = new Rituel ;

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
		<link rel="stylesheet" href="./rites.css">
		<script src="../commun/commun.js" defer></script>
		<script src="./rites.js" defer></script>
		<title><?php print $choix["Nom"] ; ?></title>
	</head>
	<body>
		<?php print $rituel->generer() ; ?>
	</body>
	</html>
	<?php
} elseif ($choix = $rituels_disponibles[filter_input(INPUT_POST, 'rituel', FILTER_SANITIZE_STRING)]){

	require_once $choix["Path"] ;
	$rituel = new Rituel ;

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
		<link rel="stylesheet" href="./rites.css">
		<script src="./rites.js" defer></script>
		<title><?php print $choix["Nom"] ; ?></title>
	</head>
	<body onload="ajouterSection()">
		<?php print $rituel->questionnaire() ; ?>
	</body>
	</html>
	<?php
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
		<link rel="stylesheet" href="./rites.css">
 		<title>Rituels</title>
	</head>
	<body>
		<div class="centrement">
			<div>
				<form method="post" autocomplete="off">
					<label for="rituel">Rituel :</label><br>
					<select id="rituel" name="rituel">
						<?php
						foreach ($rituels_disponibles as $rituel => $details) {
							print '<option value="' . $rituel . '">' . $rituel . '</option>' ;
						}
						?>
					</select>
					<br>
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