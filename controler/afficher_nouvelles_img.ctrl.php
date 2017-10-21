<?php
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

  sort($images);
  $data['images'] = $images;

 // On récupère les id nouvelles par rapport aux images
  foreach ($images as $key => $img) {
    $img = preg_replace("/.jpg/",'',$img); // on replace le .jpg par une chaine vide
    $idImages[] = $img;
}

asort($idImages);
  include('../view/afficher_nouvelles_img.view.php');
?>
