<?php
class Pericope
{
	// Titre de la péricope
	public $titre = "Titre de la pericope" ;
	public $corpus = 1 ; // 1 = Bible
	public $version = 1 ; // 1 = aelf
	public $livre = 0 ; // 1 = Gn, 
	public $versets = array(); // liste des id sur "tXts_db.textes"
	public $texte = "";

	//usesr : thomasm_scribe pswd : 5hcbI$[S=@03
	//user_read-only sur vm : tXts_db_ro pwd : OOxqLBO|VK!~
	//user write sur vm : tXts_db_wr pwd : o}qhk(vgdTPx



	// Recoit un string $ref et détermine et popule $this->versets en conséquence
	public function analyser( string $ref ) {
		// Trouver le livre


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
	public function probe() {
		return $this->versets ;
	}
}
?>