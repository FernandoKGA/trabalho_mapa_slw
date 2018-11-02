<?php
if(isset($_POST)){
    $con = mysqli_connect("localhost", "root", "", "g5");
    $result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lon BETWEEN -46.58621239986701 AND -46.557609322935036)
    AND (stop_lat BETWEEN -23.592599281906487 AND -23.582766853288604)");
    /*$result = mysqli_query($con, "SELECT * FROM paradas WHERE (stop_lom BETWEEN $lng_sw AND $lng_ne)
    AND (stop_lat BETWEEN $lat_sw AND $lat_ne)");*/
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data["stop_id"] = $row["stop_id"];
        $data["stop_name"] = $row["stop_name"];
        $data["stop_desc"] = $row["stop_desc"];
        $data["stop_lon"] = $row["stop_lon"];
        $data["stop_lat"] = $row["stop_lat"];
    }
    echo json_encode($data);
}
/**
 * 
*_ne: lng: -46.4573186922639, lat: -23.548244563235258
​
*_sw: lng: -46.68614330774221, lat: -23.62690404893341

*_ne: Object { lng: -46.557609322935036, lat: -23.582766853288604 }
​
*_sw: Object { lng: -46.58621239986701, lat: -23.592599281906487 }
 */
?>
