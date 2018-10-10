<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grupo 5</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height, user-scalable=yes">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.js'></script>
    <script src='modernizr-custom.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
    <?php
        // Chave da SPTrans Token: 7f96df5745202fffb684b3810dcc7078c0f4184b7af2a1834b065ac28b007aa2
        /**
         *require "vendor/autoload.php
    *$token = 'token aqui';
    *$sptrans= 
    *$client = new GuzzleHttp\Client();
    *$res = $client->request("POST", "sptrans/LoginAutenticar?token=$token");
    *echo $res->getStatusCode(), "algo";

    *$res = $client->request("GET","$sptrans/linha/Buscar?termosBusca=8000,{"headers" => ['Cookie: $cookie']});
         */
    ?>
    <div class="cabeca">
        Endereço:
        <div class = "pesquisa"><input type= "text" placeholder = "Pesquise"><input type="submit" value="OK"></div>
        <!-- Os inputs para serem sequenciais devem estar -->
        <input type="checkbox" name="option1" value="onibus">Ônibus em movimento<input type="checkbox" name="option2" value="paradas">Paradas de ônibus
        <div class="grupo">
            <ul style="list-style-type:none;">
                <li>Fernando Karchiloff Gouveia de Amorim</li>
                <li>Fernanda Inácio</li>
                <li>Mara Tamiris</li>
                <li>Lucas Ken</li>
            </ul>
        </div>
    </div>
    <div id='map'></div>
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
            
            /*
            mapboxgl.accessToken = 'pk.eyJ1IjoiZmVybmFuZG8ta2dhIiwiYSI6ImNqbTlpcnMxbDAwMGMzcG9nNmtldWlmYWQifQ.O4LmFPbru9U4X10QHhv1kQ';
        
            var geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
            enableHighAccuracy: true
            },
            trackUserLocation: true
            });

            var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/fernando-kga/cjmecq5bqea3l2rp07iyhzo90',
            center: [-46.631,-23.554],
            zoom: 13.0,
            });
            map.addControl(geolocate);
            map.scrollZoom.enable({around: 'center'});
            map.trigger();
            */
            alert("Relaxa que o mapa funciona! Removido para testes.");
        }
        
    </script>
</body>
</html>