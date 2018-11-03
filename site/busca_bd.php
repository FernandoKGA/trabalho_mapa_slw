<?php
if(isset($_POST)){
    $con = mysqli_connect("localhost", "root", "", "g5");
    /*$result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lon BETWEEN -46.58621239986701 AND -46.557609322935036)
    AND (stop_lat BETWEEN -23.592599281906487 AND -23.582766853288604)");*/
    /*$lat_sw_cnv = number_format($lat_sw,6,'.',',');
    $lat_ne_cnv = number_format($lat_ne,6,'.',',');
    $lng_sw_cnv = number_format($lng_sw,6,'.',',');
    $lng_ne_cnv = number_format($lng_ne,6,'.',',');
    $result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lon BETWEEN $lng_sw_cnv AND $lng_ne_cnv) AND (stop_lat BETWEEN $lat_sw_cnv AND $lat_ne_cnv)");*/
    $result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lat BETWEEN -23.591887 AND -23.582802) AND (stop_lon BETWEEN -46.578744 AND -46.564690)");
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
    /**
     * Coloca no vetor da maneira correta
     */
    for (; $row = $result->fetch_assoc(); $data[] = $row);
    //print_r($data);
    echo json_encode($data);
}
/**
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
