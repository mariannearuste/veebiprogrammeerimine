<?php
  //kutsume välja funktsioonide faili
require("functions.php");
 
$notice=null;
 
  if (isset($_POST["submitMessage"])){
  if ($_POST["message"] !="sisesta siia oma sõnum: " and !empty($_POST["message"])){
	  $message=test_input($_POST["message"]);
	  $notice=saveamsg($message);
		} else{
			$notice="palun kirjuta sõnum";
		}
		
	}
	$pageTitle="Pealeht";
  require("header.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>anonüümse sõnumi lisamine</title>
</head>
<body>
	<h1>sõnumi lisamine</h1>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>sõnum(max 256 märki):</label>
	  <br>
	  <br>
	  <textarea style="font-family:comic sans ms;" rows="4" cols="64" name="message">sisesta siia oma sõnum: </textarea>
	  <br>
	  <p><a href="index_1.php">Tagasi sisselogimislehele</a></p>
	  <input type="submit" name="submitMessage" value="salvesta sõnum">
    </form>
	<hr>
	<p><?php echo $notice; ?></p>
	
</body>
</html>