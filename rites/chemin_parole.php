<?php
require_once "../commun/classes/BibleClass.php";

class Rituel 
{
    public $type ;
    public $elements = array() ;

    function __construct() {
        $this->type = "Parole" ;
    }

    function questionnaire() {
        //FIXME : Alignement affreux des <label> et <input>
        $output .= '<h2>Construction Célébration de la Parole</h2><div class="questions"><form method="POST"><fieldset>
            <legend>Général</legend>
            <div><label for="communaute">Communauté : </label>
            <input list="comm_list" type="text" name="communaute" id="communaute">
            <datalist id="comm_list"><option value="STU1"><option value="NDF4"></datalist></div>
            <div><label for="president">Président : </label>
            <input name="president" id="president" type="text" list="pretres_list">
            <datalist id="pretres_list"><option value="Thomas"><option value="Laurent"><option value="Victoriano"><option value="Matteo"></datalist></div>
            <div><label for="jour">Date :</label>
            <input name="jour" id="jour" type="date"></div>
            <div><label for="mon_entree">Monition d’entrée :</label>
            <input name="mon_entree" id="mon_entree" type="text"></div>
            <div><label for="chant_entree">Chant d’entrée :</label>
            <input name="chant_entree" id="chant_entree" type="text"></div></fieldset>' ;
        for ($i=1; $i < 5; $i++) { 
            $output .= '<fieldset><legend>Lecture no ' . $i . '</legend>
                <div><label for="mon_' . $i . '">Monition lecture no ' . $i . ' :</label>
                <input name="mon_' . $i . '" id="mon_' . $i . '" type="text"></div>
                <div><label for="lect_' . $i . '">Proclamation lecture no ' . $i . ' :</label>
                <input name="lect_' . $i . '" id="lect_' . $i . '" type="text"></div>
                <div><label for="ref_' . $i . '">Référence lecture no ' . $i . ' :</label>
                <input name="ref_' . $i . '" id="ref_' . $i . '" type="text"></div>
                <div><label for="chant_' . $i . '">Chant après lecture no ' . $i . ' :</label>
                <input name="chant_' . $i . '" id="chant_' . $i . '" type="text"></div>
                </fieldset>' ;
        }
        $output .= '<input id="schema" name="schema" type="hidden" value="1"><input id="rituel" name="rituel" type="hidden" value="Parole"><input type="submit" value="Envoyer"></form></div>' ;

        return $output ;

    }

    function generer(){
        //NEXT : Fonction Rituel->generer() cahier de célébration en fonction du $_POST
    }
}

?>