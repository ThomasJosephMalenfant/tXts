<?php
require '../connecteur.php' ;

class Pericope
{
	// Titre de la péricope
	public $titre = "Titre de la pericope" ;
	public $corpus = 1 ; // 1 = Bible
	public $version = 1 ; // 1 = aelf
	public $livre ; 
	public $versets = array(); 
	public $erreurs = array();
	
	// Recoit un string $ref et détermine et popule $this->versets en conséquence
	public function __construct( string $ref ) {   // FIXME : Transformer en array() $opt argument pour faciliter éventuellement switch de livre / version

		// Trouver l'abbréviataion du livre
		$ref_livre = trim( explode(" ",$ref)[0] ) ;

		$connection = new ConnecteurDB(false) ;

		// Test de la connection
		if ($connection->online) { 

			$query = "SELECT `id`, `name`, `titre` FROM `livres` WHERE `abbr`='".$ref_livre."' AND `versions_id`=1 LIMIT 1" ;
			$result_livre = $connection->queter($query, array("id","titre")) ; 

			// Tester si le livre a été trouvé dans cette version
			if ( is_numeric( $result_livre[0]["id"] ) ){

				$this->livre = $result_livre[0]["id"] ;
				$this->titre = $result_livre[0]["titre"];

				$ref_sans_livre = substr(strstr($ref," "),1);
				$array_sans_livre = explode(".",$ref_sans_livre);
				$depart_chapitre = "" ;
				$depart_verset = "" ;
				$fin_chapitre = "" ; 
				$fin_verset = "" ;

				foreach ($array_sans_livre as $chunk) {
					$pre_extremites = explode("-",$chunk);
					$extremites = array(); 
					if (strpos($pre_extremites[0], ",") OR $depart_chapitre) {
						if (strpos($pre_extremites[0], ",")) {
							$depart_chapitre = trim(explode(",", $pre_extremites[0])[0]);
							$depart_verset = trim(explode(",", $pre_extremites[0])[1]);
						} else {
							$depart_verset = trim($pre_extremites[0]) ;
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

					} else {
						$depart_chapitre = $pre_extremites[0] ;
						$depart_verset = "1" ;
						if (isset($pre_extremites[1])) {
							if ( strpos( $pre_extremites[1], ",")) {
								$fin_chapitre = trim(explode(",", $pre_extremites[1])[0]) ;
								$fin_verset = trim(explode(",", $pre_extremites[1])[1]);	
							} else {
								$fin_chapitre = trim($pre_extremites[1]) ;
								$fin_verset = "MAX" ;
							}							
						} else {
							$fin_chapitre = $depart_chapitre ;
							$fin_verset = "MAX" ;
						}
						if ($fin_verset == "MAX") {
							$query = "SELECT MAX(`verset`) FROM `textes` WHERE `livres_id`='".$this->livre."' AND `chapitre`='" . $fin_chapitre . "'" ;
							$fin_verset = $connection->queter($query,array("MAX(`verset`)"))[0]["MAX(`verset`)"] ;
						}
					}

					$extremites[0] = array("chapitre"=>$depart_chapitre, "verset"=>$depart_verset);
					$extremites[1] = array("chapitre"=>$fin_chapitre, "verset"=>$fin_verset);

					for ($i=0; $i < 2 ; $i++) { 
						$query = "SELECT * FROM `textes` WHERE `livres_id`='".$this->livre."' AND `chapitre`='" . $extremites[$i]["chapitre"] . "' AND `verset`='". $extremites[$i]["verset"] . "' LIMIT 1";
						$extremites[$i]["id"] = $connection->queter($query,array("id"))[0]["id"] ;

						// Teste si l'extremité existe dans la DB
						if ( ! is_numeric($extremites[$i]["id"])) { $this->erreurs[] = "Le verset " . $ref_livre . " " . $extremites[$i]["chapitre"] . ", " . $extremites[$i]["verset"] . " n'existe pas dans la version choisie." ; }
					}
					// Teste si la fin est après le début
					if( $extremites[0]["id"] <= $extremites[1]["id"] ) {
						$query = "SELECT * FROM `textes` WHERE `id` BETWEEN " . $extremites[0]["id"] . " AND " . $extremites[1]["id"] ; 
						$this->versets = array_merge($this->versets, $connection->queter($query, array("id","chapitre", "verset", "texte")));
					} else { $this->erreurs[] = "Versets de début et de fin inversés sur la péricope..." ; }
				}
			} else { $this->erreurs[] = "Ce livre (" . $ref_livre . ") n'existe pas dans la version sélectionnée." ; }			
		} else { $this->erreurs[] = "Erreur :".$connection->erreur ; }
	}
}
?>