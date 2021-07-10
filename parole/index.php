<?php
require_once '../env.php';
require_once "../commun/classes/BibleClass.php";

ob_start();

if ( $references = filter_input(INPUT_POST, 'reference', FILTER_SANITIZE_STRING) ) { 
	$affichage_versets = isset($_POST['affichage_versets']) ? TRUE : FALSE ;	
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="180x180" href="../commun/icones/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../commun/icones/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../commun/icones/favicon-16x16.png">
		<link rel="stylesheet" href="./parole.css">
		<script src="../commun/commun.js" defer></script>
		<title><?php print $reference ; ?></title>
	</head>
	<body>
	<?php
	print '<div id="pericopes">' ;
	foreach (explode("|",$references) as $reference) {
		$opt_pericope = array(
			"corpus" => 1,
			"version" => 1,
			"ref" => trim($reference)
		) ;
		$pericope = new Pericope($opt_pericope) ;
		if (! $pericope->erreurs ) {
			?>
				<h1 class="titre1"><?php print $pericope->titre ; ?></h1>
				<h2 class="titre3"><?php print $reference ; ?></h1>
				<?php
					$no_chapitre = 0 ;
					$no_verset = 0 ;
					print '</br><div class="editeur" contentEditable="true"><pre>' ;
					foreach ($pericope->versets as $verset) {
						$old_chap = $no_chapitre ;
						$no_chapitre = $verset["chapitre"] ;
						$no_verset =  $verset["verset"] ;
						if ($no_chapitre > $old_chap) {
							$verse_number = $no_chapitre . ", " . $no_verset ;
						} else { $verse_number = $no_verset ; }
						if ($affichage_versets){
							print '<p class="verset_pericope" ><span class = "verse_number" >' . $verse_number . " </span>" . $verset["texte"] . "</p>";
						} else {
							print '<p class="verset_pericope" >' . $verset["texte"] . "</p>";
						}
					}
					print '</pre></div>' ;
		} else {
			?>
			<h1 class="titre1"> Erreurs </h1>
			<?php
			foreach ($pericope->erreurs as $erreur) {
				print '<p>' . $erreur . '</p>' ;
			}
		}
	}
	print '</div>';
	?>
	<a href="">Nouvelle requête</a>
	</body>
	</html>
	<?php
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="180x180" href="../commun/icones/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../commun/icones/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../commun/icones/favicon-16x16.png">
		<link rel="stylesheet" href="./parole.css">
 		<title>Choisir le texte</title>
	</head>
	<body>
		<div class="centrement">
			<div>
				<form method="post" autocomplete="off">
					<label for="reference">Référence :</label><br>
					<textarea id="reference" name="reference" placeholder="Par exemple : Gn 2, 2-4.7 | Mt 2-4 ..." row="1" cols="50"></textarea><br>
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