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
		$depart_chapitre = "" ;
		$depart_verset = "" ;
		$fin_chapitre = "" ; 
		$fin_verset = "" ;

		foreach ($array_sans_livre as $chunk) {
			$pre_extremites = explode("-",$chunk);
			$extremites = array();

			// TODO : prévoir mécanisme pour référence de plein chapitre / chapitre_S_
			
			if (strpos($pre_extremites[0], ",")) {
				$depart_chapitre = trim(explode(",", $pre_extremites[0])[0]);
				$depart_verset = trim(explode(",", $pre_extremites[0])[1]);
			} else {
				$depart_verset = $pre_extremites[0] ;
			}

			if (isset($pre_extremites[1])) {
				if ( strpos( $pre_extremites[1], ",")) {
					$fin_chapitre = trim(explode(",", $pre_extremites[1])[0]) ;
					$fin_verset = trim(explode(",", $pre_extremites[1])[1]);	
				} else {
					$fin_chapitre = $depart_chapitre ;
					$fin_verset = trim($pre_extremites[1]) ;
				}
			} else { // Pas de tiret donc mono-verset donc $fin = $depart 
				$fin_chapitre = $depart_chapitre ;
				$fin_verset = $depart_verset ;
			}

			$extremites[0] = array("chapitre"=>$depart_chapitre, "verset"=>$depart_verset);
			$extremites[1] = array("chapitre"=>$fin_chapitre, "verset"=>$fin_verset);

			if ($connection->online) {
				for ($i=0; $i < 2 ; $i++) { 
					$query = "SELECT * FROM `textes` WHERE `livres_id`='".$this->livre."' AND `chapitre`='" . $extremites[$i]["chapitre"] . "' AND `verset`='". $extremites[$i]["verset"] . "' LIMIT 1";
					$extremites[$i]["id"] = $connection->queter($query,array("id"))[0]["id"] ;
				}
				$query = "SELECT * FROM `textes` WHERE `id` BETWEEN " . $extremites[0]["id"] . " AND " . $extremites[1]["id"] ; 
				$this->versets = array_merge($this->versets, $connection->queter($query, array("id","chapitre", "verset", "texte")));
			} else { $this->erreurs[] = "Erreur :".$connection->erreur ; }

		}
	}
}
?>