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
	public $erreurs = array();
	
	// Recoit un string $ref et détermine et popule $this->versets en conséquence
	public function __construct( string $ref ) {
		// Trouver le livre
		$ref_livre = trim( explode(" ",$ref)[0] ) ;

		$connection = new ConnecteurDB(false) ;

		if ($connection->online) {
			$query = "SELECT `id`, `name`, `titre` FROM `livres` WHERE `abbr`='".$ref_livre."' AND `versions_id`=1 LIMIT 1" ;
			$result_livre = $connection->queter($query, array("id","titre")) ; 
			$this->livre = $result_livre[0]["id"] ;
			$this->titre = $result_livre[0]["titre"];
		} else { $this->erreurs[] = "Erreur :".$connection->erreur ; }

		// Trouver verset départ
		$ref_sans_livre = substr(strstr($ref," "),1);
		$array_sans_livre = explode(".",$ref_sans_livre);
		foreach ($array_sans_livre as $chunk) {
			$extremites = explode("-",$chunk);
			$depart_total = explode(",",$extremites[0]);
			$depart_chapitre = trim($depart_total[0]);
			$depart_verset = trim($depart_total[1]);
			if ($connection->online) {
				$query = "SELECT * FROM `textes` WHERE `livres_id`='".$this->livre."' AND `chapitre`='".$depart_chapitre."' AND `verset`='".$depart_verset."' LIMIT 1";
				$result_verset_depart = $connection->queter($query,array("id","texte")) ;
				$this->texte = "Verset départ ID : " . $result_verset_depart[0]["id"] . " | Texte : " . $result_verset_depart[0]["texte"] ;
			} else { $this->erreurs[] = "Erreur :".$connection->erreur ; }
		}
	}
}
?>