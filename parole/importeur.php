<?php

ob_start();

print("
    <html>
        <head>
            <title>Importeur </title>
        </head>
     <body>
");

if ( $references = filter_input(INPUT_POST, 'reference', FILTER_SANITIZE_STRING) ) { 

    $url = "https://www.aelf.org/bible/Ex/8" ;

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

    # Iterate over all the <a> tags
    foreach($dom->getElementsByTagName('p') as $ligne) {
        print_r($ligne["nodeValue"]);
    }

    //var_dump($response) ;
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
			<label for="nb_chap">Livre :</label><br>
			<input type="text" id="nb_chap" name="nb_chap"><br>
			<input type="submit" value="Envoyer">
		</form>
	</body>
	</html>
	<?php
}

print("</body></html>");

ob_end_flush();

?>