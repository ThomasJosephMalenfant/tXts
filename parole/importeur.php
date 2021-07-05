<?php

ob_start();

print("
    <html>
        <head>
            <title>Importeur </title>
        </head>
     <body>
");

if ( $livre = filter_input(INPUT_POST, 'livre', FILTER_SANITIZE_STRING) ) { 
    $nb_chap = filter_input(INPUT_POST, 'nb_chap', FILTER_SANITIZE_STRING);
    $no_db = filter_input(INPUT_POST, 'no_db', FILTER_SANITIZE_STRING);

    // En-tête de chapitre  : 
    print("------------------------------ </br>") ;
    print("-- Données du livre " . $livre . " tirées de aelf.org --- </br>") ;
    print("------------------------------ </br>") ;
    print("INSERT INTO `textes` (`chapitre`, `verset`, `texte`, `livres_id`) VALUES </br>") ;

    for ($i=1 ; $i <= $nb_chap; $i++) {     
     
        $url = "https://www.aelf.org/bible/" . $livre . "/" . $i ;
        
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
                "Content-Type: text/html",
                "cache-control: no-cache"
                ),
            )
        );


        $response = curl_exec($curl);
        $err = curl_error($curl);

        $dom = new DOMDocument();

        @$dom->loadHTML($response);

        foreach($dom->getElementsByTagName('p') as $ligne) {
            $ligne_txt = $ligne->textContent ;
            $ref_verset = ltrim(trim( explode(" ",$ligne_txt)[0] ), "0") ;
            $ref_txt = substr(strstr($ligne_txt," "),1);
            if ( $ref_verset != "Recevez") {
                print("('" . $i . "', '" . $ref_verset . "', '" . $ref_txt . "', '" . $no_db . "'), </br>") ;
            }
        }

    }
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
 		<title>Choisir le texte</title>
	</head>
	<body>
		<form method="post" autocomplete="off">
			<label for="livre">Livre :</label><br>
			<input type="text" id="livre" name="livre"><br>
			<label for="nb_chap">Nombre de chapitre :</label><br>
			<input type="text" id="nb_chap" name="nb_chap"><br>
			<label for="no_db">Numéro du livre sur tXtsDB :</label><br>
			<input type="text" id="no_db" name="no_db"><br>
			<input type="submit" value="Envoyer">
		</form>
	</body>
	</html>
	<?php
}

print("</body></html>");

ob_end_flush();

?>