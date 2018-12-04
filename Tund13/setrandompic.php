<?php
require("../../../config.php");
$database="if18_Marianne_Ar_1";

 $privacy = 2;
 $limit = 10;
 $photoList = [];
 $html = NULL;
 
 $mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
 $stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?");
 echo $mysqli->error;
 $stmt->bind_param("ii", $privacy, $limit);
 $stmt->bind_result($fileNameFromDB, $alttextFromDB);
 $stmt->execute();
 while($stmt->fetch()){
	 $myPhoto = new Stdclass();
	 $myPhoto-> filename = $fileNameFromDB;
	 $myPhoto-> alttext = $alttextFromDB;
	 array_push($photoList, $myPhoto);
 }
 $picCount = count($photoList);
 $picNum = mt_rand(0, $picCount -1);
 $html = '<img src="'.$picDir .$photoList[$picNum]->filename .'" alt="' .$photoList[$picNum]->alttext .'">' ."\n";
 
 
$stmt->close();
$mysqli->close();
echo $html;
?>