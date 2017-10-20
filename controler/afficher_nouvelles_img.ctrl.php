<?php
require_once('../model/DAO.class.php');
  // On va chercher les image dans le dossier images
  $images = scandir('../model/images');
  foreach ($images as $key => $value){
      $info = new SplFileInfo($value); // pour obtenir les infos des images
    if (($info->getExtension() != 'jpg') || ($value == ".jpg")){ // si l'estension et différente de .jpg on supprime
    unset($images[$key]);
  }
}
  $data['images'] = $images;

 // On récupère les id nouvelles par rapport aux images
  foreach ($images as $key => $value) {
    $img = strstr($value,'_'); // on supprime tous ce qu'il y a devant le '_'
    $img = trim($img,'_'); // on supprime le '_'
    $img = preg_replace("/.jpg/",'',$img); // on replace le .jpg par une chaine vide
    $idImages[] = $img;
}

  include('../view/afficher_nouvelles_img.view.php');
?>
