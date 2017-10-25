<?php

session_start();
if(!isset($_SESSION['login'])){
   header('Location:../view/login_flux.view.php');
 }

require_once('../model/DAO.class.php');

$idNouvelle = $_GET['id_Nouvelle']; // on récupère l'id de la nouvelle en paramètre
// On va chercher la nouvelle correspondant dans la base de donnée
$db = new DAO();
$rqt = "SELECT * FROM nouvelle WHERE id = '$idNouvelle'";
$result = $db->db()->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
// on récupère toutes les informations de la nouvelle
foreach($result as $key => $value){
  $dateNouvelle = $value['date'];
  $titreNouvelle = $value['titre'];
  $descriptionNouvelle = $value['description'];
  $urlNouvelle = $value ['url'];
  $RSS_idNouvelle = $value['RSS_id'];
}
// On va chercher l'image de la nouvelle dans le répertoire
$imagesNouvelles = scandir('../model/images');
foreach ($imagesNouvelles as $key => $img) {
  if ($img == $idNouvelle.'.jpg') {
    $imageNouvelle = $img;
  }
}

include('../view/afficher_nouvelle.view.php');

?>
