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
            <input type="checkbox" name="option1" value="onibus">Ônibus em movimento
            <input type="checkbox" name="option2" value="paradas">Paradas de ônibus
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

            map.addControl(geolocate);
            map.addControl(navegacao, 'top-right');
            map.scrollZoom.enable({around: 'center'});
            map.addControl(escala);
            // disable map rotation using right click + drag
            map.dragRotate.disable();
            // disable map rotation using touch rotation gesture
            map.touchZoomRotate.disableRotation();
            map.on('load', function(){
                geolocate.trigger();
                zoom = map.getZoom();
                console.log(zoom);
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
                    dataType:"JSON",
                    cache: false,
                    success: function(data){
                        console.log(data_parsed);
                        $.each(data, function(){
                                console.log(data.stop_lon);
                                console.log(data.stop_lat);
                                var marker = new mapboxgl.Marker()
                                .setLngLat([data.stop_lon,data.stop_lat])
                                .addTo(map);
                            
                        });
                    },
                    error: function(xhr, status, error){
                        console.log("Deu ruim");
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
                /*$.ajax("busca_bd.php").fail(function(jqXHR, textStatus){
                    alert("Ativou fail: "+textStatus);
                })*/
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
            map.on('click',function(e){
                //Preste atencao no nome da variavel
                console.log(e.lngLat);
                
            });
            /*map.on('drag',function(){
                lnglat = map.getBounds();
                //var marker1 = new mapboxgl.Marker().setLngLat([lnglat._ne.lng,lnglat._ne.lat]).addTo(map);
                //var marker2 = new mapboxgl.Marker().setLngLat([lnglat._sw.lng,lnglat._sw.lat]).addTo(map);
                console.log("Plotei");
                //aqui deve puxar os pontos existentes nas proximidades
            });*/
        } 
    </script>
</body>
</html>