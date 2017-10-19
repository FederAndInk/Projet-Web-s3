<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mosaïques des nouvelles</title>
  </head>
  <h1>Mosaïque des nouvelles</h1>
  <body>
    <?php var_dump($data['images']);shell_exec('setup-public-html') //on met à jours public_html avec le nouvevelles images // TODO: lorsque l'on créé de nouvelles image un setup-public-html est requis (pas chez Jessy) wtf ??>
    <?php foreach($data['images'] as $id => $img){   ?>

        <a href="">
        <img src="<?php echo 'http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/model/images/'.$img?>" height="200" width="200" />
        </a>
<?php } ?>
  </body>
</html>
