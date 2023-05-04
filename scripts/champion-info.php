<?php

$key = "RGAPI-4e509688-1590-4046-b9e8-b2ca6608f79b";

$summonernameC = "7SwWseNUGYHE_nTVib8TStQSTkZxGd64MkXwNJ0ib2TGW8o";

$ch = curl_init();

$url = "http://ddragon.leagueoflegends.com/cdn/12.3.1/data/en_US/champion.json";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if ($e = curl_error($ch)) {
  echo $e;
}else {
  $decoded = json_decode($resp, true);

  

  echo $resp;

}



curl_close($ch);













?>
