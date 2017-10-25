<?php
session_start();
if(!isset($_SESSION['login'])){
   header('Location:../view/login_flux.view.php');
 }
 
require_once('../model/DAO.class.php');
  // On va chercher les image dans le dossier images
  $RSS_id = $_GET['RSS_id'];
  $images = scandir('../model/images');
  foreach ($images as $key => $value){
      $info = new SplFileInfo($value); // pour obtenir les infos des images
    if (($info->getExtension() != 'jpg') || ($value == ".jpg")){ // si l'extension et différente de .jpg on supprime
    unset($images[$key]);
  }
}

  //On va chercher dans la base de donnée le nombre d'image du rssId
  $db = new DAO();
  $rqt = "SELECT id FROM nouvelle WHERE RSS_id = '$RSS_id'";
  $result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
  // On va chercher dans le dossier image le nombre d'images correspondant et On récupère les id  des nouvelles par rapport aux images
  foreach ($images as $key => $img) {
    $img = preg_replace("/.jpg/",'',$img); // on replace le .jpg par une chaine vide
    foreach ($result as $key => $value) {
      if($img == $value['id']){
        $idImages[] = $img;
      }
    }
}
var_dump($idImages);
  include('../view/afficher_nouvelles_img.view.php');
?>
