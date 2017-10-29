<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../view/afficher_nouvelles.css">
<title>Actus du RSS</title>
</head>

<!--affichage du menu -->
<ul id="Menu">
	<li><a href="../controler/afficher_flux.ctrl.php">Flux</a></li>
	<li class="deconnexion"><a
		href="../controler/afficher_flux.ctrl.php?deconnexion">Déconnexion</a><?php echo " (".$_SESSION['login'].")"; ?></li>
    <?php ?>
  </ul>
<h1><?php echo "Actus du RSS".$message ?></h1>

<!--affichage des nouvelles du flux -->
<body>
    <?php foreach($data['titres'] as $key => $value){   ?>

        <a
		href="<?php echo '../controler/afficher_nouvelle.ctrl.php?id_Nouvelle='.$data['id'][$key] ?> ">
          <?php echo "$value" ?>
        </a>
	<br>
<?php } ?>
  </body>
</html>
