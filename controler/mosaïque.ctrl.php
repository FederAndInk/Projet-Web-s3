<?php
  // On va chercher les image dans le dossier images
  $images = scandir('../model/images');
  foreach ($images as $key => $value){
      $info = new SplFileInfo($value);
    if (($info->getExtension() != 'jpg') || ($value == ".jpg")){ // si l'estension et différente de .jpg on supprime
    unset($images[$key]);
  }
}
  $images = array_values($images); // on reinitialise les clefs de la liste
  var_dump($images);
?>
