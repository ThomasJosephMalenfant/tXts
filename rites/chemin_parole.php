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
        $output = '<h2>Construction Célébration de la Parole</h2><div class="questions"><form method="POST"><fieldset>
            <legend>Général</legend>
            <div><label for="communaute">Communauté : </label>
            <input name="communaute" id="communaute" list="comm_list" type="text">
            <datalist id="comm_list"><option value="STU1"><option value="NDF4"></datalist></div>
            <div><label for="theme">Thème :</label>
            <input name="theme" id="theme" type="text"></div>
            <div><label for="president">Président : </label>
            <input name="president" id="president" type="text" list="pretres_list">
            <datalist id="pretres_list"><option value="Thomas"><option value="Laurent"><option value="Victoriano"><option value="Matteo"></datalist></div>
            <div><label for="jour">Date :</label>
            <input name="jour" id="jour" type="date"></div>
            <div><label for="mon_entree">Monition d’entrée :</label>
            <input name="mon_entree" id="mon_entree" type="text"></div>
            <div><label for="chant_entree">Chant d’entrée :</label>
            <input name="chant_entree" id="chant_entree" type="text"></div></fieldset>' ;
        for ($i=1; $i < 4; $i++) { 
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
        $output .= '<fieldset><legend>Évangile</legend>
                    <div><label for="mon_ev">Monition Évangile :</label>
                    <input name="mon_ev" id="mon_ev" type="text"></div>
                    <div><label for="ref_ev">Référence Évangile :</label>
                    <input name="ref_ev" id="ref_ev" type="text"></div>
                    </fieldset>' ;
        $output .= '<input id="schema" name="schema" type="hidden" value="1"><input id="rituel" name="rituel" type="hidden" value="Parole"><input type="submit" value="Envoyer"></form></div>' ;

        return $output ;

    }

    function generer(){
        // Pour langue de la date de célébration
        $local = setlocale(LC_ALL,"fr_CA.utf8") ;

        // Pour Générer correctement les préfixes ordinaux
        $pattern = file_get_contents('../commun/classes/fr_CA.txt');
        $nf = new \NumberFormatter("fr_CA.utf8", NumberFormatter::PATTERN_RULEBASED, $pattern);
        $nf->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-ordinal-feminine");

        // 
        $reponses = array() ;
        foreach ($_POST as $key => $value) {
            $reponses[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_STRING) ;
        }
        $output = '<h1 class="titre1">Parole ' . $reponses['communaute'] . ' : ' . $reponses['theme'] . '</h1>
                    <h3 class="titre3">' . ucfirst(strftime("%A le %d %B, %Y", strtotime($reponses['jour']))) . ' (p. ' . $reponses['president'] . ')</h3>
                    <section class="parties" id="ouverture" name="ouverture">
                    <h2 class="titre2">Ouverture</h2>
                        <div><p>Monition d’entrée : ' . $reponses['mon_entree'] . '</p>
                            <p>Chant d’entrée : ' . $reponses['chant_entree'] . '</p></div>
                    </section>' ;
        for ($i=1; strlen($reponses['ref_' . $i]) ; $i++) { 
 //           if (strlen($reponses['ref_' . $i])) {
                $ordinal = $nf->format($i) ;
                $monition = $reponses['mon_' . $i] ;
                $lecteur = $reponses['lect_' . $i] ;
                $ref = $reponses['ref_' . $i] ;
                $chant = $reponses['chant_' . $i] ;
                $output .= '<section class="parties" id="lecture_' . $i . '" name="lecture_' . $i . '">
                                <h2 class="titre2">' . ucfirst($ordinal) . ' lecture (' . $ref . ') </h2>
                                <p>Monition ' . $ordinal . ' lecture : ' . $monition . '</p>
                                <p>Lecteur ' . $ordinal . ' lecture : ' . $lecteur . '</p>';
                $opt_pericope = array(
                    "corpus" => 1,
                    "version" => 1,
                    "ref" => trim( explode("|", $ref)[0] )
                ) ;
                $pericope = new Pericope($opt_pericope) ;
                if (! $pericope->erreurs ) {
                    $output .= '<h3 class="titre3">' . $pericope->titre . '</h3></br>
                                <div class="editeur" contentEditable="true"><pre>' ;
                    foreach ($pericope->versets as $verset) {
                        $output .= '<p class="verset_pericope" >' . $verset["texte"] . "</p>" ;
                    }
                    $output .= '</pre></div>' ;
                } else {
                    $output .= '<h3 class="titre3"> Erreurs </h3>' ;
                    foreach ($pericope->erreurs as $erreur) {
                        $output .= '<p>' . $erreur . '</p>' ;
                    }
                }
                $output .= '<p class="repons">Parole de Dieu.</p><p>Chant après la ' . $ordinal . ' lecture : ' . $chant . '</p></section>' ;
  //          }
        }
        return $output ;
    }
}

?>