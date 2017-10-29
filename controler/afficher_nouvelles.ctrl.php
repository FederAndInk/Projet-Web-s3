<?php
// controle d'utilisateur
session_start();
if (! isset($_SESSION['login'])) {
  header('Location:../view/login_flux.view.php');
}

require_once ('../model/DAO.class.php');

$db = new DAO();

// on récupère l'id du flux RSS en pramètre
if (isset($_GET['RSS_id'])) {
  $RSS_id = $_GET['RSS_id'];
  $message = ''; // message vide car aucune recherche
  $result = $db->getInfoNouvelleFromRSSID($RSS_id);
} elseif (isset($_GET['mot_clef'])) { // Sinon on récupère le mot clef passé en paramètre
  $result = $db->getInfoNouvelleSFromMotClef($_GET['mot_clef']);
  $motClef = $_GET['mot_clef'];
  if ($result == null) {
    header("Location:afficher_flux.ctrl.php?motClefErreur=erreur");
  }
  $message = ' contenant le mot clé choisi'; // Message de succès de la recherche
}

foreach ($result as $key => $value) {
  $titreNouvelles[] = $value['titre']; // TitresNouvelles contient tous les titres des Nouvelles avec le mot clé dans la BD
  $liensNouvelles[] = $value['url']; // liensNouvelles contient tous les liens des Nouvelles avec le mot clé dans la BD
  $idNouvelles[] = $value['id'];
}

// envoi des informations à la vue
$data['titres'] = $titreNouvelles;
$data['urls'] = $liensNouvelles;
$data['id'] = $idNouvelles;

include ('../view/afficher_nouvelles.view.php');

?>
