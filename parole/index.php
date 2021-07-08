<?php
require '../env.php';
require "BibleClass.php" ;

ob_start();

if ( $references = filter_input(INPUT_POST, 'reference', FILTER_SANITIZE_STRING) ) { 
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link rel="stylesheet" href="./styles.css">
 		<title><?php print $reference ; ?></title>
	</head>
	<body>
	<?php
	foreach (explode("|",$references) as $reference) {
		$pericope = new Pericope(trim($reference)) ;
		if (! $pericope->erreurs ) {
			?>
				<h1 class="titre1"><?php print $pericope->titre ; ?></h1>
				<h2 class="titre3"><?php print $reference ; ?></h1>
				<?php
					$no_chapitre = 0 ;
					$no_verset = 0 ;
					foreach ($pericope->versets as $verset) {
						$old_chap = $no_chapitre ;
						$no_chapitre = $verset["chapitre"] ;
						$no_verset =  $verset["verset"] ;
						if ($no_chapitre > $old_chap) {
							$verse_number = $no_chapitre . ", " . $no_verset ;
						} else {
							$verse_number = $no_verset ;
						}
						print '<p><span class = "verse_number" >' . $verse_number . " </span>" . $verset["texte"] . "</p>";
					}
		} else {
			?>
			<h1 class="titre1"> Erreurs </h1>
			<?php
			foreach ($pericope->erreurs as $erreur) {
				print '<p>' . $erreur . '</p>' ;
			}
		}
	}
	?>
	</body>
	</html>
	<?php
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
		<link rel="stylesheet" href="./styles.css">
 		<title>Choisir le texte</title>
	</head>
	<body>
		<div class="centrement">
			<div>
				<form method="post" autocomplete="off">
					<label for="reference">Référence :</label><br>
					<input type="text" id="reference" name="reference"><br>
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