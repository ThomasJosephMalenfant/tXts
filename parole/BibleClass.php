<?php
require '../connecteur.php' ;

class Pericope
{
	// Titre de la péricope
	public $titre = "Titre de la pericope" ;
	public $corpus = 1 ; // 1 = Bible
	public $version = 1 ; // 1 = aelf
	public $livre ; // 1 = Gn, 
	public $versets = array(); // liste des id sur "tXts_db.textes"
	public $texte = "";
	
	// Recoit un string $ref et détermine et popule $this->versets en conséquence
	public function __construct( string $ref ) {
		// Trouver le livre
		$ref_livre = trim( explode(" ",$ref)[0] ) ;

		$connection = new ConnecteurDB(false) ;

		if ($connection->online) {
			$query = "SELECT `id`, `name`, `titre` FROM `livres` WHERE `abbr`='".$ref_livre."' AND `versions_id`=1 LIMIT 1" ;
			$this->livre = $connection->queter($query, array("id","titre")) ;
		} else {
			$this->livre = "Erreur :".$connection->erreur ;
		}
	}
}
?>