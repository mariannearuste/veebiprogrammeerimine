<?php
  //kutsume välja funktsioonide faili
  require("functions.php");
	$firstName = "";
	$lastName = "";
  $monthNow = date("m");
  $monthNamesET = ["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember"];
  $birthMonth = "null";
  $birthYear = "null";
  $birthDate = "null";
  $birthDay = "null";
  $gender = "";
  $email = "";
  $notice = "";
  //$password = "";
  
  
	$firstNameError = "";
	$lastNameError = "";
	$birthMonthError = "";
	$birthYearError = "";
	$birthDateError = "";
	$birthDayError = "";
	$genderError = "";
	$emailError = "";
	$passwordError = "";

	//var_dump($_POST);
	//kontrollime ka skasutaja on nuppu vajutanud
	if (isset ($_POST["submitUserData"])){
		
	if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		$firstName = test_input($_POST["firstName"]);

	} else {
		$firstNameError = "Palun sisesta oma eesnimi!";
	
	}
	if (isset($_POST["lastName"]) and !empty($_POST["lastName"])){
		$lastName = test_input($_POST["lastName"]);

	} else {
		$lastNameError = "Palun sisesta oma perekonnanimi!";
	
	}
	if (isset($_POST["email"]) and !empty($_POST["email"])){
	$email = test_input($_POST["email"]);

	} else {
		$emailError = "Palun sisesta oma e-mail!";
	
	}
	// NB! NB! NB! nii on vaja teha kõikide muutujatega
	if (isset($_POST["lastName"])){
		$lastName = $_POST["lastName"];
	}
	
	if (isset($_POST["gender"]) and !empty($_POST["gender"])){
		$gender = intval($_POST["gender"]); //integer value, eraldab tekstist kättesaadava arvväärtuse 
	} else {
		$genderError = "Palun määra sugu";
	}
	//kui päev ja kuu ja aasta on olemas, konrollitud
	//võiks ju kontrollida kas kuupäevadega seotud error muutujad on endiselt tühjad
	if(isset($_POST["birthDay"]) and !empty($_POST["birthMonth"])and !empty($_POST["birthYear"])){
		//kas oodatav kuupäev on üldse võimalik
		//checkdate kuu, päev, aasta - täisarvus
		if (checkdate(intval($_POST["birthMonth"]), intval($_POST["birthDay"]), intval($_POST["birthYear"]))){
			$birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
			$birthDate = date_format($birthDate, "Y-m-d");
			//echo $birthDate;
		} else {
			$birthDateError = "Palun vali võimalik kuupäev";
		}
	}
	//kui kõik on korras siis salvestan kasutaja
	if(empty($firstNameError) and empty($birthMonthError)and empty($lastNameError)and empty($birthYearError)and empty($birthDateError)and empty($birthDayError)and empty($genderError)and empty($emailError)and empty($passwordError)){
		
		$notice = signup($firstName, $lastName, $birthDate, $gender, $email, $_POST["password"]);	
	}


		
	}//kas vajutai nuppu - lõpp
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Andmed</title>
</head>
<body>
  <h1>
	Sisesta oma andmed, loo kasutaja</h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi hea välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  
  <hr>
  
 
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Eesnimi:</label><br>
	  <input type="text" name="firstName" value="<?php echo $firstName; ?>" ><span><?php echo $firstNameError; ?></span><br>
	  <label>Perekonnanimi:</label><br>
	  <input type="text" name="lastName" value="<?php echo $lastName; ?>" ><span><?php echo $lastNameError; ?></span><br>
	  <label>Sünnipäev: </label><br>
	  <?php
	    echo '<select name="birthDay">' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthDay){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	   <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	<label>Sünniaasta: </label>
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthYear">' ."\n";
		for ($i = date("Y"); $i - 15; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	<br>
	<input type="radio" name="gender" value="2" <?php if ($gender == 2) {echo "checked";}?>><label>Naine</label><br> 
	<input type="radio" name="gender" value="1" <?php if ($gender == 1) {echo "checked";}?>><label>Mees</label><br>
	<span><?php echo $firstNameError; ?></span>
	
	<br>
	
	<label>E-posti aadress kasutajatunnuseks:</label><br>
	<input name="email" type="email" <span><?php echo $emailError; ?></span><br>
	
	<label>Salasõna (8 tähemärki)</label><br>
	<input name="password" type="password"><br>
	
	<br> 
	<input type="submit" name="submitUserData" value="Loo kasutaja">
	</form>
	<hr>
	<p><?php echo $notice; ?></p>
  
  
</body>
</html>