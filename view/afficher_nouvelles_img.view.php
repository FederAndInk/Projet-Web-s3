<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../view/afficher_nouvelles_img.css">
    <title>Mosaïques des nouvelles</title>
  </head>
  <ul id="Menu">
    <li><a href="../controler/afficher_flux.ctrl.php">Flux</a></li>
    <li class = "deconnexion"><a href="../controler/afficher_flux.ctrl.php?deconnexion">Déconnexion</a></li>
    <?php ?>
  </ul>
  <h1>Mosaïque des nouvelles</h1>
  <body>
    <?php foreach($idImages as $id => $img){   // on affiche les nouvelles récentes d'abord (à noter que quand on ajoute un flux les plus récente sont à la fin, faute de mieux)?>
        <a href="<?php echo 'http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelle.ctrl.php?id_Nouvelle='.$img?>">
        <img src="<?php echo 'http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/model/images/'.$img.'.jpg'?>" height="200" width="200" />
        </a>
<?php } ?>
  </body>
</html>
