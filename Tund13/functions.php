<?php

//laen andmebaasi info
require("../../../config.php");
//echo $GLOBALS["serverUsername"];

$database="if18_Marianne_Ar_1";


//võtan kasutusele sessiooni
session_start();


  function findTotalPrivateImages(){
	$privacy = 3;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM vpphotos WHERE privacy=? AND userid=? AND deleted IS NULL");
	$stmt->bind_param("ii", $privacy, $_SESSION["userId"]);
	$stmt->bind_result($imageCount);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	return $imageCount;  
  }

  function listmyprivatephotos($page, $limit){
    $html = "";
	$privacy = 3;
	$skip = ($page - 1) * $limit;
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy=? AND userid=? AND deleted IS NULL LIMIT ?,?");
    echo $mysqli->error;
    $stmt->bind_param("iiii", $privacy, $_SESSION["userId"], $skip, $limit);
    $stmt->bind_result($filenameFromDb, $alttextFromDb);
    $stmt->execute();
    while($stmt->fetch()){
      //<img src="kataloog/fail" alt="tekst">
      $html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="' .$alttextFromDb .'">' ."\n";
    }
    if(empty($html)){
      $html = "<p>Kahjuks privaatseid pilte pole!</p> \n";
    }
    $stmt->close();
	$mysqli->close();
    return $html;
  }

    function findTotalPublicImages(){
	$privacy = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($imageCount);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	return $imageCount;	
  }


  function listpublicphotospage($page, $limit){
    $html = "";
	$privacy = 1;
	$skip = ($page - 1) * $limit;
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT id, filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL LIMIT ?,?");
    echo $mysqli->error;
    $stmt->bind_param("iii", $privacy, $skip, $limit);
    $stmt->bind_result($idFromDb, $filenameFromDb, $alttextFromDb);
    $stmt->execute();
    while($stmt->fetch()){
      //<img src="kataloog/fail" alt="tekst" data-fn="failinimi">
      $html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="' .$alttextFromDb .'" data-fn="' .$filenameFromDb .'" data-id="' .$idFromDb .'">' ."\n";
    }
    if(empty($html)){
      $html = "<p>Kahjuks avalikke pilte pole!</p> \n";
    }
    $stmt->close();
	$mysqli->close();
    return $html;
  }
	

	function listpublicphotos($privacy){
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE id=(SELECT MAX(id) FROM vpphotos WHERE privacy=? AND deleted IS NULL");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		$html = '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
	}
	while($stmt->fetch()){
		$html .= '<img src="' .$GLOBALS["thumbDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">' ."\n";
	}
	if(empty($html)){
		$html="<p>Kahjuks pilte pole!</p>" ."\n";
	}
	$stmt->close();
	$mysqli->close();
	return $html;
  }
	
	

 function latestPicture($privacy){
	$html = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE id=(SELECT MAX(id) FROM vpphotos WHERE privacy=? AND deleted IS NULL)");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		$html = '<img src="' .$GLOBALS["picDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">';
	}
	
	$stmt->close();
	$mysqli->close();
	return $html;
  }


function addPhotoData($fileName, $altText, $privacy){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy)VALUES (?,?,?,?)");
	echo $mysqli->error;
	if(empty($privacy)){
		$privacy=3;
	}
	$stmt->bind_param("issi", $_SESSION["userId"], $fileName, $altText, $privacy);
	if($stmt->execute()){
		echo "Andmebaasiga on korras ";
	}else{
		echo "Andmebaasiga läks nihu ";
	}
	$stmt->close();
	$mysqli->close();
}

function resizeImage($image, $ow, $oh, $w, $h){
	$newImage=imagecreatetruecolor($w, $h);
	imagecopyresampled($newImage, $image,0, 0, 0, 0, $w, $h, $ow, $oh);
	return $newImage;
	
}

