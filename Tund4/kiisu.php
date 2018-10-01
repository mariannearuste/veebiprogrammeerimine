<?php
  require("functions.php");
  $notice = null;
  $error = "";
    if (isset($_POST["submitcat"])){
      if (!empty($_POST["catname"]) and !empty($_POST["catcolor"]) and !empty($_POST["cattaillength"])){
          $catName = test_input($_POST["catname"]); 
          $catColor = test_input($_POST["catcolor"]);
          $catTailLength = test_input($_POST["cattaillength"]);
          $notice = addcat($_POST["catname"], $_POST["catcolor"], $_POST["cattaillength"]);
        } 
        else {
            $notice = "Palun täida kõik väljad!";
        
        }
    }
    $cats = listallcats();
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kiisud</title>
</head>
<body>
  <h1>Kiisu lisamine andmebaasi</h1>
  <p>Siin on <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebileht. See ei oma mingit sisu ja nende kopeerimine ei oma mõtet.</p>
  <br>

  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Kiisu andmed:</label>
    <input type="text" name="catname">
    <input type="text" name="catcolor">
    <input type="text" min="0" max="100" name="cattaillength" >
    <br>
    <input name="submitcat" type="submit" value="Salvesta sõnum">
  </form>
  <br>
  <p><?php echo $notice; ?></p>
  <p>Lisatud kiisude nimekiri: </p>
  <ol><?php echo $cats; ?></ol>
  <br>
  
  
  

</body>
</html>