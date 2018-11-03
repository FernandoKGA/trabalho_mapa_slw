<?php
/**
 * Como fazer quando ele buscar? Mostra os pontos? Fixa no primeiro onibus que achar? Para onde ele vai?
 */
if(isset($_POST)){
    session_start();
    require "../../vendor/autoload.php";
    $client = new GuzzleHttp\Client();
    $cookie = $_SESSION["cookie"];
    $sptrans = $_SESSION["sptrans"];
    //dependendo do termo
    $termo = "281";
    //A requisicao soh da certo se pedir com o codigo unico da linha
    $res = $client->request("GET","$sptrans/Posicao/Linha?codigoLinha=$termo",
        ['headers' => [
            'Cookie' => $cookie
           ]
        ]);
    echo $res->getBody();
    session_write_close();
}

?>