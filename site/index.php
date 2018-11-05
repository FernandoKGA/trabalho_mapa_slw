<?php
    // Chave da SPTrans Token: 7f96df5745202fffb684b3810dcc7078c0f4184b7af2a1834b065ac28b007aa2
    session_start();
    require "../../vendor/autoload.php";
    $token = "7f96df5745202fffb684b3810dcc7078c0f4184b7af2a1834b065ac28b007aa2";
    $sptrans= "http://api.olhovivo.sptrans.com.br/v2.1";
    $client = new GuzzleHttp\Client();
    $res = $client->request("POST", "$sptrans/Login/Autenticar?token=$token");
    //echo $res->getStatusCode(), "<p>";
    $cookie = $res->getHeader("Set-Cookie")[0];
    //echo $cookie;
    $_SESSION["cookie"] = $cookie;
    $_SESSION["sptrans"] = $sptrans;
    session_write_close();
    /*$res = $client->request("GET","$sptrans/linha/Buscar?termosBusca=8000",
        ['headers' => [
            'Cookie' => $cookie
           ]
        ]);*/
    //echo $res->getBody();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grupo 5</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height, user-scalable=yes">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <script src='modernizr-custom.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
    <!-- Script para o jQuery --> 
    
</head>
<body>
    <div class="cabeca">
        Endereço:
        <!-- Divisao para a caixa de pesquisa -->
        <div class = "pesquisa">
            <!-- Usa um form para se comunicar com o servidor -->
            <form action="/busca_bd.php">
                <input type= "text" placeholder = "Pesquise">
                <input type="submit" value="OK">
            </form>
        </div>
        <!-- Os inputs para serem sequenciais devem estar -->
        <nav id="opcoes" class="opcoes">
            <input type="checkbox" id="onibus" value="onibus">
            <label for="onibus">Ônibus em movimento</label>
            <input type="checkbox" name="paradas" value="paradas">
            <label for="paradas">Paradas de ônibus</label>
        </nav>
        <div class="grupo">
            <ul style="list-style-type:none;">
                <li>Fernando Karchiloff Gouveia de Amorim</li>
                <li>Fernanda Inácio</li>
                <li>Mara Tamiris</li>
                <li>Lucas Ken</li>
            </ul>
        </div>
    </div>
    <!-- Plugin do Mapbox para geocoder -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <div id='map' style='width: 100%; height: 500px;'></div>
    <script>

        //Pega a posicao da pessoa
        function get_location(){
            if(Modernizr.geolocation){
                navigator.geolocation.getCurrentPosition(sucesso,erro,opcoes);
            }
            else{
                alert("Seu navegador não suporta Geolocalização.");
            }
        }
        var opcoes = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };
        get_location();
        var load_error;

        function erro(error){
            switch(error.code){
                case error.PERMISSION_DENIED:
                    alert("Você recusou a Geolocalização, não posso abrir o mapa para você...");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Informação da localização indisponível!");
                    break;
                case error.TIMEOUT:
                    alert("O pedido ao usuário passou do tempo.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Um erro estranho aconteceu... Infelizmente não sei o que é...");
                    break;
            }
        }

        function sucesso(pos){
            /*
                Manter comentado para não gastar a API do Mapa que possui limite.
            */

            //Pega as coordenadas assim que aceita a condição
            var lat = pos.coords.latitude;  
            var long = pos.coords.longitude;
            
            mapboxgl.accessToken = 'pk.eyJ1IjoiZmVybmFuZG8ta2dhIiwiYSI6ImNqbTlpcnMxbDAwMGMzcG9nNmtldWlmYWQifQ.O4LmFPbru9U4X10QHhv1kQ';
        
            var geolocate = new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserLocation: true
            });

            var navegacao = new mapboxgl.NavigationControl({
                showCompass: true,
                showZoom: true
            });

            var escala = new mapboxgl.ScaleControl({
                maxWidth: 80,
                unit: 'metric'
            });

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/fernando-kga/cjmecq5bqea3l2rp07iyhzo90',
                center: [long, lat],
                zoom: 12.0
            });

            var zoom;
            var lnglat;
            var userlocation;

            //https://github.com/mapbox/mapbox-gl-js/issues/5464
            map.addControl(geolocate);
            geolocate.on('geolocate', function(){
                //Get the updated user location, this returns a javascript object.
                userlocation = geolocate._lastKnownPosition;

                //Your work here - Get coordinates like so
                var lat = userlocation.coords.latitude;
                var lng = userlocation.coords.longitude;
            });

            //https://stackoverflow.com/questions/3646914/how-do-i-check-if-file-exists-in-jquery-or-pure-javascript
            function UrlExists(url){
                    var http = new XMLHttpRequest();
                    http.open('HEAD', url, false);
                    http.send();
                    return http.status!=404;
            }
            if(!UrlExists("http://localhost/trabalho_slw/geojson.json")){
                $.ajax({
                    url:"cria_geojson.php",
                    method:"GET",
                    cache: false,
                    async: false,
                    success: function(data){
                        console.log("Carregado!");
                        load_error = true;
                    },
                    error: function(data, xhr, status, error){
                        console.log("Deu ruim");
                        console.log(data);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        load_error = false;
                    }
                });
            }
            else{
                load_error = true;
            }
            
            map.addControl(navegacao, 'top-right');
            map.scrollZoom.enable({around: 'center'});
            map.addControl(escala);
            // disable map rotation using right click + drag
            map.dragRotate.disable();
            // disable map rotation using touch rotation gesture
            map.touchZoomRotate.disableRotation();

            //Fazer funcoes assim que o mapa estiver carregando.
            map.on('load', function(){
                geolocate.trigger();
                zoom = map.getZoom();
                console.log(zoom);
                if(load_error){
                    console.log("Carregando sources.");
                    var loaded = false;
                    var geojson;
                    //Fara um POST para pegar o GeoJSON no diretorio.
                    $.ajax({
                        url:"http://localhost/trabalho_slw/geojson.json",
                        method:"POST",
                        cache: false,
                        async: false,
                        success: function(data){
                            console.log("Carregado!");
                            geojson = data;
                            loaded = true;
                        },
                        error: function(data, xhr, status, error){
                            console.log("Deu ruim! :(");
                            console.log(data);
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            loaded = false;
                        }
                    });

                    //Verifica se o GeoJSON foi carregado.
                    if(loaded){
                        //https://www.mapbox.com/mapbox-gl-js/api/#map#addlayer
                        map.addSource("paradas",{
                            "type": "geojson",
                            "data": geojson  //"http://localhost/trabalho_slw/geojson.json"
                        });

                        //https://www.mapbox.com/maki-icons/

                        //https://www.mapbox.com/mapbox-gl-js/style-spec/#layers
                        map.addLayer({
                            "id": "paradas_layer",
                            "type": "symbol",
                            "source": "paradas",
                            "layout": {
                                "icon-image": "triangle-15",
                                "icon-allow-overlap": false,
                                "visibility": "none"
                            } 
                        });

                        //https://www.mapbox.com/mapbox-gl-js/example/toggle-interaction-handlers/
                        document.getElementById('opcoes').addEventListener('change',function(e){
                            if(e.target.checked){
                                console.log("Marcado.");
                            }
                            else{
                                console.log("Desmarcado.");
                            }
                            map.setLayoutProperty("paradas_layer",'visibility',
                                e.target.checked ? 'visible' : 'none');
                        });
                    }
                    else{
                        console.log("Problema ao carregar GeoJSON! Verifique!");
                    }
                }
                /*setTimeout(function(){
                    lnglat = map.getBounds();
                    console.log(lnglat);
                    var lng_sw = lnglat._sw.lng;
                    var lng_ne = lnglat._ne.lng;
                    var lat_sw = lnglat._sw.lat;
                    var lat_ne = lnglat._ne.lat;
                    console.log(lng_sw);
                    console.log(lng_ne);
                    console.log(lat_sw);
                    console.log(lat_ne);
                    $.ajax({
                    url:"busca_bd.php",
                    method:"POST",
                    data:{
                        'lng_sw': lng_sw,
                        'lat_sw': lat_sw,
                        'lng_ne': lng_ne,
                        'lat_ne': lat_ne
                    },
                    //dataType é o tipo de arquivo que estamos mandando
                    //dataType:"JSON",
                    cache: false,
                    //contentType: 'application/json; charset=utf-8',
                    success: function(data){
                        //Faz o parse do JSON.
                        var data_json = JSON.parse(data);
                        console.log(data_json);
                        var i = 0;
                        //https://stackoverflow.com/questions/33995648/cannot-use-in-operator-to-search-for-length?rq=1
                        $.each(data_json, function(){
                            console.log(data_json[i].stop_lon);
                            console.log(data_json[i].stop_lat);
                            var marker = new mapboxgl.Marker()
                                .setLngLat([data_json[i].stop_lon,data_json[i].stop_lat])
                                .addTo(map);
                            i++;
                        });
                    },
                    error: function(data, xhr, status, error){
                        console.log("Deu ruim");
                        console.log(data);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });},10000);*/
    
                /*$.ajax({
                    url:"busca_onibus.php",
                    method:"POST",
                    dataType:"JSON",
                    cache: false,
                    success:function(data){
                        console.log(data);
                        
                        var marker = new mapboxgl.Marker()
                            .setLngLat([data.vs[0].px,data.vs[0].py])
                            .addTo(map);
                            
                    }
                });*/
                /*
                map.addSource('pontos', {type: 'geojson'});
                map.addLayer({
                    "id": "pontos",
                    "type": "marker",
                    "source": "places",
                    "layout": {
                        "icon-imagem": "marker" + "-15",
                        "icon-allow-overlap": false
                    },
                    "filter": ["==", "icon", "marker"]
                });
                document.getElementById('option2').addEventListener('change',function(e){
                    map.setLayoutProperty("pontos",'visibility',
                        e.target.checked ? 'visible' : 'none');
                });*/
            });

            //https://www.mapbox.com/mapbox-gl-js/example/popup-on-click/
            map.on('click', 'paradas_layer', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = "Nome da parada: " + e.features[0].properties.stop_name + 
                                    "<br>" + e.features[0].properties.stop_desc;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });
            map.on('mouseenter', 'paradas_layer', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'paradas_layer', function () {
                map.getCanvas().style.cursor = '';
            });
            
            /*map.on('drag',function(){
                lnglat = map.getBounds();
                    console.log(lnglat);
                    var lng_sw = lnglat._sw.lng;
                    var lng_ne = lnglat._ne.lng;
                    var lat_sw = lnglat._sw.lat;
                    var lat_ne = lnglat._ne.lat;
                    console.log(lng_sw);
                    console.log(lng_ne);
                    console.log(lat_sw);
                    console.log(lat_ne);
                    $.ajax({
                    url:"busca_bd.php",
                    method:"POST",
                    data:{
                        'lng_sw': lng_sw,
                        'lat_sw': lat_sw,
                        'lng_ne': lng_ne,
                        'lat_ne': lat_ne
                    },
                    //dataType é o tipo de arquivo que estamos mandando
                    //dataType:"JSON",
                    cache: false,
                    //contentType: 'application/json; charset=utf-8',
                    success: function(data){
                        //Faz o parse do JSON.
                        var data_json = JSON.parse(data);
                        console.log(data_json);
                        var i = 0;
                        //https://stackoverflow.com/questions/33995648/cannot-use-in-operator-to-search-for-length?rq=1
                        $.each(data_json, function(){
                            console.log(data_json[i].stop_lon);
                            console.log(data_json[i].stop_lat);
                            var marker = new mapboxgl.Marker()
                                .setLngLat([data_json[i].stop_lon,data_json[i].stop_lat])
                                .addTo(map);
                            i++;
                        });
                    },
                    error: function(data, xhr, status, error){
                        console.log("Deu ruim");
                        console.log(data);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
                console.log("Plotei");
                //aqui deve puxar os pontos existentes nas proximidades
            });*/
        } 
    </script>
</body>
</html>