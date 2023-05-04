<?php

require '../includes/dbh.inc.php';
session_start();

$uid = $_SESSION['userId'];

$key = "RGAPI-4e509688-1590-4046-b9e8-b2ca6608f79b";

$riotID = $_GET['id'];
$sumname = $_GET['sn'];
$code = $_GET['code'];

$sumanameCaps = strtoupper($sumname);

$ch = curl_init();

$url = "https://euw1.api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/$riotID?api_key=$key";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if ( curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404 || curl_error($ch)){
  $arr = array('status' => 0);
  echo json_encode($arr);
  curl_close($ch);
  //http_response_code(404);
}else {
  $resp2 = str_replace("\"","",$resp);
  //Ler base de dados e verificar se o codigo que o cliente tem é o mesmo que $resp
  if ($code !== $resp2) {
    $arr = array('status' => 1, 'third-party-code' => str_replace("\"","",$resp));
    echo json_encode($arr);
    curl_close($ch);
  }else {

  
    $arr = array('status' => 2, 'third-party-code' => str_replace("\"","",$resp));
    echo json_encode($arr);
    curl_close($ch);
  }
  // se for igual meter na base de dados que esta confirmado
  // enviar esta resposta (status 1 = ta tudo fixe)
  // se nao for igual, enviar status 0, 0= nao ta fixe.
}
?>
