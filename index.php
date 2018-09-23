<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grupo algo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height, user-scalable=yes">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
    <?php

    ?>
    <div class="cabeca">
        Endereço:
        <div class = "pesquisa"><input type= "text" placeholder = "Pesquise"><input type="submit" value="OK"></div>
        <!-- Os inputs para serem sequenciais devem estar -->
        <input type="checkbox" name="option1" value="onibus">Ônibus em movimento<input type="checkbox" name="option2" value="paradas">Paradas de ônibus
        <div class="grupo">
            <ul style="list-style-type:none;">
                <li>Fernando Karchiloff Gouveia de Amorim</li>
                <li>Elemento 2</li>
                <li>Elemento 3</li>
                <li>Elemento 4</li>
            </ul>
        </div>
    </div>
    <div id='map' style="width: auto; height: 400px;"></div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZmVybmFuZG8ta2dhIiwiYSI6ImNqbTlpcnMxbDAwMGMzcG9nNmtldWlmYWQifQ.O4LmFPbru9U4X10QHhv1kQ';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/fernando-kga/cjmecq5bqea3l2rp07iyhzo90',
        center: [-46.631,-23.554],
        zoom: 13.0
        });
        map.addControl(new mapboxgl.GeolocateControl({
        positionOptions: {
        enableHighAccuracy: true
        },
        trackUserLocation: true
        }));
    </script>
</body>
</html>