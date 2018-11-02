<?php
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
    //echo json_encode($res->getBody());   nao funciona com json_encode, ja esta em json
    //$sptrans/Posicao/Linha?codigoLinha=$termo
    //$sptrans/Linha/Buscar?termosBusca=$termo
?>