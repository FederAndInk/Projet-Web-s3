<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Page principale</title>
  </head>
  <body>
    <div class="">
    <p>
      <?php foreach ($data['titres'] as $key => $value) { ?>
        <a href="<?php echo $data['urls'][$key] ?> ">
        <?php echo $value ?>
      </a><a href="<?php echo "http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles_img.ctrl.php?RSS_id=".$data['id'][$key]  ?>"><img src="mosaic.png" alt=""></a>
        <br/>
    <?php   } ?>
    </p>

  </div>
  </body>
</html>
