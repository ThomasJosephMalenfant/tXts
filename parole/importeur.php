<?php
error_reporting(-1);
print("
    <html>
        <head>
            <title>Importeur </title>
        </head>
     <body>
");

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
    print_r($ligne);
}

//var_dump($response) ;

print("</body></html>");
?>