function readprofilecolors(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT txtcolor, bgcolor FROM vpuserprofiles WHERE user_ID=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($txtcolor, $bgcolor);
	$stmt->execute();
	$profile = new Stdclass();
	if($stmt->fetch()){
		$_SESSION["bgcolor"] = $bgcolor;
		$_SESSION["txtcolor"] = $txtcolor;
	} else {
		$_SESSION["bgcolor"] = "#FFFFFF";
		$_SESSION["txtcolor"] = "#000000";
	}
	$stmt->close();
	$mysqli->close();
  }
  
  //kasutajaprofiili salvestamine
  function storeuserprofile($desc, $txtcol, $bgcol){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, txtcolor, bgcolor FROM vpuserprofiles WHERE user_ID=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($description, $txtcolor, $bgcolor);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$stmt->close();
		$stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, txtcolor=?, bgcolor=? WHERE user_ID=?");
		echo $mysqli->error;
		$stmt->bind_param("sssi", $desc, $txtcol, $bgcol, $_SESSION["userId"]);
		if($stmt->execute()){
			$notice = "Profiil edukalt uuendatud!";
		    $_SESSION["txtcolor"] = $txtcol;
		    $_SESSION["bgcolor"] = $bgcol;
		} else {
			$notice = "Profiili uuendamisel tekkis tõrge! " .$stmt->error;
		}
	} else {
		//profiili pole, salvestame
		$stmt->close();
		$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (user_ID, description, txtcolor, bgcolor) VALUES(?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("isss", $_SESSION["userId"], $desc, $txtcol, $bgcol);
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
		    $_SESSION["txtcolor"] = $txtcol;
		    $_SESSION["bgcolor"] = $bgcol;
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  //kasutajaprofiili väljastamine
  function showmyprofile(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, txtcolor, bgcolor FROM vpuserprofiles WHERE user_ID=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($description, $txtcolor, $bgcolor);
	$stmt->execute();
	$profile = new Stdclass();
	if($stmt->fetch()){
		$profile->description = $description;
		$profile->txtcolor = $txtcolor;
		$profile->bgcolor = $bgcolor;
	} else {
		$profile->description = "";
		$profile->txtcolor = "";
		$profile->bgcolor = "";
	}
	$stmt->close();
	$mysqli->close();
	return $profile;
  }

//kasutajate profiilid
function description($message, $bgcolor, $textcolor){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt1 = $mysqli->prepare("SELECT user_ID, description, txtcolor, bgcolor FROM vpuserprofiles");
		echo $mysqli->error;
		$stmt2 ->bind_result($useridFromDb,$message,$textcolor,$bgcolor);
		
		if($stmt1->fetch()){
			$stmt2 = $mysqli->prepare("UPDATE description, txtcolor, bgcolor FROM vpuserprofiles VALUES(?,?,?)");
			echo $mysqli->error;
			$stmt2->bind_param("sss",$message,$textcolor,$bgcolor);
			if($stmt1->execute()){
				$notice = 'Kirjeldus: "'.$message.'" on uuendatud';
			}
		}else{
			$stmt2 = $mysqli->prepare("INSERT INTO vpuserprofiles(user_ID, description, txtcolor, bgcolor) VALUES(?,?,?,?)");
			echo $mysqli->error;
			$stmt2->bind_param("isss",$_SESSION["userId"],$message,$textcolor,$bgcolor);
			if($stmt2->execute()){
				$notice = 'Kirjeldus: "'.$message.'" on salvestatud';
			}
			$stmt1->close();
			$stmt2->close();
			$mysqli->close();
			return $notice;
			}		
	 }
/*function adduserprofile(){
	$asd="";
	$notice="";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("INSERT INTO vpuserprofiles(userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
	$stmt->execute();
	if ($stmt->execute()){
		$notice='profiil: "' .$asd. '" on salvestatud.';
	} else{
		$notice="profiili loomisel tekkis tõrge: ". $stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
}*/

 
  // kõigi valideeritud sõnumite lugemine kasutajate kaupa
  function readallvalidatedmessagesbyusers(){
	$msghtml = "";
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");
	echo $mysqli->error;
	 $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);

	 $stmt2=$mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acepptedby=?");
	 echo $mysqli->error;
	 $stmt2->bind_param("i", $idFromDb);
	 $stmt2->bind_result($msgFromDb, $acceptedFromDb);

	  $stmt->execute();
	  		 // et hoida andmebaasis loetud anmeid pisut kauem mälus, et saaks edasi kasutada.
		 $stmt->store_result();
		 $count=0;
	 while($stmt->fetch()){
		  $stmt2->execute();
		 while($stmt2->fetch()){
			 $count += 1;
			 $msghtml .="<p><b>";
			 if($acceptedFromDb== 1){
				 $msghtml .= "Lubatud";
			
			 } else {
				 $msghtml .="Keelatud";
			 }
			 $msghtml .= "</b>" .$msgFromDb ." </p> \n";
			  
			 }
			 if ($count > 0){
			 $msghtml .= "<h3>" .$firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
			 }
			 
		 }
  
		 
	 $stmt2->close();
	 $stmt->close();
	 $mysqli->close();
	 return $msghtml;
  
	}

//kasutajate nimekiri
  function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id !=?");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function allvalidmessages(){
	$html = "";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=? ORDER BY accepttime DESC");
	echo $mysqli->error;
	$stmt->bind_param("i", $valid);
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Kontrollitud sõnumeid pole.</p>";
	}
	return $html;
  }
  
  function validatemsg($editId, $validation){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET aceptedby=?, accepted=?, accepttime=now() WHERE id=?");
	$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: validatemsg.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }

