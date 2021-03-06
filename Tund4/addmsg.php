<?php
	//kutsume välja funktsioonide faili
	require("functions.php");
	
	$notice = null;
	
	if (isset($_POST["submitMessage"])){
		if ($_POST["message"]!="Siia sisesta oma sõnum..." and !empty($_POST["message"])){
			$message = test_input($_POST["message"]);
			$notice = saveamsg($message);
		} else {
			$notice = "Palun kirjuta sõnum";
		}
				
	}
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sõnum</title>
</head>
<body>
  <h1>Sõnumi lisamine</h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi hea välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label>Sõnum(max 265 märki):</label>
  <textarea rows="4" cols="64" name="message">Siia sisesta oma sõnum...</textarea>
  <br>
  <input type="submit" name="submitMessage" value="Salvesta sõnum">
  </form>
  <hr>
  <p><?php echo $notice; ?></p>


</body>
</html>