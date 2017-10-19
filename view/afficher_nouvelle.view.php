<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nouvelle</title>
  </head>
  <h1><?php echo $titreNouvelle ?></h1>
  <body>
    <div class="">
      <p>
        <img src="<?php echo "../model/images/".$imageNouvelle ?>" alt=""><br>
        <?php echo $dateNouvelle ?><br>
        <?php echo $descriptionNouvelle ?><br>
        <a href="<?php echo $urlNouvelle ?>">Lire l'article</a>

      </p>

    </div>
  </body>
</html>
