  <?php
  session_start();
  if(!isset($_SESSION['login'])){
     header('Location:../view/login_flux.view.php');
   } else {
     $user = $_SESSION['login'];
   }

   // Si l'utilisateur se déconnecte
   if(isset($_GET['deconnexion'])){
     $_SESSION = array(); // Réinitialisation de session
     session_write_close(); // on ferme la session
     header("Refresh:0"); // on rafraichit la page
   }
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
  if(isset($_GET['maj_url'])){
    // On récupère le RSS du flux
    $rss = $dao->readRSSfromURL($_GET['maj_url']);

    //On met à jour le flux
    $dao->updateRSS($rss);
  }

  // Ajout d'un flux
  if (isset($_GET['new_flux'])){
    $new_flux = $_GET['new_flux'];
    if (filter_var($new_flux, FILTER_VALIDATE_URL)) { // On vérifie que c'est bien une url
      $rss1 = $dao->readRSSfromURL ( $new_flux ); // on lit l'url du flux
      if ($rss1 == NULL) {
            echo "zkjnznfzlnclznflzfln";
        $rss1 = $dao->createRSS ( $new_flux ); // on créé le flux
        $dao->addFluxUtilisateur($rss1->id(),$user); // on ajoute le flux aux abonnements de l'utilisateur
      } else {
        $dao->addFluxUtilisateur($rss1->id(),$user);  // on ajoute le flux aux abonnements de l'utilisateur
      }
    }   else {
      $message_erreur_addRSS = "Le flux n'existe pas"; // message d'erreur envoyé à la view si ce n'est pas un lien
    }

  }


  // Envoie des infos concernant les RSS de l'utilisateur à la vue
  var_dump($dao->getInfoRSSUtilisateur($user));
  if(!empty($dao->getInfoRSSUtilisateur($user))){
    foreach($dao->getInfoRSSUtilisateur($user) as $key => $value){
      $titresRSS[] = $value['titre']; // TitresRSS contient tous les titres des RSS dans la base de donnée
      $liensRSS[] = $value['url']; // liensRSS contient tous les liens des RSS dans la base de donnée
      $RSS_id[] = $value ['id']; //RSS_id contient tous les id des RSS de la base de donnée
      $date_maj[] = $value ['date'];   //date_maj contient toute les dates des RSS de la BD
    }
    $data['titres']=$titresRSS;
    $data['urls']=$liensRSS;
    $data ['id']=$RSS_id;
    $data ['date'] = $date_maj;
    var_dump($data['titres']);
    var_dump($data['urls']);
    var_dump($data ['id']);
    var_dump($data ['date']);
    $vide = false; // On signal qu'il y a des RSS à afficher
  } else { // Si il n'y a pas de RSS à afficher le signal
    $vide = true;
  }

  // On traite la recherche de la nouvelle
  if (isset($_GET['mot_clef'])) {
      $motClef = $_GET['mot_clef'];
      header("Location: afficher_nouvelles.ctrl.php?mot_clef=$motClef"); // Si aucun mot clé ne correspond dans la base de donnée on retourne à la page principale
    }

    // si le mot clef n'existe pas on envoi un message d'erreur
  if (isset($_GET['motClefErreur'])){
    $message_erreur_search = "Le mot clef n'existe pas";
  }

  // On traite le vidage du flux
  if (isset($_GET['vid_Id'])){
    $images = scandir('../model/images'); // On va chercher les images dans le dossier image
    $result = $dao -> getInfoNouvelleFromRSSID($_GET['vid_Id']);

    // On va chercher dans le dossier image le nombre d'images correspondant et On récupère les id  des nouvelles par rapport aux images
    foreach ($images as $key => $img) {
      foreach ($result as $key => $value) {
        if($img == $value['id'].".jpg"){
          unlink("../model/images/$img"); // On supprime l'image si elle fait partie du RSS
        }
      }
    }

    // On vidange le flux dans la base de donnée
    $dao->vidageFlux($_GET['vid_Id']);
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
    header("Refresh:0");
  }






  include('../view/afficher_flux.view.php');

  ?>
