<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../view/afficher_nouvelles.css">
    <title>Actus du RSS</title>
  </head>
  <ul id="Menu">
    <li><a href="http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php">Flux</a></li>
    <li><a href="#">test</a></li>
  </ul>
  <h1><?php echo "Actus du RSS".$message ?></h1>
  <body>
    <?php foreach($data['titres'] as $key => $value){   ?>

        <a href="<?php echo $data['urls'][$key] ?> ">
          <?php echo "$value" ?>
        </a>
        <br>
<?php } ?>
  </body>
</html>
