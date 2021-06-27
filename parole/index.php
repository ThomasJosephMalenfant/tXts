<?php
require '../env.php';
require "BibleClass.php" ;

ob_start();

if ( $reference = filter_input(INPUT_POST, 'reference', FILTER_SANITIZE_STRING) ) { 
	$pericope = new Pericope($reference) ;
	var_dump($pericope->livre);
	var_dump($pericope->texte);

} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
 		<title>Choisir le texte</title>
	</head>
	<body>
		<form method="post" autocomplete="off">
			<label for="reference">Référence finale :</label><br>
			<input type="text" id="reference" name="reference"><br>
			<input type="submit" value="Envoyer">
		</form>
	</body>
	</html>
	<?php
}
ob_end_flush();
?>