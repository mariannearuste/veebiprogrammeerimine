<?php
  //echo "See on minu esimene PHP!";
  $firstName = "Marianne";
  $lastName = "Aruste";  
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/"; 
  $allFiles = scandir($dirToRead);
  $picFiles = array_slice($allFiles, 2);
  //var_dump($picFiles);
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
  
  <?php
	//<img src="" alt="Mäed">
	for ($i = 0; $i < count($picFiles); $i ++){
	echo '<img src="' .$dirToRead .$picFiles[$i] .'" alt="Mäed"><br>'."\n";
	}
	
	?>
  
</body>
</html>