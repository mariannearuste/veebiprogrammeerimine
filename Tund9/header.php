
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php echo $pagetitle; ?></title>
    <style>
    <?php
        echo "body{background-color: " .$_SESSION["bgcolor"] ."; \n";
    echo "color: " .$_SESSION["txtcolor"] ."} \n";
    ?>
  </style>
  </head>
  <body>
  <div>
      <a href="main.php">
        <img src="../vp_picfiles/vp_logo_w135_h90.png" alt="VP_logo">
      </a> 
      <img src="../vp_picfiles/vp_banner.png" alt="VP 2018 bänner">
  </div>
    <h1><?php echo $pagetitle; ?></h1>