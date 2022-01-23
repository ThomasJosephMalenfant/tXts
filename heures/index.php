<?php
require_once '../env.php';

ob_start();
if ( $semaine_nb = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ) {
    // FIXME dispatch de <section> gère mal antiennes finale sur laudes, vêpres et complies (faire comme sur Sexte)  
    // TODO Quand un psaume a plus que X ligne, <section class=*_double> css: 2 columns
    //  *Construction des variables en fonction du jour choisi*

    //  Semaine actuelle = 0, ...
    $semaine_nb = $semaine_nb - 1 ;
    $ajoutsemaine = '+' . $semaine_nb . ' week' ;

    //  Génération de la date de dimanche dernier
    //  Génération de la semaine
    //  Génération de la date-string
    $jour = new DateTime('last sunday');
    $jour->modify($ajoutsemaine);
    
//    for ($i=0; $i < 7 ; $i++) {  // Ligne originale fix racourcir pendant dbug
    for ($i=0; $i < 1 ; $i++) { 
            
        $textes = array();
        
        //  Liste des offices inclus
        $offices = array(
            "informations",
            "messes",
            "lectures",
            "laudes"/* ,
            "sexte",
            "vepres",
            "complies" */
            ) ;   
        // **Extraction des textes
        foreach ($offices as $office) {
            
            // Génération de l'url cf. https://api.aelf.org
            $url = "https://api.aelf.org/v1/"
                        . $office
                        ."/". $jour->format("Y-m-d")
                        . "/canada" ;
            
            //  Construction de la requête curl
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "cache-control: no-cache"
                    ),
                )
            );
            
            // Execution de la requête curl
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $data = json_decode($response, true);
            
            //  Ajout du texte de l'office $office
            $textes[$office] = $data ;
        }
        // Génération de la page synthèse
        if ($i == 0 ) { // Entête pour le premier jour
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
                    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
                    <link rel="apple-touch-icon" sizes="180x180" href="../commun/icones/apple-touch-icon.png">
                    <link rel="icon" type="image/png" sizes="32x32" href="../commun/icones/favicon-32x32.png">
                    <link rel="icon" type="image/png" sizes="16x16" href="../commun/icones/favicon-16x16.png">
                    <link rel="stylesheet" href="./heures.css">
                    <title><?php print_r($textes["informations"]["informations"]["semaine"]); ?></title>
                </head>
                <body>
            <?php 
        }
        ?>
            <?php // Information du jour ?>
            <p class="titre1"><?php print_r($textes["informations"]["informations"]["jour_liturgique_nom"]); ?></p>
            <p class="titre1"><?php print_r($textes["informations"]["informations"]["jour"]); ?></p>
            <p class="titre1"><?php print_r($textes["informations"]["informations"]["date"]); ?></p>
            <p><?php print_r($textes["informations"]["informations"]["fete"] . " [" . $textes["informations"]["informations"]["couleur"] . "]"); ?></p>
            <hr class="fin" >
            
            <?php // Laudes & Office 
            $cet_office = $textes["laudes"]["laudes"] ;
            ?>
            <p class="titre2">Laudes & lectures</p>
            <p class="titre3">Introduction</p>
            <p><?php print_r($cet_office["introduction"]); ?></p>
            <section class="invitatoire">
                <p class="titre3">Antienne invitatoire</p>
                <?php print_r($cet_office["antienne_invitatoire"]); ?>
                <p class="titre3">Psaume invitatoire (<?php print_r($cet_office["psaume_invitatoire"]["reference"]); ?>)</p>
                <?php print_r($cet_office["psaume_invitatoire"]["texte"]); ?>
                <p class="titre3">Antienne invitatoire</p>
                <?php print_r($cet_office["antienne_invitatoire"]); ?>
                </section>
            <section class="hymne">
                <p class="titre3">Hymne : <?php print_r($cet_office["hymne"]["titre"]); ?></p>
                <p><?php print_r($cet_office["hymne"]["texte"]); ?> </p>
                </section>
                <section class="psaume1">
                <p class="titre3">Antienne 1</p>
                <p><?php
                    $antienne = $cet_office["antienne_1"] ;
                    print_r($antienne); ?></p>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_1"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_1"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_2"] ) {
                    ?>
                    <p class="titre3">Antienne </p>
                    <p><?php print_r($cet_office["antienne_1"]); ?></p>
                </section>
            <section class="psaume2">
                <p class="titre3">Antienne 2</p>
                    <p><?php
                        $antienne = $cet_office["antienne_2"] ;
                        print_r($antienne); ?> </p>
                    <?php } else { ?> 
                </section>
            <section class="psaume2">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_2"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_2"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_3"] ) {
                    ?>
                    <p class="titre3">Antienne</p>
                    <p><?php print_r($antienne); ?></p>
                </section>
            <section class="psaume3">
                    <p class="titre3">Antienne 3</p>
                    <p><?php
                            $antienne = $cet_office["antienne_3"] ;
                            print_r($antienne); ?></p>
                    <?php } else { ?> 
                </section>
            <section class="psaume3">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_3"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_3"]["texte"]); ?></p>
                <p class="titre3">Antienne</p>
                <p><?php print_r($antienne); ?></p>
                </section>
            <section class="parole_Dieu">
                <p class="titre3">Parole de Dieu : <?php print_r("(" . $cet_office["pericope"]["reference"] . ")"); ?></p>
                <p><?php print_r($cet_office["pericope"]["texte"]); ?></p>
                <p class="titre3">Répons</p>
                <p><?php print_r($cet_office["repons"]  ); ?></p>
                </section>
            <section class="lecture_longue">
                <p class="titre3">Lecture : <?php print_r("(" . $textes["lectures"]["lectures"]["lecture"]["reference"] . ")"); ?></p>
                <p><?php print_r($textes["lectures"]["lectures"]["lecture"]["texte"]); ?></p>
                <p class="titre3">Répons</p>
                <p><?php print_r($textes["lectures"]["lectures"]["repons_lecture"]); ?></p>
                </section>
            <section class="patristique">
                <p class="titre3"><?php print_r($textes["lectures"]["lectures"]["titre_patristique"]); ?></p>
                <p><?php print_r($textes["lectures"]["lectures"]["texte_patristique"]); ?></p>
                <p class="titre3">Répons</p>
                <p><?php print_r( $textes["lectures"]["lectures"]["repons_patristique"] ) ; ?></p>
                </section>
            <?php $evang = count($textes['messes']['messes'][0]['lectures']) ;
                    $evang-- ;?>
            <p class="titre3"><?php print_r($textes["messes"]["messes"][0]["lectures"][$evang]['intro_lue']); ?></p>
            <p><?php print_r( $textes["messes"]["messes"][0]["lectures"][$evang]['ref'] ) ; ?></p>
            <p><?php print_r( $textes["messes"]["messes"][0]["lectures"][$evang]['contenu'] ) ; ?></p>
            <p class="titre3">Oraison 15 minutes</p>
            <section class="cant_ev">
                <p class="titre3">Antienne de Zacharie</p>
                <p><?php print_r($cet_office["antienne_zacharie"]); ?></p>
                <p class="titre3">Cantique de Zacharie</p>
                <p><?php print_r($cet_office["cantique_zacharie"]["texte"]); ?></p>
                <p class="titre3">Antienne de Zacharie</p>
                <p><?php print_r($cet_office["antienne_zacharie"]); ?></p>
                </section>
            <section class="intercessions">
                <p class="titre3">Intercession</p>
                <p><?php print_r($cet_office["intercession"]); ?></p>
                </section>
            <p class="titre3">Notre Père</p>
            <p class="titre3">Oraison</p>
            <p><?php print_r($cet_office["oraison"]); ?></p>
            <hr class="fin" >
            
            <?php // Sexte
            $cet_office = $textes["sexte"]["sexte"] ;
            ?>
            <p class="titre2">Sexte</p>
            <p class="titre3">Introduction</p>
            <p><?php print_r($cet_office["introduction"]); ?></p>
            <p class="titre3">Hymne : <?php print_r($cet_office["hymne"]["titre"]); ?></p>
            <p><?php print_r($cet_office["hymne"]["texte"]); ?> </p>
            <section class="psaume1">
                <p class="titre3">Antienne 1</p>
                <p><?php
                    $antienne = $cet_office["antienne_1"] ;
                    print_r($antienne); ?></p>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_1"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_1"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_2"] ) {
                    ?>
                    <p class="titre3">Antienne </p>
                    <p><?php print_r($cet_office["antienne_1"]); ?></p>
                </section>
            <section class="psaume2">
                <p class="titre3">Antienne 2</p>
                    <p><?php
                        $antienne = $cet_office["antienne_2"] ;
                        print_r($antienne); ?> </p>
                    <?php } else { ?> 
                </section>
            <section class="psaume2">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_2"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_2"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_3"] ) {
                    ?>
                    <p class="titre3">Antienne</p>
                    <p><?php print_r($antienne); ?></p>
                </section>
            <section class="psaume3">
                    <p class="titre3">Antienne 3</p>
                    <p><?php
                            $antienne = $cet_office["antienne_3"] ;
                            print_r($antienne); ?></p>
                    <?php } else { ?> 
                </section>
            <section class="psaume3">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_3"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_3"]["texte"]); ?></p>
                <p class="titre3">Antienne</p>
                <p><?php print_r($antienne); ?></p>
                </section>
            <p class="titre3">Parole de Dieu : <?php print_r("(" . $cet_office["pericope"]["reference"] . ")"); ?></p>
            <p><?php print_r($cet_office["pericope"]["texte"]); ?></p>
            <p class="titre3">Répons</p>
            <p><?php print_r( $cet_office["repons"] ); ?></p>
            <p class="titre3">Oraison</p>
            <p><?php print_r($cet_office["oraison"]) ; ?> </p>
            <hr class="fin" >
            
            <?php // Vêpres
            $cet_office = $textes["vepres"]["vepres"] ;
            ?>
            <p class="titre2">Vêpres</p>
            <p class="titre3">Introduction</p>
            <p><?php print_r($cet_office["introduction"]); ?></p>
            <p class="titre3">Hymne : <?php print_r($cet_office["hymne"]["titre"]); ?></p>
            <p><?php print_r($cet_office["hymne"]["texte"]); ?> </p>
            <section class="psaume1">
                <p class="titre3">Antienne 1</p>
                <p><?php
                    $antienne = $cet_office["antienne_1"] ;
                    print_r($antienne); ?></p>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_1"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_1"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_2"] ) {
                    ?>
                    <p class="titre3">Antienne </p>
                    <p><?php print_r($cet_office["antienne_1"]); ?></p>
                </section>
            <section class="psaume2">
                <p class="titre3">Antienne 2</p>
                    <p><?php
                        $antienne = $cet_office["antienne_2"] ;
                        print_r($antienne); ?> </p>
                    <?php } else { ?> 
                </section>
            <section class="psaume2">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_2"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_2"]["texte"]); ?></p>
                <?php if ( $cet_office["antienne_3"] ) {
                    ?>
                    <p class="titre3">Antienne</p>
                    <p><?php print_r($antienne); ?></p>
                </section>
            <section class="psaume3">
                    <p class="titre3">Antienne 3</p>
                    <p><?php
                            $antienne = $cet_office["antienne_3"] ;
                            print_r($antienne); ?></p>
                    <?php } else { ?> 
                </section>
            <section class="psaume3">
                <?php }?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_3"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_3"]["texte"]); ?></p>
                <p class="titre3">Antienne</p>
                <p><?php print_r($antienne); ?></p>
                </section>
            <section class="parole_Dieu">
                <p class="titre3">Parole de Dieu : <?php print_r("(" . $cet_office["pericope"]["reference"] . ")"); ?></p>
                <p><?php print_r($cet_office["pericope"]["texte"]); ?></p>
                <p class="titre3">Répons</p>
                <p><?php print_r( $cet_office["repons"] ); ?></p>
                </section>
            <section class="cant_ev">
                <p class="titre3">Antienne du Magnificat</p>
                <p><?php print_r($cet_office["antienne_magnificat"]); ?></p>
                <p class="titre3">Cantique du Magnificat</p>
                <p><?php print_r($cet_office["cantique_mariale"]["texte"]); ?></p>
                <p class="titre3">Antienne du Magnificat</p>
                <p><?php print_r($cet_office["antienne_magnificat"]); ?></p>
                </section>
            <section class="intercessions">
                <p class="titre3">Intercession</p>
                <p><?php print_r($cet_office["intercession"]); ?></p>
                </section>
            <p class="titre3">Notre Père</p>
            <p class="titre3">Oraison</p>
            <p><?php print_r($cet_office["oraison"]); ?></p>
            <hr class="fin" >
            
            <?php // Complies
            $cet_office = $textes["complies"]["complies"] ;
            ?>
            <p class="titre2">Complies</p>
            <p class="titre3">Introduction</p>
            <p><?php print_r($cet_office["introduction"]); ?></p>
            <p class="titre3">Hymne : <?php print_r($cet_office["hymne"]["titre"]); ?></p>
            <p><?php print_r($cet_office["hymne"]["texte"]); ?> </p>
            <p class="titre3">Antienne 1</p>
            <p><?php
                $antienne = $cet_office["antienne_1"] ;
                print_r($antienne); ?></p>
            <p class="titre3">Psaume : <?php print_r($cet_office["psaume_1"]["reference"]); ?></p>
            <p><?php print_r($cet_office["psaume_1"]["texte"]); ?></p>
            <?php if ( $cet_office["antienne_2"] ) {
                ?>
                <p class="titre3">Antienne </p>
                <p><?php print_r($cet_office["antienne_1"]); ?></p>
                <p class="titre3">Antienne 2</p>
                <p><?php
                    $antienne = $cet_office["antienne_2"] ;
                    print_r($antienne); ?> </p>
                <?php }
            if ( $cet_office["psaume_2"] ) {
                ?>
                <p class="titre3">Psaume : <?php print_r($cet_office["psaume_2"]["reference"]); ?></p>
                <p><?php print_r($cet_office["psaume_2"]["texte"]); ?></p>
                
                <?php } ?>
            <p class="titre3">Antienne </p>
            <p><?php print_r($antienne); ?></p>
            <p class="titre3">Parole de Dieu : <?php print_r("(" . $cet_office["pericope"]["reference"] . ")"); ?></p>
            <p><?php print_r($cet_office["pericope"]["texte"]); ?></p>
            <p class="titre3">Répons</p>
            <p><?php print_r( $cet_office["repons"] ); ?></p>
            <p class="titre3">Antienne cantique de Syméon</p>
            <p><?php print_r($cet_office["antienne_symeon"]); ?></p>
            <p class="titre3">Cantique de Syméon</p>
            <p><?php print_r($cet_office["cantique_symeon"]["texte"]); ?></p>
            <p class="titre3">Antienne cantique de Syméon</p>
            <p><?php print_r($cet_office["antienne_symeon"]); ?></p>
            <p class="titre3">Oraison</p>
            <p><?php print_r($cet_office["oraison"]); ?></p>
            <p class="titre3">Bénédiction</p>
            <p><?php print_r($cet_office["benediction"]); ?></p>
            <p class="titre3"><?php print_r( $cet_office["hymne_mariale"]["titre"]) ; ?> </p>
            <p><?php print_r( $cet_office["hymne_mariale"]["texte"]) ; ?> </p>
            <hr class="fin" >
        <?php
        $jour->modify('+1 day');
    }
    ?>
        </body>
        </html>
        <script type="text/javascript">
            <!--
            window.print();
            //-->
        </script>
    <?php
} else {
  ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Choix du jour</title>
        </head>
        <body>
            <h2>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=1' ); ?>" > Cette semaine </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=2' ); ?>"> Semaine prochaine </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=3' ); ?>"> Dans 2 semaines </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=4' ); ?>"> Dans 3 semaines </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=5' ); ?>"> Dans 4 semaines </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=6' ); ?>"> Dans 5 semaines </a><br>
                <a href="<?php print_r( URL_PREFIX . '/heures/index.php?page=7' ); ?>"> Dans 6 semaines </a><br>
            </h2>
        </body>
    </html>

  <?php
}
ob_end_flush();
?>
