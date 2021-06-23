<?php
class Pericope
{
	// Titre de la péricope
	public $titre = "Titre de la pericope" ;
	//usesr : thomasm_scribe pswd : 5hcbI$[S=@03


	// Liste des versets de la péricope
	public $versets = array();


	// Recoit un string $ref et détermine et popule $this->versets en conséquence
	public function analyser( string $ref ) {
		// Split les extraits (séparateur ";")
		$extraits = trim(explode(";", $reference));
		foreach ($extraits as $extrait) {
			// Split le début et la fin (séparateur "-")
			$extremites = trim(explode("-", $extrait)) ;
			// Distinguer universet VS. multi-versets mono-chapitre VS. multi-versets multi-chapitres 
			if (count($extremites)){

			} else {

				
			}
		}
		// Split le livre des chiffres (séparateur " ")

		// Split le verset du chapitre (séparateur ",")
	}
}
?>