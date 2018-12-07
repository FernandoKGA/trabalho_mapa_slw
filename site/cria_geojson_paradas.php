<?php
    if(isset($_GET)){
        $con = mysqli_connect("localhost", "root", "", "g5");
        $query = "SELECT * FROM paradas";
        $data = array();
        
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

        if($result = mysqli_query($con,$query)) {
            while ($row = mysqli_fetch_assoc($result))
            {
              $data[] = utf8ize($row);
            }
        }

        $json_data = json_encode($data);
        $original_data = json_decode($json_data, true);
        $features = array();
        foreach($original_data as $key => $value){
            
            $features[] = array(
                "type" => "Feature",
                "geometry" => array(
                    "type" => "Point",
                    "coordinates" => array(
                        $value["stop_lon"],
                        $value["stop_lat"],
                    ),
                ),
                'properties' => array(
                    'stop_id' => $value['stop_id'],
                    'stop_name' => $value['stop_name'],
                    'stop_desc' => $value['stop_desc']
                ),
            );
        }
        $new_data = array(
            "type" => "FeatureCollection",
            "features" => $features
        );

        $final_data = json_encode($new_data, JSON_PRETTY_PRINT);

        //Criara um arquivo json com os dados criados.
        $file = fopen("geojson_paradas.json", "w+");
        touch($file);
        fwrite($file,$final_data);
        fclose($file);
    }
?>