<?php
session_start();

$servername = "sql306.epizy.com";
$dbUsername = "epiz_29539832";
$dbPassword = "U3T5yxyTI3hjwxv";
$dbName = "epiz_29539832_lolscout";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}
