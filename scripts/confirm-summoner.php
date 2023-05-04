<?php

$key = "RGAPI-4e509688-1590-4046-b9e8-b2ca6608f79b";

$summonernameC = $_GET['id'];

$ch = curl_init();

$url = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/$summonernameC?api_key=$key";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if ($e = curl_error($ch)) {
  echo $e;
}else {
  $decoded = json_decode($resp, true);

  $riotID = $decoded['id'];


  echo $resp;

}



curl_close($ch);













?>
