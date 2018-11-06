<?php
  //echo "See on minu esimene PHP!";
  $firstName = "Marianne";
  $lastName = "Aruste";  
  $dateToday = date("d.m.Y");
  $weekdayNow = date("N");
  $weekdayNamesET = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
  //echo $weekdayNamesET[1];
  //var_dump ($weekdayNamesET);
  //echo $weekdayNow;
  $monthNow = date("m");
  $monthNamesET = ["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember"];
  $dayNow = date("d");
  $yearNow = date("Y");
  $hourNow = date("G");
  $partOfDay = "";
  if ($hourNow < 8) {
	  $partOfDay = "varane hommik";
	  }
  if ($hourNow >= 8 and $hourNow < 16) {
	  $partOfDay = "koolipäev";
	  }
	  if ($hourNow >= 16) {
	  $partOfDay = "ilmselt vaba aeg";
	  }
	  $picNum = mt_rand(2,43);
	  //echo $picNum;
	  $picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	  $picEXT = ".jpg";
	  $picFile = $picURL .$picNum .$picEXT;
  

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
  <p>Tundides tehtu: <a href="photo.php">photo.php</a></p>
	<?php
		//echo "<p>Tänane kuupäev on:" .$dateToday .".</p>\n";
		//echo "<p>Täna on " .$weekdayNow .", " .$dateToday .".</p>\n";
		echo "<p>Täna on " .$weekdayNamesET[$weekdayNow - 1] .", " .$dayNow ."." ." " .$monthNamesET[$monthNow -1] ." "  .$yearNow .".</p>\n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli " .$partOfDay .".</p> \n";
	?>
  <p>Random fact! An average person will spend 25 years asleep.</p>
  <!--img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="Tallinna Ülikooli Terra maja õppehoone"-->
  <img src="<?php echo $picFile; ?>" alt="Tallinna Ülikooli Terra maja">
  <!--<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="Tallinna Ülikooli Terra maja">-->
  <p>Mul on ka oma sõber kes teeb oma <a href="../../../~rolagre">veebi.</a> </p>
</body>
</html>