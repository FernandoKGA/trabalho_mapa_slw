<?php

if(isset($_POST)){
    session_start();
    require "../../vendor/autoload.php";
    $client = new GuzzleHttp\Client();
    $cookie = $_SESSION["cookie"];
    $sptrans = $_SESSION["sptrans"];
    $termo = "281";
    $res = $client->request("GET","$sptrans/Posicao/Linha?codigoLinha=$termo",
        ['headers' => [
            'Cookie' => $cookie
           ]
        ]);
    echo $res->getBody();
    session_write_close();
}

?>