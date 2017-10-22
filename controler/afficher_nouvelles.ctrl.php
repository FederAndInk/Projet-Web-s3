<?php

require_once('../model/DAO.class.php');

$db = new DAO();

if (isset($_GET['RSS_id'])){
  $RSS_id = $_GET['RSS_id']; // on récupère l'id du flux RSS en pramètre

  $rqt = "SELECT titre,url FROM nouvelle WHERE RSS_id = '$RSS_id'";
  $result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  foreach($result as $key => $value){
    $titreNouvelles[] = $value['titre']; // titreNouvelles contient tous les titres des nouvelles du rss_id en paramètre
    $liensNouvelles[] = $value['url'];  // liensnouvelles contien tous les liens des novuelles du rss_id en paramètre
  }

  $data['titres']=$titreNouvelles;
  $data['urls']=$liensNouvelles;
  $message = ''; // message vide car aucune recherche

  include('../view/afficher_nouvelles.view.php');

} elseif(isset($_GET['mot_clef'])){
  $mot_clef = $_GET['mot_clef'];

  $mot_clef = SQLite3::escapeString ($mot_clef);
  $rqt = "SELECT titre,url FROM nouvelle where titre LIKE '%$mot_clef%' or description LIKE '%$mot_clef%'"; // on recherche tous les RSS contenant le mot clé dans le titre
  $result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  if(!empty($result)){
  foreach($result as $key => $value){
    $titreNouvelles[] = $value['titre']; // TitresNouvelles contient tous les titres des Nouvelles avec le mot clé dans la BD
    $liensNouvelles[] = $value['url']; // liensNouvelles contient tous les liens des Nouvelles avec le mot clé dans la BD
  }
  $data['titres']=$titreNouvelles;
  $data['urls']=$liensNouvelles;
  $message = ' contenant le mot clé choisi'; // Message de succès de la recherche

  include('../view/afficher_nouvelles.view.php');

} else {
  header('Location: http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php?search=error'); // Si aucun mot clé ne correspond dans la base de donnée on retourne à la page principale
}

}

?>
