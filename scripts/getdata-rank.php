<?php

$key = "YOUR_RIOT_API_KEY";

$riotID = $_GET['id'];



$ch = curl_init();

$url = "https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/$riotID?api_key=$key";

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
