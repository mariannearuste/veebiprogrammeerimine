<?php
	//laen andmebaasi info 
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_Marianne_Ar_1";
	
	//anonüümse sõnumi salvestamine
	function saveamsg($msg){
		$notice = "";
		//serveri ühendus (server,kasutaja, parool,andmebaas
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistan ette SQl käsu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		//asendame sql käsus ? päris infoga (andmetüüp,andmed ise)
		// s-string i-integer d-decimal(murdarv)
		$stmt->bind_param("s", $msg);
		if ($stmt->execute()){
			$notice = 'Sõnum: "'.$msg .'" on salvestatud.';
		} else {
		$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function listallmessages(){
		$msgHTML = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$msgHTML .="<P>" .$msg ."<p/> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $msgHTML;
	
	}
	
	
	//tekstsisestuse kontroll
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	//kiisud

	function addcat ($catname, $catcolor, $cattaillength){
	//echo "Töötab";
	$notice = ""; //see on teade mis antakse salvestamise kohta
	//loome ühenduse serveriga
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistame ette sql päringu
	$stmt = $mysqli->prepare("INSERT INTO kassid (nimi, v2rv, saba) VALUES(?, ?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("ssi", $catname, $catcolor, $cattaillength);//s-string, i-integer, d-decimal,
	if ($stmt->execute()){
		$notice = 'Kiisu: "' .$catname . '" andmed on salvestatud!';
	}else{
		$notice = "Sõnumi salvestamisel tekkis tõrge: " . $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
	}

	function listallcats(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT nimi, v2rv, saba FROM kassid");
		echo $mysqli->error;
		$stmt->bind_result($readcatname, $readcatcolor, $readcattaillength);
		$stmt->execute();
		while ($stmt->fetch()){
			$notice .="<li>" .$readcatname ."," ." " .$readcatcolor ."," ." " .$readcattaillength ."</li> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
		}


?>