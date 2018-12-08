<?php
/**
 * Como fazer quando ele buscar? Mostra os pontos? Fixa no primeiro onibus que achar? Para onde ele vai?
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    
    $onibus = $res->getBody();
    $onibus_decodificado = json_decode($onibus,true);
    
    //Formulas https://secure.php.net/manual/pt_BR/ref.math.php

    //Passagem pela formula de tratamento e filtragem
    //https://math.stackexchange.com/questions/1836802/formula-to-map-any-given-point-on-circumference-of-circle-with-given-radius
    /**
     * $px e $py sao os pontos de onde o onibus esta
     * $raio eh a variavel usada para definir a diferenca de 1km
     * $h e $k sao os pontos do centro do circulo para ser feito o calculo
     */

    //Verificar qual o px e o py.
    /*$lng_centro = $_POST['lng_centro'];
    $lat_centro = $_POST['lat_centro'];
    $raio = $_POST['raio'];*/

    /*
    function filtro($px,$py){
        //F(x,y) = (x-h)^2 + (y-k)^2 - r^2 = 0
        //r^2
        $raio_quad = pow($raio,2);
        
        //(x-h)^2
        $part_um = ($px-$lng_centro);
        $part_um_quad = pow($part_um,2);

        //(y-k)^2
        $part_dois = ($py-$lat_centro);
        $part_dois_quad = pow($part_dois,2);

        $resultado = $part_um + $part_dois - $raio_quad;
        return $resultado;
    }
    */
    function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }

    $features = array();
    $list = $onibus_decodificado['l'];    //Pega as listas de ônibus

    foreach($list as $key => $value){
        
        //echo "<p>c: {$value['c']}, sl: {$value['sl']}, lt0: {$value['lt0']}, lt1: {$value['lt1']}</p>";
        
        $c = $value['c'];
        $sl = $value['sl'];
        $lt0 = $value['lt0'];
        $lt1 = $value['lt1'];
        
        /*print $value['sl'];
        print $value['lt0'];
        print $value['lt1'];*/
        //print $value['vs']['p'];   //Acessa dentro de 'vs'

        foreach($value['vs'] as $key_linha => $value_linha){
            
            //echo "<p>p: {$value_linha['p']}, lat(py): {$value_linha['py']}, lon(px): {$value_linha['px']}</p>";
            
            $features[] = array(
                "type" => "Feature",
                "geometry" => array(
                    "type" => "Point",
                    "coordinates" => array(
                        $value_linha["px"],
                        $value_linha["py"],
                    ),
                ),
                'properties' => array(
                    'c' => $c,
                    'sl' => $sl,
                    'lt0' => $lt0,
                    'lt1' => $lt1,
                    'p' => $value_linha['p']
                ),
            );
        }
        
    }
    $new_data = array(
        "type" => "FeatureCollection",
        "features" => $features
    );
    
    $onibus_codificado_json = json_encode($new_data, JSON_PRETTY_PRINT);
    echo $onibus_codificado_json;
    //print_r($onibus_decode);
    //print_r($new_data);


    /*
    if($res) {
        while ($row = mysqli_fetch_assoc($result))
        {
          $data[] = utf8ize($row);
        }
    }
    
    $json_data = json_encode($data);
    $original_data = json_decode($json_data, true);
    
    $final_data = json_encode($new_data, JSON_PRETTY_PRINT);
    */
    session_write_close();
}

?>