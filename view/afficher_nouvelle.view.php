<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../view/afficher_nouvelle.css">
<title>Nouvelle</title>
</head>
<ul id="Menu">
	<li><a href="../controler/afficher_flux.ctrl.php">Flux</a></li>
	<li class="deconnexion"><a
		href="../controler/afficher_flux.ctrl.php?deconnexion">Déconnexion</a></li>
    <?php ?>
  </ul>
<h1><?php echo $titreNouvelle ?></h1>
<body>

	<div class="">
		<p>
			<img src="<?php echo "../model/images/".$imageNouvelle ?>" alt=""><br>
        <?php echo $dateNouvelle ?><br>
        <?php echo $descriptionNouvelle ?><br> <a
				href="<?php echo $urlNouvelle ?>">Lire l'article</a>

		</p>

	</div>
</body>
</html>
