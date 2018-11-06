<?php
  //echo "See on minu esimene PHP!";
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
  $monthNow = date("m");
  $monthNamesET = ["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember"];

	//var_dump($_POST);
	if (isset($_POST["firstName"])){
		$firstName = $_POST["firstName"];
	}
	if (isset($_POST["lastName"])){
		$lastName = $_POST["lastName"];
	}

	

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
  </title>
</head>
<body>
  <h1>
	<?php echo $firstName . " " .$lastName; ?>, IF18</h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi hea välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  
  <hr>
  
  <form method="POST">
  <label>Eesnimi:</label>
  <input type="text" name="firstName">
  <label>Perekonnanimi:</label>
  <input type="text" name="lastName">
  <label>Sünniaasta</label>
  <input type="number" min="1914" max="2000" value="1994" name="birtYear">
  <label>Sünnikuu</label>
  <select name="birthMonth">
  <option value="01"<?php if ($monthNow=='01') echo ' selected="selected"'; ?>>jaanuar</option>
  <option value="02"<?php if ($monthNow=='02') echo ' selected="selected"'; ?>>veebruar</option>
  <option value="03"<?php if ($monthNow=='03') echo ' selected="selected"'; ?>>märts</option>
  <option value="04"<?php if ($monthNow=='04') echo ' selected="selected"'; ?>>aprill</option>
  <option value="05"<?php if ($monthNow=='05') echo ' selected="selected"'; ?>>mai</option>
  <option value="06"<?php if ($monthNow=='06') echo ' selected="selected"'; ?>>juuni</option>
  <option value="07"<?php if ($monthNow=='07') echo ' selected="selected"'; ?>>juuli</option>
  <option value="08"<?php if ($monthNow=='08') echo ' selected="selected"'; ?>>august</option>
  <option value="09"<?php if ($monthNow=='09') echo ' selected="selected"'; ?>>september</option>
  <option value="10"<?php if ($monthNow=='10') echo ' selected="selected"'; ?>>oktoober</option>
  <option value="11"<?php if ($monthNow=='11') echo ' selected="selected"'; ?>>november</option>
  <option value="12"<?php if ($monthNow=='12') echo ' selected="selected"'; ?>>detsember</option>
    </select>  
  <br> 
  <input type="submit" name="submitUserData" value="Saada andmed">
  </form>
  <hr>
  <?php
  if (isset($_POST["firstName"])){
	echo "<p>Olete elanud järgnevatel aastatel: </p> \n";
	echo "<ol> \n";
		for ($i =$_POST["birtYear"]; $i <=date("Y"); $i ++){
			echo"<li>" .$i ."</li> \n";
		}
	echo "</ol> \n";

	}	
  ?>


</body>
</html>