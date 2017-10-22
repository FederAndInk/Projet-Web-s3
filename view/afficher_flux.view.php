<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../view/afficher_flux.css">
    <title>Page principale</title>
  </head>
  <ul id="Menu">
    <li><a href="http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php">Flux</a></li>
    <li><a href="#">test</a></li>
  </ul>
  <h1>Liste des flux enregistrés</h1>
  <body>
    <div class="ListeF">
    <p>

      <?php foreach ($data['titres'] as $key => $value) { ?>
        <li>
        <a href="<?php echo "http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles.ctrl.php?RSS_id=".$data['id'][$key] ?> ">
        <?php echo $value ?>
      </a><a href="<?php echo "http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles_img.ctrl.php?RSS_id=".$data['id'][$key]  ?>"><img src="../model/mosaic.png" alt="" height="15" width="15"></a>
      </li>
        <br/>

    <?php   } ?>

    </p>

  </div>
  </body>
</html>
