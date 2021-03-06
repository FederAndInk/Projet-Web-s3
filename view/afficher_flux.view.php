<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../view/afficher_flux.css">
<title>Page principale</title>
</head>

<!--affichage du menu -->
<div class="MenuDiv">
	<ul id="Menu">
		<li><a href="../controler/afficher_flux.ctrl.php">Flux</a></li>
		<li class="deconnexion"><a
			href="../controler/afficher_flux.ctrl.php?deconnexion">Déconnexion</a><?php echo " (".$user.")"; ?></li>
    <?php ?>
  </ul>
</div>

<!--affichage de la barre recherche -->
<div class="Recherche">
	<form action="afficher_flux.ctrl.php" id="mot_clef" method="get">
		<input id="search" name="mot_clef" type="text"
			placeholder="Rechercher un flux RSS par mot clé" /> <input
			id="search-btn" type="submit" value="Rechercher" />
    <?php echo "<br>".$message_erreur_search; ?>
  </form>
</div>

<!--affichage du menu -->
<div class="Ajouter_Flux">
	<form
		action="/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php"
		id="nf" method="get">
		<input id="nf" name="new_flux" type="text"
			placeholder="Entrez le lien du RSS à ajouter" /> <input id="nf-btn"
			type="submit" value="Ajouter" />
    <?php echo "<br>".$message_erreur_addRSS; ?>
  </form>
</div>

<h1>Liste des flux enregistrés</h1>
<body>

	<!--affichage des flux auxquels l'utilisateur est abonné -->
	<div class="ListeF">
    <?php
if (! $vide) { // si il y a des RSS à afficher on les affiche
      foreach ($data['titres'] as $key => $value) {
        ?>
        <p>
			<a
				href="<?php echo "../controler/afficher_nouvelles.ctrl.php?RSS_id=".$data['id'][$key] ?> ">
            <?php echo $value ?>
          </a><a
				href="<?php echo "../controler/afficher_nouvelles_img.ctrl.php?RSS_id=".$data['id'][$key]  ?>"><img
				src="../model/mosaic.png" alt="" height="30" width="30"></a><br>
          Date de la dernière mise à jour : <?php echo $data['date'][$key] ?>

<!--affichage des différentes options pour chacun des flux -->
		<form method="post"
			action="<?php echo "../controler/afficher_flux.ctrl.php?maj_url=".$data['urls'][$key] ?>">
			<input type="submit" value="Mise à jour">
		</form>
		<form method="post"
			action="<?php echo "../controler/afficher_flux.ctrl.php?vid_Id=".$data['id'][$key] ?>">
			<input type="submit" value="Vidage du flux">
		</form>
		<form method="post"
			action="<?php echo "../controler/afficher_flux.ctrl.php?supr_Id=".$data['id'][$key] ?>">
			<input type="submit" value="Supprimer flux">
		</form>
		<hr>
		</p>
		<br />

      <?php   }  } ?>



    </div>
</body>
</html>
