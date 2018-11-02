<?php 
    $url = "$sptrans/LoginAutenticar?token=$token";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
    $retorno = curl_exec($ch);
    preg_match_all(expressaoregular);
    $cookie = $matches[1][0];
    //cookie foi pego nesta area
    print_r ($cookie);  
    curl_close($ch);
          
    $ch = curl_init("$sptrans/Linha/Buscar?termosBusca=8000");
    curl_setopt($ch, CURLOPT_GET,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    $ret = curl_exec($ch);
?>