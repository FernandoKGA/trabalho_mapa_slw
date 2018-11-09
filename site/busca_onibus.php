<?php
/**
 * Como fazer quando ele buscar? Mostra os pontos? Fixa no primeiro onibus que achar? Para onde ele vai?
 */
if(isset($_POST)){
    session_start();
    require "../../vendor/autoload.php";
    $client = new GuzzleHttp\Client();
    $cookie = $_SESSION["cookie"];
    //echo $cookie;
    $sptrans = $_SESSION["sptrans"];
    //echo $sptrans;
    
    //dependendo do termo
    /*$termo = "281";*/
    //A requisicao soh da certo se pedir com o codigo unico da linha
    /*Linha?codigoLinha=$termo"*/
    $res = $client->request("GET","$sptrans/Posicao",
        ['headers' => [
            'Cookie' => $cookie
           ]
        ]);
    echo $res->getBody();

    //Formulas https://secure.php.net/manual/pt_BR/ref.math.php

    //Passagem pela formula de tratamento e filtragem
    //https://math.stackexchange.com/questions/1836802/formula-to-map-any-given-point-on-circumference-of-circle-with-given-radius
    /**
     * $px e $py sao os pontos de onde o onibus esta
     * $raio eh a variavel usada para definir a diferenca de 1km
     * $h e $k sao os pontos do centro do circulo para ser feito o calculo
     */

    //Verificar qual o px e o py.
    $lng_centro = $_POST['lng_centro'];
    $lat_centro = $_POST['lat_centro'];
    $raio = $_POST['raio'];
    function filtro($px,$py){
        //F(x,y) = (x-h)^2 + (y-k)^2 - r^2 = 0
        //r^2
        $raio_quad = pow($raio,2);
        
        //(x-h)^2
        $part_um = ($px-$lng_centro);
        $part_um_quad = pow($part_um,2);

        $part_dois = ()
    }
    while(1==1){

    }
    session_write_close();
}

?>