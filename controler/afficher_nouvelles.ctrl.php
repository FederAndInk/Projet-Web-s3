<?php

require_once('../model/DAO.class.php');

$db = new DAO();

$RSS_id = $_GET['RSS_id']; // on récupère l'id du flux RSS en pramètre
$rqt = "SELECT titre,url FROM nouvelle WHERE RSS_id = '$RSS_id'";
$result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
foreach($result as $key => $value){
  $titreNouvelles[] = $value['titre']; // titreNouvelles contient tous les titres des nouvelles du rss_id en paramètre
  $liensNouvelles[] = $value['url'];  // liensnouvelles contien tous les liens des novuelles du rss_id en paramètre
}

$data['titres']=$titreNouvelles;
$data['urls']=$liensNouvelles;

include('../view/afficher_nouvelles.view.php');

?>
