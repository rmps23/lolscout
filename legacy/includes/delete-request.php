<?php
require 'dbh.inc.php';

$sql = "DELETE FROM pwdreset WHERE `timestamp` < (NOW() - INTERVAL 2 MINUTE);";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();


 ?>
