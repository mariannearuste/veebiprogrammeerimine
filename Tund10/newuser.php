<?php
//kutsume välja funktsioonide faili
require("functions.php");
  $firstName = "";
  $lastName = "";
  $birthMonth=null;
  $birthYear=null;
  $birthDay=null;
  $birthDate=null;
  $gender=null;
  $email="";
  $notice="";
  
  $firstNameError = "";
  $lastNameError = "";
  $birthMonthError="";
  $birthYearError="";
  $birthDayError="";
  $birthDateError="";
  $genderError="";
  $emailError="";
  $passwordError="";
  $confirmpasswordError="";
  
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //kontrollime, kas kasutaja on nuppu vajutanud
  if(isset($_POST["submitUserData"])){
	  
  
  //var_dump($_POST);
  if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
	  //$firstName = $_POST["firstName"];
	  $firstName=test_input($_POST["firstName"]);
  }else{
	  $firstNameError = "Palun sisesta oma eesnimi ";
	  
  }
  
  if (isset($_POST["lastName"])and !empty($_POST["lastName"])){
	  $lastName=test_input($_POST["lastName"]);
  }else{
	  $lastNameError = "Palun sisesta oma perekonnanimi ";
  }
  
  if (isset($_POST["gender"])and !empty($_POST["gender"])){
	  $gender=intval($_POST["gender"]);
  }else{
	  $genderError = "Palun määra oma sugu";
  }
  if(isset($_POST["email"])and !empty($_POST["email"])) {
	 $email = $_POST["email"];
 }else{
	 $emailError = "Palun sisesta oma email";
 }
  if(isset($_POST["password"])and !empty($_POST["password"] and strlen($_POST["password"])>=8)) {
	 $password	= $_POST["password"];
 }else{
	 $passwordError = "Parool peaks olema vähemalt 8 tähte";
 }

 

  //kui päev kuu ja aasta on olemas ja kontrollitud
  //võiks ju hoopis kontrollida, kas kuupäevadega seotud error muutujad on endiselt tühjad
  if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"])){
	  //kas oodatav kuupäev on üldse võimalik
	  //checkdate(kuu,päev,aasta) tahab täisarve
	  if(checkdate(intval($_POST["birthMonth"]), intval($_POST["birthDay"]), intval($_POST["birthYear"]))){
		  //kui on võimalik, teeme kuupäevaks
		  $birthDate=date_create($_POST["birthMonth"]."/".$_POST["birthDay"]."/".$_POST["birthYear"]);
		  $birthDate=date_format($birthDate, "Y-m-d");
		  //echo $birthDate;
	  }else{
		  $birthDateError="Palun vali võimalik kuupäev";
	  }
  }
  
  //kui kõik korras, siis salvestan kasutaja
  if(empty($firstNameError) and empty($lastNameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($birthDateError) and empty($genderError) and empty($emailError) and empty($passwordError) and empty($confirmpasswordError)){
	  $notice=signup($firstName, $lastName, $birthDate, $gender, $_POST["email"], $_POST["password"]);
	  
  }
  
  }//kas vajutati nuppu lõpp
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
	  <?php
	    echo $firstName;
		echo " ";
		echo $lastName;
	  ?>
	, õppetöö</title>
</head>
<body style="font-family:comic sans ms;">

	<h1>
	  <?php
	    echo $firstName ." " .$lastName;
	  ?>, IF18</h1>
	
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Eesnimi:</label><br>
	  <input type="text" name="firstName" value="<?php echo $firstName;?>"><span><?php echo $firstNameError;?></span><br>
	  <label>Perekonnanimi:</label><br>
	  <input type="text" name="lastName" value="<?php echo $lastName;?>"><span><?php echo $lastNameError;?></span><br>
	  <label>Sünnipäev: </label>
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
		for ($i = date("Y")-15; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  
	 <br>
	 
	 <input type="radio" name="gender" value="2" <?php if ($gender==2){echo "checked";}?>><label>Naine</label>
	 <input type="radio" name="gender" value="1" <?php if ($gender==1){echo "checked";}?>><label>Mees</label>
	 <span><?php echo $genderError;?></span><br>
	 <label>E-postiaadress (kasutajatunnuseks) </label><input name="email" type="email">
	 <?php echo $emailError;?>
	 <br>
	 <label>Salasõna (min 8 märki) </label><input name="password" type="password"><br>
	 <label>Salasõna uuesti </label><input name="confirmpassword" type="password">
	 <?php echo $passwordError;?>
	 <?php echo $confirmpasswordError;?>
	 <br>
	 <input type="submit" name="submitUserData" value="Loo kasutaja">
    </form>
	<hr>
	<p><?php echo $notice;?> </p>
	<p><a href="main.php">Tagasi pealehele</a></p>
	
	
</body>
</html>