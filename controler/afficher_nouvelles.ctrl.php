<?php
session_start();
if (! isset($_SESSION['login'])) {
  header('Location:../view/login_flux.view.php');
}

require_once ('../model/DAO.class.php');

$db = new DAO();

if (isset($_GET['RSS_id'])) {
  $RSS_id = $_GET['RSS_id']; // on récupère l'id du flux RSS en pramètre
  $message = ''; // message vide car aucune recherche
  $result = $db->getInfoNouvelleFromRSSID($RSS_id);
} elseif (isset($_GET['mot_clef'])) {
  $result = $db->getInfoNouvelleSFromMotClef($_GET['mot_clef']);
  $motClef = $_GET['mot_clef'];
  if ($result == null) {
    header("Location:afficher_flux.ctrl.php?motClefErreur=erreur");
  }
  $message = ' contenant le mot clé choisi'; // Message de succès de la
                                             // recherche
                                               //
                                               // $mot_clef =
                                             // SQLite3::escapeString
                                             // ($mot_clef);
                                               // $rqt = "SELECT titre,url,id FROM
                                             // nouvelle where titre LIKE
                                             // '%$mot_clef%' or description
                                             // LIKE '%$mot_clef%'"; // on
                                             // recherche tous les RSS contenant
                                             // le mot clé dans le titre
                                               // $result = $db->db()->query (
                                             // $rqt )->fetchAll (
                                             // PDO::FETCH_ASSOC );
}

foreach ($result as $key => $value) {
  $titreNouvelles[] = $value['titre']; // TitresNouvelles contient tous les
                                       // titres des Nouvelles avec le mot clé
                                       // dans la BD
  $liensNouvelles[] = $value['url']; // liensNouvelles contient tous les liens
                                     // des Nouvelles avec le mot clé dans la BD
  $idNouvelles[] = $value['id'];
}

$data['titres'] = $titreNouvelles;
$data['urls'] = $liensNouvelles;
$data['id'] = $idNouvelles;

include ('../view/afficher_nouvelles.view.php');

?>
