<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../view/afficher_flux.css">
    <title>Page principale</title>
  </head>
  <div class="MenuDiv">

  <ul id="Menu">
    <li><a href="http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php">Flux</a></li>
    <li><a href="#">test</a></li>

  </ul>


</div>
  <div class="Recherche">
    <form action="/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php" id="mot_clef" method="get">
    <input id="search" name="mot_clef" type="text" placeholder="Rechercher un flux RSS par mot clé" />
    <input id="search-btn" type="submit" value="Rechercher" />
    </form>
  </div>
  <h1>Liste des flux enregistrés</h1>
  <body>
    <div class="ListeF">


      <?php foreach ($data['titres'] as $key => $value) { ?>
        <p>
        <a href="<?php echo "http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles.ctrl.php?RSS_id=".$data['id'][$key] ?> ">
        <?php echo $value ?>
      </a><a href="<?php echo "http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles_img.ctrl.php?RSS_id=".$data['id'][$key]  ?>"><img src="../model/mosaic.png" alt="" height="15" width="15"></a><br>
      <button type="button" name="Maj_flux"><a href="<?php echo "../controler/afficher_flux.ctrl.php?maj_Id=".$data['id'][$key] ?>">Mise à jour du flux</a></button>
      </p>
        <br/>

    <?php   } ?>



  </div>
  </body>
</html>
