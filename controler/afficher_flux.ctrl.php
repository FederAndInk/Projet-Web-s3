<?php
// Vérification du mot clé



require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

// Ouverture de la base de donnée
  $dao = new DAO();
  $db = $dao->db(); // on récupère la base donnée

  // Mise à jour d'un flux
    if(isset($_GET['maj_Id'])){ // TODO: A finir;
      $maj_Id = $_GET['maj_Id'];
      $rqt = "SELECT url FROM RSS WHERE id='$maj_Id'";
      $result =$db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
      $rss = new RSS($result[0]['url'],$maj_Id);
    }


//on met les titres des RSS dans une liste

    $rqt = "SELECT id,titre,url FROM RSS"; // on recherche tous les RSS contenant le mot clé dans le titre
    $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  foreach($result as $key => $value){
    $titresRSS[] = $value['titre']; // TitresRSS contient tous les titres des RSS dans la base de donnée
    $liensRSS[] = $value['url']; // liensRSS contient tous les liens des RSS dans la base de donnée
    $RSS_id[] = $value ['id']; //nRSS_id contient tous les id des RSS de la base de donnée
}

  $data['titres']=$titresRSS;
  $data['urls']=$liensRSS;
  $data ['id']=$RSS_id;



include('../view/afficher_flux.view.php');

 ?>
