<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grupo 5</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height, user-scalable=yes">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <script src='modernizr-custom.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
    <?php
        // Chave da SPTrans Token: 7f96df5745202fffb684b3810dcc7078c0f4184b7af2a1834b065ac28b007aa2
        require "../../vendor/autoload.php";
        /**
        *require "vendor/autoload.php";
    *$token = 'token aqui';
    *$sptrans= 
    *$client = new GuzzleHttp\Client();
    *$res = $client->request("POST", "sptrans/LoginAutenticar?token=$token");
    *echo $res->getStatusCode(), "<p>";
    *$cookie =- $res->getHeader("Set-Cookie")[0];
    * cookie soh vem pelo browser, nao se o programa dentro do servidor fizer a requisicao

    *$res = $client->request("GET","$sptrans/linha/Buscar?termosBusca=8000,{"headers" => [
        *'Cookie: $cookie'
        *]
        *});
        *echo $res->getBody();

        *mandar o cookie de volta para poder ser feita a consulta
     
        * podemos fazer também com cUrl
        *$url = "$sptrans/LoginAutenticar?token=$token";
        *$ch = curl_init($url);
        *curl_setopt($ch, CURLOPT_POST,1);
        *curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        *curl_setopt($ch, CURLOPT_HEADER, 1);
        *curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        *$retorno = curl_exec($ch);
        *preg_match_all(expressaoregular);
        *$cookie = $matches[1][0];
        *print_r ($cookie);  cookie foi pego nesta area
        *curl_close($ch);
        *
        * Fazendo conexao agora com para GET da linha 8000
        * 
        *$ch = curl_init("$sptrans/Linha/Buscar?termosBusca=8000");
        *curl_setopt($ch, CURLOPT_GET,1);
        *curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        *curl_setopt($ch, CURLOPT_HEADER, 1);
        *curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        *$ret = curl_exec($ch);
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
    <div id='map' style='width: 100%; height: 100%;'></div>
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

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/fernando-kga/cjmecq5bqea3l2rp07iyhzo90',
                //center: [-46.631,-23.554],
                center: [long, lat],
                zoom: 13.0,
            });

            map.addControl(geolocate);
            map.addControl(navegacao, 'top-right');
            map.scrollZoom.enable({around: 'center'});
            map.on('load', function(){
                geolocate.trigger();
            })
        }
        
    </script>
</body>
</html>