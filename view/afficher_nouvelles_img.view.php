<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../view/afficher_nouvelles_img.css">
<title>Mosaïques des nouvelles</title>
</head>

<!--affichage du menu -->
<ul id="Menu">
	<li><a href="../controler/afficher_flux.ctrl.php">Flux</a></li>
	<li class="deconnexion"><a
		href="../controler/afficher_flux.ctrl.php?deconnexion">Déconnexion</a><?php echo " (".$_SESSION['login'].")"; ?></li>
    <?php ?>
  </ul>
<h1>Mosaïque des nouvelles</h1>

<!--affichage de la mosaïque des nouvelles -->
<body>
    <?php foreach($idImages as $id => $img){   // on affiche les nouvelles récentes d'abord (à noter que quand on ajoute un flux les plus récente sont à la fin, faute de mieux)?>
        <a
		href="<?php echo '../controler/afficher_nouvelle.ctrl.php?id_Nouvelle='.$img?>">
		<img
		src="<?php echo '../model/images/'.$img.'.jpg'?>"
		height="200" width="200" />
	</a>
<?php } ?>
  </body>
</html>
