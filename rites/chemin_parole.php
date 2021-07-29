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
            <input name="chant_entree" id="chant_entree" type="text" list="chants_list">
            <datalist id="chants_list">
                <option value="À la cène de l’agneau p.27">
                <option value="À la victime pascale p.75">
                <option value="À toi, Seigneur, on doit la louange en Sion p.100">
                <option value="Abba, Père p.45">
                <option value="Abraham p.63">
                <option value="Acclamations avant l’Evangile (Carême) p.21">
                <option value="Acclamez le Seigneur p.84">
                <option value="Agnelle de Dieu p.261">
                <option value="Agneau de Dieu p.26">
                <option value="Akeda p.221">
                <option value="Alléluia, le règne est déjà arrivé p.45">
                <option value="Alléluia (Temps Ordinaire) p.20-21">
                <option value="Alléluia pascal p.20">
                <option value="Alléluia, louez Dieu p.43">
                <option value="Allez et annoncez à mes frères p.130">
                <option value="Allons vite bergers p.113">
                <option value="Amen, Amen, Amen p.77">
                <option value="Assieds-toi, solitaire p.201">
                <option value="Au bord des fleuves de Babylone p.69">
                <option value="Au milieu d’une grande foule p.144">
                <option value="Au réveil, je me rassasierai p.85">
                <option value="Ave Maria (1984) p.48">
                <option value="Ave Maria p.48">
                <option value="Bénédiction de l’eau p.12-13">
                <option value="Bénédiction pour la cél. pénitentielle p.3">
                <option value="Benedictus (Cantique de Zacharie). p.60">
                <option value="Béni soit Dieu Père p.211">
                <option value="Bénis, mon âme, Yahvé p.34">
                <option value="Bénissez le Seigneur p.103">
                <option value="Cantique de la Croix Glorieuse p.218">
                <option value="Cantique de l’Agneau p.263">
                <option value="Cantique de Moïse p.64">
                <option value="Cantique de Zacharie (Benedictus). p.60">
                <option value="Cantique des Créatures (1e partie).. p.40">
                <option value="Cantique des Créatures (2e partie).. p.41">
                <option value="Gantas Christi p.274">
                <option value="Carmen 63 (de Tagore) p.273">
                <option value="Ceci est mon commandement p.143">
                <option value="Chant de Balaam p.92">
                <option value="Les rois te verront (Serviteur II) p.202">
                <option value="Le Seigneur m’a donné... (Serviteur III) p.206">
                <option value="Devant Lui on se voile la face (Serviteur IV) p.33">
                <option value="Comme coule le miel (Ode 40 de Salomon) p.275">
                <option value="Comme des condamnés à mort p.254">
                <option value="Comme le cerf languit p.83">
                <option value="Comme l’élan de la colère p.210">
                <option value="Consolez mon peuple p.96">
                <option value="Credo p.23">
                <option value="Criez de joie p.84">
                <option value="Dans une nuit obscure p.133">
                <option value="Dayenou p.74">
                <option value="Déborah p.204">
                <option value="Dieu monte au milieu des acclamations p.82">
                <option value="Dis, mon peuple (Impropères) p.106">
                <option value="Dites aux cœurs égarés p.87">
                <option value="Du profond p.132">
                <option value="Eli, Eli, léma Sabachtani p.214-215">
                <option value="En présence des anges p.99">
                <option value="Evenu Shalom p.44">
                <option value="Exultet pascal p.14-15">
                <option value="Exultez les justes p.121">
                <option value="Félicité pour l’homme p.124">
                <option value="Filles de Jérusalem p.104">
                <option value="Frères ne donnons à personne l’occasion p.142">
                <option value="Gloire à Dieu p.4">
                <option value="Gloria, Gloria, Gloria p.120">
                <option value="Goûtez et voyez p.22">
                <option value="Grâces à Yahvé p.39">
                <option value="Heureux l’homme p.111">
                <option value="Homélie Pascale de Méliton de Sardes p.272">
                <option value="Hymne à la Charité p.252">
                <option value="Hymne de louange (Te Deum) p.24">
                <option value="Hymne de Pâques p.27">
                <option value="Hymne de Pentecôte p.18">
                <option value="II n’est pas ici, il est ressuscité p.139">
                <option value="II y avait deux anges p.97">
                <option value="Jacob p.203">
                <option value="J’aime le Seigneur car il écoute p.98">
                <option value="Je bénirai le Seigneur en tout temps p.108">
                <option value="Je lève les yeux vers les monts p.72">
                <option value="Je ne mourrai pas p.88-89">
                <option value="Je t’ai montré mon péché p.105">
                <option value="Je t’aime, Seigneur p.123">
                <option value="Je t’appelle, Seigneur p.117">
                <option value="Je veux aller à Jérusalem p.223">
                <option value="Je veux chanter p.81">
                <option value="Je vous en conjure p.259">
                <option value="Je vous prendrai des nations p.141">
                <option value="J’élèverai la coupe du salut p.58">
                <option value="J’espérais, j’espérais dans te Seigneur.. p.80">
                <option value="Jésus parcourait toutes les villes p.255">
                <option value="Jésus-Christ est le Seigneur p.71">
                <option value="J’étends les mains p.271">
                <option value="Jour de repos p.95">
                <option value="Jusques à quand p.35">
                <option value="La colombe vola p.266">
                <option value="La marche est rude p.34">
                <option value="La moisson des nations p.109">
                <option value="La voix de mon bien aimé p.265">
                <option value="Le cheval blanc p.205">
                <option value="Le fouleurau pressoir p.207">
                <option value="Le même Dieu qui a dit p.253">
                <option value="Le Messie, lion pour vaincre p.151">
                <option value="Le peuple qui marchait dans tes ténèbres p.91">
                <option value="Le Seigneur annonce une nouvelle.. p.102">
                <option value="Le Seigneur dit à mon Seigneur p.110">
                <option value="Le Seigneur est mon berger p.68">
                <option value="Le Seigneur vient vêtu de majesté p.95">
                <option value="Le Semeur p.208">
                <option value="L’Esprit du Seigneur est sur moi p.222">
                <option value="Levez, ô portes p.67">
                <option value="L’insensé pense p.136">
                <option value="Litanies des Saints (Nuit Pascale) p.17">
                <option value="Litanies pénitentielles brèves p.1">
                <option value="Litanies pénitentielles longues p.2">
                <option value="Louez le Seigneur p.65">
                <option value="Louez le Seigneur depuis les cieux p.42">
                <option value="Magnificat p.47">
                <option value="Maria de Jasna Gora p.55">
                <option value="Marie, colombe intacte p.147">
                <option value="Marie, fille de ton fils (Vierge de la merveille) p.53">
                <option value="Marie, maison de bénédiction p.54">
                <option value="Marie, Mère de l’Eglise p.50">
                <option value="Marie, Mère du chemin ardent p.56">
                <option value="Marie, petite Marie p.49">
                <option value="Mon âme, bénis le Seigneur (Cantique de Tobie) p.93">
                <option value="Ne résistez pas au mal p.256">
                <option value="Ne t’indigne pas à la vue des méchants p.251">
                <option value="Noli me tangere p.262">
                <option value="Notre Père p.25">
                <option value="Ô Dieu, par ton nom, sauve-moi p.134">
                <option value="Ô Dieu, tu es mon Dieu p.90">
                <option value="ô Jésus, mon amour p.267">
                <option value="ô Seigneur, mon cœur n’est plus prétentieux p.216">
                <option value="ô Seigneur notre Dieu p.107">
                <option value="Où est-elle, ô mort, ta victoire p.61">
                <option value="Ouri, Ouri, Ouri, Hourra ! p.76">
                <option value="Personne ne peut servir deux maîtres p.213">
                <option value="Pitié pour moi p.70">
                <option value="Porte moi au ciel p.268">
                <option value="Pour l’amour de mes frères p.79">
                <option value="Pourquoi cette nuit p.86">
                <option value="Pourquoi ce tumulte des nations p.129">
                <option value="Préface de l’Eucharistie de la Vigile pascale p.16">
                <option value="Prière eucharistique II p.8-11">
                <option value="Psaume responsorial (Exemple) p.22">
                <option value="Quand Israël sortit d’Egypte p.66">
                <option value="Quand le Seigneur fit revenir p.59">
                <option value="Que ta maison est désirable p.94">
                <option value="Qui est celle-ci p.264">
                <option value="Qui nous séparera p.46">
                <option value="Qu’il est beau, quelle allégresse p.37">
                <option value="Qu’il me donne les baisers de sa bouche p.257">
                <option value="Regardez comme il est beau p.37">
                <option value="Ressuscité p.31">
                <option value="Resurrexit p.150">
                <option value="Revêtez-vous de l’armure de Dieu p.219">
                <option value="Reviens du Liban p.258">
                <option value="Salut, Reine des cieux p.52">
                <option value="Sanctus (1983) p.7">
                <option value="Sanctus (1988) p.7">
                <option value="Sanctus du Temps de Carême p.5">
                <option value="Sanctus du Temps de l’Avent (Sanctus des Baraques) p.6">
                <option value="Sanctus du Temps ordinaire p.5">
                <option value="Sanctus du Temps pascal (Hosanna des Rameaux) p.6">
                <option value="Seigneur, aide-moi, Seigneur p.126">
                <option value="Seigneur, ne me corrige pas p.119">
                <option value="Seigneur, Seigneur Jésus p.36">
                <option value="Seigneur, tu me scrutes p.212">
                <option value="Sermon sur la montagne p.138">
                <option value="Séquence Corps et Sang du Christ p.28">
                <option value="Seule à seul p.141">
                <option value="Shema Israël p.217">
                <option value="Shlom lech Mariam p.57">
                <option value="Si aujourd’hui p.73">
                <option value="Si dans le Seigneur p.101">
                <option value="Si le Seigneur ne construit la maison">
                <option value="Si tu sens un souffle du ciel p.62">
                <option value="Si vous êtes ressuscites avec le Christ p.149">
                <option value="Sion, mère de tous les peuples p.220">
                <option value="Stabat Mater p.51">
                <option value="Tant ils m’ont persécuté p.122">
                <option value="Te Deum p.24">
                <option value="Toi qui es fidèle p.135">
                <option value="Toi qui habites dans les jardins p.260">
                <option value="Toi, Seigneur, dans ma clameur p.114">
                <option value="Tu as volé mon cœur p.146">
                <option value="Tu es belle, mon amie p.140">
                <option value="Tu es bénie, Marie p.52">
                <option value="Tu es le plus beau p.112">
                <option value="Tu es mon espérance, Seigneur p.269">
                <option value="Tu m’as séduit, Seigneur p.127">
                <option value="Tu m’enseigneras le chemin de la vie p.131">
                <option value="Un rejeton sort de la souche de Jessé p.115">
                <option value="Un signe grandiose p.270">
                <option value="Venez à moi, vous tous p.125">
                <option value="Vers toi, ô cité sainte p.32">
                <option value="Vers toi, Seigneur, je lève mes yeux p.118">
                <option value="Vers toi, Seigneur, j’élève mon âme p.116">
                <option value="Viens Esprit créateur (Hymne de Pentecôte) p.18">
                <option value="Viens Esprit Saint (Séquence de Pentecôte) p.19">
                <option value="Viens, Fils de l’Homme p.128">
                <option value="Vierge de la merveille (Marie, fille de ton fils) p.53">
                <option value="Voici mon serviteur p.137">
                <option value="Voici, notre miroir p.209">
                <option value="Voici que mon retour est proche p.128">
                <option value="Vous êtes la lumière du monde p.148">
                <option value="Voyez comme il est beau p.38">
                <option value="Yahvé, tu es mon Dieu p.35">
                <option value="Zachée p.145">
            </datalist></div></fieldset>' ;


        $output .= '<fieldset id="field_ev" name="field_ev"><legend>Évangile</legend>
                    <div><label for="mon_ev">Monition Évangile :</label>
                    <input name="mon_ev" id="mon_ev" type="text"></div>
                    <div><label for="ref_ev">Référence Évangile :</label>
                    <input name="ref_ev" id="ref_ev" type="text"></div>
                    </fieldset>
                    <fieldset id="field_final" name="field_final"><legend>Envoi</legend>
                    <div><label for="chant_paix">Chant de paix : </label>
                    <input name="chant_paix" id="chant_paix" type="text" size="40" list="chants_list"></div>
                    <div><label for="chant_sortie">Chant de sortie : </label>
                    <input name="chant_sortie" id="chant_sortie" type="text" size="40" list="chants_list"></div>
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
            $output .= '<p class="repons">Parole de Dieu</p><p>Chant après la ' . $ordinal . ' lecture : ' . $chant . '</p></section>' ;
        }
        $output .= '<section class="parties" id="lecture_ev" name="lecture_ev">
                        <h2 class="titre2">Évangile (' . $reponses['ref_ev'] . ') </h2>
                        <p>Monition Évangile : ' . $reponses['mon_ev'] . '</p>';
        $opt_pericope = array(
            "corpus" => 1,
            "version" => 1,
            "ref" => trim( explode("|", $reponses['ref_ev'])[0] )
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
        $output .= '<p class="repons">Acclamons la parole de Dieu</p></section>
                    <section class="parties" id="sortie" name="sortie">
                    <h2 class="titre2">Sortie</h2>
                        <div><p>Chant de Paix : ' . $reponses['chant_paix'] . '</p>
                            <p>Chant de sortie : ' . $reponses['chant_sortie'] . '</p></div>
                    </section>' ;
        return $output ;
    }
}

?>