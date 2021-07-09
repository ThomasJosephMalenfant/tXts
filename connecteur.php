<?php
// TODO : Déplacer dans /commun/classes/ et relier conséquemment
require "connect.php";

class ConnecteurDB
{
  public $lien ;
  public $online = false ;
  public $erreur ; 

  public function __construct( bool $write = false ){
    $servername = DB_HOST ;
    $db = DB_NAME ;
    
    if ($write) {
      $username = DB_WR_USR;
      $password = DB_WR_PWD;    
    } else {
      $username = DB_RO_USR ;
      $password = DB_RO_PWD ;        
    } 
      // Create connection
    $this->lien = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($this->lien->connect_error) {
      $this->erreur = $this->lien->connect_error ; 
      $this->online = false ;
    } else {
      $this->online = true ;
    }  
  }

  public function queter($query, $colonnes)
  {
    $resultat = $this->lien->query($query) ;
    $sortie = array() ;
    if ($resultat->num_rows > 0) {
      // output data of each row
      while($row = $resultat->fetch_assoc()) {
        $ligne = array() ;
        foreach ($colonnes as $colonne) {
          $ligne[$colonne] = $row[$colonne] ;
        }
        $sortie[] = $ligne ;
      }
    } else {
      $sortie[] = "query went wrong..." ;
    }
    
    return $sortie ;
  }

  public function __destruct(){
    $this->lien->close();
  }

}

?>