<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mosaïques des nouvelles</title>
  </head>
  <h1>Mosaïque des nouvelles</h1>
  <body>
    <?php foreach($idImages as $id => $img){   ?>

        <a href="<?php echo 'http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelle.ctrl.php?id_Nouvelle='.$img?>">
        <img src="<?php echo 'http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/model/images/'.$img.'.jpg'?>" height="200" width="200" />
        </a>
<?php } ?>
  </body>
</html>
