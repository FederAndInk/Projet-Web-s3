<?php

require_once('../model/DAO.class.php');

$db = new DAO();

if (isset($_GET['RSS_id'])){
  $RSS_id = $_GET['RSS_id']; // on récupère l'id du flux RSS en pramètre
  $message = ''; // message vide car aucune recherche
  $rqt = "SELECT titre,url,id FROM nouvelle WHERE RSS_id = '$RSS_id'";
  $result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );


} elseif(isset($_GET['mot_clef'])){
  $mot_clef = $_GET['mot_clef'];
  $message = ' contenant le mot clé choisi'; // Message de succès de la recherche

  $mot_clef = SQLite3::escapeString ($mot_clef);
  $rqt = "SELECT titre,url,id FROM nouvelle where titre LIKE '%$mot_clef%' or description LIKE '%$mot_clef%'"; // on recherche tous les RSS contenant le mot clé dans le titre

}

$result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  if(!empty($result)){
  foreach($result as $key => $value){
    $titreNouvelles[] = $value['titre']; // TitresNouvelles contient tous les titres des Nouvelles avec le mot clé dans la BD
    $liensNouvelles[] = $value['url']; // liensNouvelles contient tous les liens des Nouvelles avec le mot clé dans la BD
    $idNouvelles[] = $value['id'];
  }


  } else {
  header('Location: http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php?search=error'); // Si aucun mot clé ne correspond dans la base de donnée on retourne à la page principale
  }



$data['titres']=$titreNouvelles;
$data['urls']=$liensNouvelles;
$data['id']=$idNouvelles;

include('../view/afficher_nouvelles.view.php');



?>
