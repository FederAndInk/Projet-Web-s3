<?php
// Définit le fuseau horaire par défaut à utiliser. Disponible depuis PHP 5.1
date_default_timezone_set('Europe/Paris');
$message_erreur_search = ""; // par défaut il n'y a pas d'erreur
$message_erreur_addRSS = "";

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');

// Ouverture de la base de donnée
$dao = new DAO();
$db = $dao->db(); // on récupère la base donnée

// Mise à jour d'un flux
if(isset($_GET['maj_Id'])){
  // on met à jour le flux
  $maj_Id = $_GET['maj_Id'];
  $rqt = "SELECT url FROM RSS WHERE id='$maj_Id'";
  $result =$db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  $rss = new RSS($result[0]['url'],$maj_Id);

  //On met à jour la date de mise à jour
  $date = date('l jS \of F Y h:i:s A');
  $rqt = "UPDATE RSS SET date='$date' WHERE id='$maj_Id'"; // On met à jour la date dans la BD
  $result = $db->exec ( $rqt );

}

// Ajout d'un flux
if (isset($_GET['new_flux'])){
  $new_flux = $_GET['new_flux'];
  if (filter_var($new_flux, FILTER_VALIDATE_URL)) {
    $rss1 = $dao->readRSSfromURL ( $new_flux ); // on lit l'url du flux
    if ($rss1 == NULL) {
      $rss1 = $dao->createRSS ( $new_flux );
    }
  }   else {
    $message_erreur_addRSS = "Le flux n'existe pas";
  }

}

//on met les titres des RSS dans une liste

$rqt = "SELECT id,titre,url,date FROM RSS"; // on recherche tous les RSS contenant le mot clé dans le titre
$result2 = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
var_dump($result2);
if(!empty($result2)){
  foreach($result2 as $key => $value){
    $titresRSS[] = $value['titre']; // TitresRSS contient tous les titres des RSS dans la base de donnée
    $liensRSS[] = $value['url']; // liensRSS contient tous les liens des RSS dans la base de donnée
    $RSS_id[] = $value ['id']; //RSS_id contient tous les id des RSS de la base de donnée
    $date_maj[] = $value ['date'];   //date_maj contient toute les dates des RSS de la BD
  }
  $data['titres']=$titresRSS;
  $data['urls']=$liensRSS;
  $data ['id']=$RSS_id;
  $data ['date'] = $date_maj;

  $vide = false; // On signal qu'il y a des RSS à afficher
} else {
  $vide = true; // on signal qu'il n'y a pas de RSS à afficher
}



// On traite la recherche de la nouvelle
if (isset($_GET['mot_clef'])) {
  $mot_clef = $_GET['mot_clef'];
  $mot_clef = SQLite3::escapeString ($mot_clef);
  $rqt = "SELECT titre,url,id FROM nouvelle where titre LIKE '%$mot_clef%' or description LIKE '%$mot_clef%'"; // on recherche tous les RSS contenant le mot clé dans le titre
  $result3 = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  if ($result3 == null){
    $message_erreur_search = "Le mot clé n'existe pas";
  } else {
    header("Location: http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_nouvelles.ctrl.php?mot_clef=$mot_clef"); // Si aucun mot clé ne correspond dans la base de donnée on retourne à la page principale
  }
}

// On traite le vidage du flux
if (isset($_GET['vid_Id'])){
  $images = scandir('../model/images'); // On va chercher les images dans le dossier image
  $vid_Id = $_GET['vid_Id'];
  $rqt = "SELECT id FROM nouvelle WHERE RSS_id = '$vid_Id'";
  $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );

  // On va chercher dans le dossier image le nombre d'images correspondant et On récupère les id  des nouvelles par rapport aux images
  foreach ($images as $key => $img) {
    foreach ($result as $key => $value) {
      echo "string";
      if($img == $value['id'].".jpg"){
        unlink("../model/images/$img"); // On supprime l'image si elle fait partie du RSS
      }
    }
  }
  // On supprime les nouvelles de la BD
  $rqt = "DELETE FROM nouvelle WHERE RSS_id=$vid_Id";
  $result = $db->exec($rqt);

  // On recréé les nouvelles
  $rqt = "SELECT url FROM RSS WHERE id=$vid_Id";
  $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  $rss = $dao->readRSSfromURL ( $result[0]['url'] ); // on lit l'url du flux
}


// On supprime le rss de l'id passé en paramètre
if(isset($_GET['supr_Id'])){
  $supr_Id = $_GET['supr_Id'];
  $images = scandir('../model/images'); // On va chercher les images dans le dossier image

  $rqt = "SELECT id FROM nouvelle WHERE RSS_id = '$supr_Id'";
  $result = $db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );

  // On va chercher dans le dossier image le nombre d'images correspondant et On récupère les id  des nouvelles par rapport aux images
  foreach ($images as $key => $img) {
    foreach ($result as $key => $value) {
      if($img == $value['id'].".jpg"){
        unlink("../model/images/$img"); // On supprime l'image si elle fait partie du RSS
      }
    }
  }
  $rqt = "DELETE FROM nouvelle WHERE RSS_id=$supr_Id";
  $result = $db->exec($rqt);
  $rqt = "DELETE FROM RSS WHERE id=$supr_Id";
  $result = $db->exec($rqt);
  // On r
  header("Location:http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/controler/afficher_flux.ctrl.php");
}









include('../view/afficher_flux.view.php');

?>
