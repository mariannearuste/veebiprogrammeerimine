<?php
  require("functions.php");
  //kui pole sisse logitud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: index_1.php");
	  exit();
  }
  
  $pageTitle="Pealeht";
  
  $scripts = '<script type="text/javascript" src="javascript/setrandompic.js" defer></script>' ."\n";
  require("header.php");
  
  
?>


	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]." ".$_SESSION["lastName"];?></p>
	<hr>
	<ul>
      <li><a href="?logout=1">Logi välja</a></li>
	  <li><a href="users.php">Süsteemi kasutajad</a></li>
	  <li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
	  <li><a href="validatedmessages.php">Näita valideeritud sõnumeid valideerijate kaupa</a></li>
	  <li><a href="userprofile.php">Minu kasutajaprofiil</a></li>
	  <li><a href="pubgallery.php">Avalike fotode galerii</a></li>
	  <li><a href="privephoto.php">Privaatsete fotode galerii</a></li>
	  <li><a href="photoupload.php">Fotode üleslaadimine</a></li>

	</ul>
	<hr>
	<div id="pic"> 
	
	</div>
	
  </body>
</html>