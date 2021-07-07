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
    print("-- ---------------------------- </br>") ;
    print("-- Données du livre " . $livre . " tirées de aelf.org </br>") ;
    print("-- --------------------------- </br>") ;
    print("INSERT INTO `textes` (`chapitre`, `verset`, `texte`, `livres_id`) VALUES </br>") ;

    if ($no_db === 46 ) {   // Spécial Psaumes
        $map_ps = array(    // Mapping des livres sur aelf
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => "9A",
            10 => "9B",
            11 => 10,
            12 => 11,
            13 => 12,
            14 => 13,
            15 => 14,
            16 => 15,
            17 => 16,
            18 => 17,
            19 => 18,
            20 => 19,
            21 => 20,
            22 => 21,
            23 => 22,
            24 => 23,
            25 => 24,
            26 => 25,
            27 => 26,
            28 => 27,
            29 => 28,
            30 => 29,
            31 => 30,
            32 => 31,
            33 => 32,
            34 => 33,
            35 => 34,
            36 => 35,
            37 => 36,
            38 => 37,
            39 => 38,
            40 => 39,
            41 => 40,
            42 => 41,
            43 => 42,
            44 => 43,
            45 => 44,
            46 => 45,
            47 => 46,
            48 => 47,
            49 => 48,
            50 => 49,
            51 => 50,
            52 => 51,
            53 => 52,
            54 => 53,
            55 => 54,
            56 => 55,
            57 => 56,
            58 => 57,
            59 => 58,
            60 => 59,
            61 => 60,
            62 => 61,
            63 => 62,
            64 => 63,
            65 => 64,
            66 => 65,
            67 => 66,
            68 => 67,
            69 => 68,
            70 => 69,
            71 => 70,
            72 => 71,
            73 => 72,
            74 => 73,
            75 => 74,
            76 => 75,
            77 => 76,
            78 => 77,
            79 => 78,
            80 => 79,
            81 => 80,
            82 => 81,
            83 => 82,
            84 => 83,
            85 => 84,
            86 => 85,
            87 => 86,
            88 => 87,
            89 => 88,
            90 => 89,
            91 => 90,
            92 => 91,
            93 => 92,
            94 => 93,
            95 => 94,
            96 => 95,
            97 => 96,
            98 => 97,
            99 => 98,
            100 => 99,
            101 => 100,
            102 => 101,
            103 => 102,
            104 => 103,
            105 => 104,
            106 => 105,
            107 => 106,
            108 => 107,
            109 => 108,
            110 => 109,
            111 => 110,
            112 => 111,
            113 => 112,
            114 => "113A",
            115 => 114,
            116 => 115,
            117 => 116,
            118 => 117,
            119 => 118,
            120 => 119,
            121 => 120,
            122 => 121,
            123 => 122,
            124 => 123,
            125 => 124,
            126 => 125,
            127 => 126,
            128 => 127,
            129 => 128,
            130 => 129,
            131 => 130,
            132 => 131,
            133 => 132,
            134 => 133,
            135 => 134,
            136 => 135,
            137 => 136,
            138 => 137,
            139 => 138,
            140 => 139,
            141 => 140,
            142 => 141,
            143 => 142,
            144 => 143,
            145 => 144,
            146 => 145,
            147 => 146,
            148 => 148,
            149 => 149,
            150 => 150) ;
        foreach ($map_ps as $no_ps => $expr_ps_aelf) {
            // $url = "https://www.aelf.org/bible/Ps/" . $expr_ps_aelf ;
            
            // $curl = curl_init();
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => $url,
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 30,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "GET",
            //     CURLOPT_POSTFIELDS => "",
            //     CURLOPT_HTTPHEADER => array(
            //         "Content-Type: text/html",
            //         "cache-control: no-cache"
            //         ),
            //     )
            // );


            // $response = curl_exec($curl);
            // $err = curl_error($curl);

            // $dom = new DOMDocument();

            // @$dom->loadHTML($response);

            // foreach($dom->getElementsByTagName('p') as $ligne) {
            //     $ligne_txt = $ligne->textContent ;
            //     $ref_verset = ltrim(trim( explode(" ",$ligne_txt)[0] ), "0") ;
            //     $ref_txt = str_replace("'", "’", substr(strstr($ligne_txt," "),1));
            //     if ( $ref_verset != "Recevez") {
            //         print("('" . $no_ps . "', '" . $ref_verset . "', '" . $ref_txt . "', '" . $no_db . "'), </br>") ;
            //     }
            // }
            print($no_ps . " => " . $expr_ps_aelf );
        }
    } else {
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
                $ref_txt = str_replace("'", "’", substr(strstr($ligne_txt," "),1));
                if ( $ref_verset != "Recevez") {
                    print("('" . $i . "', '" . $ref_verset . "', '" . $ref_txt . "', '" . $no_db . "'), </br>") ;
                }
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