//loen sõnumi valideerimiseks
  function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }

//valideerimata sõnumite lugemine
  function readallunvalidatedmessages(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC");
	echo $mysqli->error;
	$stmt->bind_result($id, $msg);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
	}
	$notice.="</ul>\n";
	$stmt->close();
	$mysqli->close();
	return $notice;
  }



//tekstsisestuse kontroll
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	
}

function saveamsg($msg) {
	$notice="";
	//serveriühendus(server, kasutaja, parool, andmebaas)
	$mysqli=new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistan ette SQL käsu
	$stmt=$mysqli->prepare("INSERT INTO vpamsg(message) VALUES(?)");
	echo $mysqli->error;
	//asendame SQL käsus küsimärgi päris infoga(andmetüüp, andmed ise)
	//s-string, i-integer, d-decimal
	$stmt->bind_param("s", $msg);
	if ($stmt->execute()){
		$notice='sõnum: "' .$msg. '" on salvestatud.';
	} else{
		$notice="sõnumi salvestamisel tekkis tõrge: ". $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
	
}

function listallmessages(){
	$msgHTML="";
	$mysqli=new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	$stmt->fetch();
	while($stmt->fetch()){
	$msgHTML.="<p>".$msg."</p>\n";

	}
	$stmt->close();
	$mysqli->close();
	return $msgHTML;	
	
}

function addcat($catname, $catcolor,$catlength){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kiisu(nimi, v2rv, saba) VALUES(?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $catname,$catcolor,$catlength);
		$stmt->execute();
		$stmt->close();
	}
		
function showcats(){
		 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT * FROM kiisu");
		$id = "";
		$name = "";
		$color = "";
		$tail_length = "";
		$stmt-> bind_result($id, $name,$color,$tail_length);
		$stmt -> execute();
		while($stmt->fetch()) {
        $cats[] = [
            'id_kiisu' => $id,
            'nimi' => $name,
            'v2rv' => $color,
            'saba' => $tail_length];
		}
		$stmt->close();
		return $cats;
	
	}

	function signup($firstName, $lastName, $birthDate, $gender, $email, $password){
		$notice="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers(firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//valmistame parooli ette salvestamiseks, krüpteerime, teeme räsi(hash)
		$options=[
		"cost"=>12,
		"salt"=>substr(sha1(rand()), 0, 22),];
		$pwdhash=password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice="Uue kasutaja lisamine õnnestus";
		}else{
			$notice="Kasutaja lisamisel tekkis viga: ". $stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	//sisselogimine
	function signin($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
		$mysqli->error;
		$stmt->bind_param("s",$email);
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		if($stmt->execute()){
			//kui õnnestus andmebaasi lugemine
			if($stmt->fetch()){
				//kasutaja leiti, kontrollime parooli
				if(password_verify($password, $passwordFromDb)){
					//parool õige
					$notice="Sisselogimine õnnestus!";
					$_SESSION["userId"]=$idFromDb;
					$_SESSION["firstName"]=$firstnameFromDb;
					$_SESSION["lastName"]=$lastnameFromDb;
					$stmt->close();
					$mysqli->close();
					header("Location: main.php");
					exit();
				}else{
					$notice = "Vale parool!";
				}
			}else{
				$notice="Sellist kasutajat (".$email.") ei leitud!";
			}
		} else {
		$notice = "Tekkis tehniline viga".$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice; 
	 }
	
?>