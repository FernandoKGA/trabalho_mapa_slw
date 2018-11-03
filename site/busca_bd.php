<?php
if(isset($_POST)){
    $con = mysqli_connect("localhost", "root", "", "g5");
    //https://stackoverflow.com/questions/50010610/php-value-not-being-caught-by-ajax
    /**
     * Valores passados por $_POST devem ser puxados como $_POST['valor']
     */
    $lat_sw_cnv = number_format($_POST['lat_sw'],6,'.',',');
    $lat_ne_cnv = number_format($_POST['lat_ne'],6,'.',',');
    $lng_sw_cnv = number_format($_POST['lng_sw'],6,'.',',');
    $lng_ne_cnv = number_format($_POST['lng_ne'],6,'.',',');
    $result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lon BETWEEN $lng_sw_cnv AND $lng_ne_cnv) AND (stop_lat BETWEEN $lat_sw_cnv AND $lat_ne_cnv)");
    //$result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lat BETWEEN -23.591887 AND -23.582802) AND (stop_lon BETWEEN -46.578744 AND -46.564690)");
    $data = array();
    /**
     * Substitui toda vez que atualiza a linha e sobrescreve o resultado
     */
    /*while ($row = mysqli_fetch_assoc($result)) {
        $data["stop_id"] = $row["stop_id"];
        $data["stop_name"] = $row["stop_name"];
        $data["stop_desc"] = $row["stop_desc"];
        $data["stop_lon"] = $row["stop_lon"];
        $data["stop_lat"] = $row["stop_lat"];
    }*/

    //https://www.experts-exchange.com/questions/28628085/json-encode-fails-with-special-characters.html
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
    
    /**
     * Coloca no vetor da maneira correta
     */
    for (; $row = $result->fetch_assoc(); $data[] = utf8ize($row));
    
    //Printa para deixar a informação possivel para leitura humana
    //print_r($data);
    
    /**
     * Debugging de erro de encoding
     */
    /*var_dump($data);
    $json  = json_encode($data);
    var_dump($json);
    echo json_last_error();*/
    //http://php.net/manual/pt_BR/function.json-encode.php
    echo json_encode($data);
    //https://stackoverflow.com/questions/8373315/is-there-a-way-to-pass-multiple-arrays-to-php-json-encode-and-parse-it-with-jque
    
}
/**
 * 
 * https://stackoverflow.com/questions/4834772/get-all-records-from-mysql-database-that-are-within-google-maps-getbounds
 * 
*_ne: lng: -46.4573186922639, lat: -23.548244563235258

*-46.4573186922639,-23.548244563235258
*ne lng: -46.56469002771317, lat: -23.582802316789255
*sw lng: -46.57874480294683, lat: -23.591887504248135

*PARA QUERY, TEM QUE SER DO MAIOR PARA MENOR!
*INCORRETA = SELECT * FROM paradas WHERE (stop_lat BETWEEN -23.582802 AND -23.591887);
*CORRETA = SELECT * FROM paradas WHERE (stop_lat BETWEEN -23.591887 AND -23.582802) AND (stop_lon BETWEEN -46.578744 AND -46.564690);
*SELECT * FROM paradas WHERE (stop_lon BETWEEN -46.56469002771317 AND -46.57874480294683)
    *AND (stop_lat BETWEEN -23.582802316789255 AND -23.591887504248135)
*swlat, swlng, nelat, nelng = a, b, c, d.
*    SELECT * FROM paradas WHERE
*(CASE WHEN a < c
*        THEN stop_lat BETWEEN a AND c
*        ELSE stop_lat BETWEEN c AND a
*END) 
*AND
*(CASE WHEN b < d
*        THEN lng BETWEEN b AND d
*        ELSE lng BETWEEN d AND b
*END) 
​
*_sw: lng: -46.68614330774221, lat: -23.62690404893341

*_ne: Object { lng: -46.557609322935036, lat: -23.582766853288604 }
​
*_sw: Object { lng: -46.58621239986701, lat: -23.592599281906487 }
 */
?>
