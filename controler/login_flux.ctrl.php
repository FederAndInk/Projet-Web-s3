  <?php
  require_once ('../model/DAO.class.php');
  $dao = new DAO();
  $login = $_POST['login'];
  $mdp = $_POST['mdp'];
  // Dans le cas ou un utilisateur est créé
  if (isset($_POST['newLogin'])) {
    // On vérifie si le login existe déjà et on le créé si non
    if (strlen($mdp) < 8) { // on controle si le mot de passe fait plus de 8 caractères
      $error = "createMdpSize";
    } elseif (! $dao->createUser($login, $mdp)) {
      $error = "createLoginUsed";
    }
  } elseif (isset($_POST['connection'])) {
    if (! $dao->verifUser($login, $mdp)) {
      $error = "loginNotExist";
    }
  }

  session_start();
  $_SESSION['login'] = $login;
  session_write_close();
  if (isset($error)) {
    header("Location:../view/login_flux.view.php?error=$error");
  } else {
    include ('afficher_flux.ctrl.php'); // si la connexion s'effectue corectement on envoi à la page principale
  }

  ?>
