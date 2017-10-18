<?php

require_once('../model/DAO.class.php');
// Ouverture de la base de donnée
  $dao = new DAO();
  $db = $dao->db();
  $rqt = "SELECT titre,url FROM RSS";

  //on met les titres des RSS dans une liste
  $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  foreach($result as $key => $value){
    $titresRSS[] = $value['titre']; // Titre contient tous les titres des RSS dans la base de donnée
    $liensRSS[] = $value['url'];
  }
  $data['titres']=$titresRSS;
  $data['urls']=$liensRSS;

include ('../view/afficher_flux.view.php'); ?>