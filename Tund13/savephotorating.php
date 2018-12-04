<?php
require("../../../config.php");
$database="if18_Marianne_Ar_1";
session_start();

//siia saadetud parameetrid 
	$id = $_REQUEST["id"];
    $rating = $_REQUEST["rating"];
	
  $mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
  $stmt = $mysqli->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES (?, ?, ?)");
  echo $mysqli->error;
  $stmt->bind_param("iii", $id, $_SESSION["userId"], $rating);
  $stmt->execute();
  $stmt->close();
  
  //kesmine hinne
  $stmt=$mysqli->prepare("SELECT AVG(rating)FROM vpphotoratings WHERE photoid=?");
  $stmt->bind_param("i", $id);
  $stmt->bind_result($score);
  $stmt->execute();
  $stmt->fetch();
  
  $stmt->close();
  $mysqli->close();
  
  echo round($score, 2);


?>