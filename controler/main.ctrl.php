<?php

require_once('../model/DAO.class.php');
// Ouverture de la base de donnée
  $dao = new DAO();
  $db = $dao->db();
  $rqt = "SELECT titre, FROM RSS";

  //on met les titres des RSS dans une liste
  $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  foreach($result as $key => $value){
    $titre[] = $value['titre']; // Titre contient tous les titres des RSS dans la base de donnée
  }

  $
 ?>
