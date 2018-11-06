<?php
  require("functions.php");

  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
      header("Location: index_1.php");
      exit();
    } 
  
  //väljalogimine
  if(isset($_GET["logout"])){
    session_destroy();
    header("Location: index_1.php");
    exit();
  }
  
  $mydescription = "Pole tutvustust lisanud!";
  $mybgcolor = "#FFFFFF";
  $mytxtcolor = "#000000";
  
  if(isset($_POST["submitProfile"])){
  $notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
  if(!empty($_POST["description"])){
    $mydescription = $_POST["description"];
  }
  $mybgcolor = $_POST["bgcolor"];
  $mytxtcolor = $_POST["txtcolor"];
  } else {
  $myprofile = showmyprofile();
  if($myprofile->description != ""){
    $mydescription = $myprofile->description;
    }
    if($myprofile->bgcolor != ""){
    $mybgcolor = $myprofile->bgcolor;
    }
    if($myprofile->txtcolor != ""){
    $mytxtcolor = $myprofile->txtcolor;
    }
  }

  

?>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <title>Kasutaja profiil</title>
    <link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
    <style>
          body{background-color: #fcf196; 
          color: #000000}

    </style>
  <hr>
  <h1>Kasutaja profiil</h1>
  <ul>
    <li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="main.php">Tagasi pealehele</a></li>
  </ul>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Kasutaja kirjeldus (max 2000 tähemärki) </label><br>
    <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
    <br>
    <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
    <br>
    <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>

    <style>

        body{
            background-color: <?php echo $mybgcolor ?>;
            color: <?php echo  $mytxtcolor ?>;
            }
  </style>  
    <input name="submitProfile" type="submit" value="Salvesta profiil">
  </form>
  
  
  </body>
</html>