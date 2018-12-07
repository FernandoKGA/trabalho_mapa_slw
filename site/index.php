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
    <!-- Script para o jQuery --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Script da API-->
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <!--<script src='modernizr-custom.js'></script>-->
    <!-- CSS da API -->
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
    <div class="cabeca">
        <!-- Os inputs para serem sequenciais devem estar -->
        <!--<nav id="opcoes_um" class="opcoes_um">
            <input type="checkbox" id="onibus" value="onibus" disabled>
            <label for="onibus">Ônibus em movimento</label>
        </nav>
        <nav id="opcoes_dois" class="opcoes_dois">
            <input type="checkbox" name="paradas" value="paradas">
            <label for="paradas">Paradas de ônibus</label>
        </nav>-->
        <nav id='filter-group' class='filter-group'></nav>
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

        var load_error;
        
        /*
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
            //Pega as coordenadas assim que aceita a condição
            var lat = pos.coords.latitude;  
            var long = pos.coords.longitude;
        }*/
            /*
                Manter comentado para não gastar a API do Mapa que possui limite.
            */

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

            //https://www.mapbox.com/mapbox-gl-js/example/mapbox-gl-geocoder-limit-region/
            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                country: "br",
                /*
                    https://www.mapbox.com/help/define-bounding-box/
                    First coordinate pair referring to the southwestern corner of the box
                    and the second referring to the northeastern corner of the box.
                */
                bbox: [-47.453161643012265,-24.367569297823536,-45.86680880351264,-23.037950298414103]
            });

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/fernando-kga/cjmecq5bqea3l2rp07iyhzo90',
                center: [-46.628,-23.552],
                zoom: 15.0
            });

            var zoom;
            var lnglat;
            var userlocation;

            //https://www.mapbox.com/mapbox-gl-js/example/mapbox-gl-geocoder/
            map.addControl(geocoder);

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
            if(!UrlExists("http://localhost/trabalho_slw/geojson_paradas.json")){
                $.ajax({
                    url:"cria_geojson_paradas.php",
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

            //Pega o grupo de filtros
            var filterGroup = document.getElementById('filter-group');

            //Fazer funcoes assim que o mapa estiver carregando.
            map.on('load', function(){

                //Vai carregar o GeoJSON
                if(load_error){
                    console.log("Carregando sources.");
                    var loaded = false;
                    var geojson;
                    //Fara um POST para pegar o GeoJSON no diretorio.
                    $.ajax({
                        url:"http://localhost/trabalho_slw/geojson_paradas.json",
                        method:"POST",
                        cache: true,
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
                        //https://www.mapbox.com/mapbox-gl-js/api/#map#addsource
                        map.addSource("paradas",{
                            "type": "geojson",
                            "data": geojson  //"http://localhost/trabalho_slw/geojson.json"
                        });

                        //https://www.mapbox.com/maki-icons/

                        //https://www.mapbox.com/mapbox-gl-js/api/#map#addlayer
                        //https://www.mapbox.com/mapbox-gl-js/style-spec/#layers
                        map.addLayer({
                            "id": "paradas_layer",
                            "type": "symbol",
                            "source": "paradas",
                            "layout": {
                                "icon-image": "square-15",
                                "icon-allow-overlap": false,
                                "visibility": "none"
                            }
                        });
                        /*
                        places.features.forEach(function(feature) {
                            var symbol = feature.properties['icon'];
                            var layerID = 'poi-' + symbol;

                            // Add a layer for this symbol type if it hasn't been added already.
                            if (!map.getLayer(layerID)) {
                                map.addLayer({
                                    "id": layerID,
                                    "type": "symbol",
                                    "source": "places",
                                    "layout": {
                                        "icon-image": symbol + "-15",
                                        "icon-allow-overlap": true
                                    },
                                    "filter": ["==", "icon", symbol]
                                });

                                // Add checkbox and label elements for the layer.
                                var input = document.createElement('input');
                                input.type = 'checkbox';
                                input.id = layerID;
                                input.checked = true;
                                filterGroup.appendChild(input);

                                var label = document.createElement('label');
                                label.setAttribute('for', layerID);
                                label.textContent = symbol;
                                filterGroup.appendChild(label);

                                // When the checkbox changes, update the visibility of the layer.
                                input.addEventListener('change', function(e) {
                                    map.setLayoutProperty(layerID, 'visibility',
                                        e.target.checked ? 'visible' : 'none');
                                });
                            }
                        });*/
                        if(map.getLayer('paradas_layer')){
                            var input = document.createElement('input');
                            input.type = 'checkbox';
                            input.id = 'paradas_layer';
                            input.checked = false;
                            filterGroup.appendChild(input);

                            var label = document.createElement('label');
                            label.setAttribute('for', 'paradas_layer');
                            label.textContent = 'Paradas de ônibus';
                            filterGroup.appendChild(label);

                            //https://www.mapbox.com/mapbox-gl-js/example/toggle-interaction-handlers/
                            input.addEventListener('change', function(e) {
                                    map.setLayoutProperty('paradas_layer', 'visibility',
                                        e.target.checked ? 'visible' : 'none');
                            });
                        }
                        else{
                            console.log("Problemas em pegar layer de paradas!");
                        }
                    }
                    else{
                        console.log("Problema ao carregar GeoJSON! Verifique!");
                    }
                }

                var loaded_onibus;

                //Tentar carregar os ônibus
                console.log("Carregando sources dos ônibus.");
                    //Fara um GET para pegar os ônbius em movimento.
                $.ajax({
                    url:"http://localhost/trabalho_slw/busca_onibus.php",
                    method:"POST",
                    cache: false,
                    async: false,
                    /*data:{
                        'lng_centro': lng_centro,
                        'lat_centro': lat_centro,
                        'raio': raio
                    }*/
                    success: function(data){
                        console.log("Carregado!");
                        onibus_em_mov = data;
                        loaded_onibus = true;
                    },
                    error: function(data, xhr, status, error){
                        console.log("Deu ruim! :(");
                        console.log(data);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        loaded_onibus = false;
                    }
                });
                /*
                //Verifica se os onibus foram carregados.
                if(loaded_onibus){
                    //https://www.mapbox.com/mapbox-gl-js/api/#map#addsource
                    //https://www.mapbox.com/mapbox-gl-js/style-spec/#sources
                    map.addSource("onibus",{
                        "type": "geojson",
                        "data": onibus_em_mov  //"http://localhost/trabalho_slw/busca_onibus.php"
                    });

                    //https://www.mapbox.com/maki-icons/

                    //https://www.mapbox.com/mapbox-gl-js/api/#map#addlayer
                    //https://www.mapbox.com/mapbox-gl-js/style-spec/#layers
                    map.addLayer({
                        "id": "onibus_layer",
                        "type": "symbol",
                        "source": "onibus",
                        "layout": {
                            "icon-image": "bus-15",
                            "icon-allow-overlap": false,
                            "visibility": "none"
                        }
                    });

                    //https://www.mapbox.com/mapbox-gl-js/example/toggle-interaction-handlers/
                    if(map.getLayer('paradas_layer')){
                        var input = document.createElement('input');
                        input.type = 'checkbox';
                        input.id = 'paradas_layer';
                        input.checked = false;
                        filterGroup.appendChild(input);

                        var label = document.createElement('label');
                        label.setAttribute('for', 'paradas_layer');
                        label.textContent = 'Paradas de ônibus';
                        filterGroup.appendChild(label);

                        input.addEventListener('change', function(e) {
                                map.setLayoutProperty('paradas_layer', 'visibility',
                                    e.target.checked ? 'visible' : 'none');
                        });
                    }
                    else{
                        console.log("Problemas em pegar layer de paradas!");
                    }                    
                }
                else{
                    console.log("Problema ao carregar os ônibus! Verifique!");
                }*/
                geolocate.trigger();
                zoom = map.getZoom();
                console.log(zoom);

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
                
            });

            //https://www.mapbox.com/mapbox-gl-js/example/popup-on-click/
            /*map.on('click', 'paradas_layer', function (e) {
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
            });*/
            map.on('mouseenter', 'paradas_layer', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'paradas_layer', function () {
                map.getCanvas().style.cursor = '';
            });

            /*map.on('click', function(e){
                console.log("Lat:"+e.lngLat.lat);
                console.log("Lon:"+e.lngLat.lng);
            });*/

            map.on('zoom', function(){
                console.log(map.getZoom());
            });
            
            /**
            //Função que irá mandar uma requisição de atualização para o arquivo GeoJSON dos ônibus
            setInterval(function(),2MIN); 
            */
            /* 
            Fórmulas para calcular zoom e tal.
            https://math.stackexchange.com/questions/1836802/formula-to-map-any-given-point-on-circumference-of-circle-with-given-radius
            https://www.mapbox.com/search-playground/#{%22url%22:%22%22,%22index%22:%22mapbox.places%22,%22staging%22:false,%22onCountry%22:true,%22onType%22:true,%22onProximity%22:true,%22onBBOX%22:true,%22onLimit%22:true,%22onLanguage%22:true,%22countries%22:[],%22proximity%22:%22%22,%22typeToggle%22:{%22country%22:false,%22region%22:false,%22district%22:false,%22postcode%22:false,%22locality%22:false,%22place%22:false,%22neighborhood%22:false,%22address%22:false,%22poi%22:false},%22types%22:[],%22bbox%22:%22%22,%22limit%22:%22%22,%22autocomplete%22:true,%22languages%22:[],%22languageStrict%22:false,%22onDebug%22:false,%22selectedLayer%22:%22%22,%22debugClick%22:{},%22query%22:%22-46.501984170297476,-23.4935040978838%22}
            
            */


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
            });*/
    </script>
</body>
</html>