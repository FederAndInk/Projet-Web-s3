<?php
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);
require_once ('RSS.class.php');
class DAO {
    private $db; // L'objet de la base de donnée

    // Ouverture de la base de donnée
    function __construct() {
        $dsn = 'sqlite:../model/data/rss.db'; // Data source name
        try {
            $this->db = new PDO ( $dsn );
        } catch ( PDOException $e ) {
            exit ( "Erreur ouverture BD : " . $e->getMessage () );
        }
    }

    // getter
    function db() {
        return $this->db;
    }

    // ////////////////////////////////////////////////////////
    // Methodes CRUD sur RSS
    // ////////////////////////////////////////////////////////

    // Crée un nouveau flux à partir d'une URL
    // Si le flux existe déjà on ne le crée pas
    function createRSS($url) {
        $rss = $this->readRSSfromURL ( $url );
        if ($rss == NULL) {
            try {
                $doc = new DOMDocument ();
                $doc->load ( $url );
                $titre = $doc->getElementsByTagName("title")->item ( 0 )->textContent;
                $date = $doc->getElementsByTagName("pubDate")->item ( 0 )->textContent;
                $titre = SQLite3::escapeString ($titre);
                $date = SQLite3::escapeString ( $date );
                $q = "INSERT INTO RSS (titre,url,date) VALUES ('$titre','$url','".$date."')";
                $r = $this->db->exec ( $q );
                if (!$r) {
                    die ( "createRSS error: no rss inserted\n" );
                }
                return $this->readRSSfromURL ( $url );
            } catch ( PDOException $e ) {
                die ( "PDO Error :" . $e->getMessage () );
            }
        } else {
            // Retourne l'objet existant
            return $rss;
        }
    }

    // retourne les infos de tous les RSS
    function getInfoRSSUtilisateur(string $utilisateur):array{
      $result3 = array();
      $utilisateur = SQLite3::escapeString ($utilisateur);
      $rqt = "SELECT RSS_id FROM abonnement WHERE utilisateur_login='$utilisateur'";
      $result2 = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_BOTH );
      if (!empty($result2)){
        foreach ($result2 as $key => $value) {
          $res[]=$value['RSS_id'];
        }
      foreach ($res as $key => $value) {
        $rqt = "SELECT * FROM RSS WHERE id=$value";
        $result3[] = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_BOTH );
      }
      foreach ($result3 as $key => $val) {
          if(!empty($val)){
            $res1[] = $val;
          }
        }
        return $val;
      }


      return $result3;
    }

    // retourne les infos des nouvelles contenant le mot clef demandé
    function getInfoNouvelleSFromMotClef($motClef){
      $motClef = SQLite3::escapeString ($motClef);
      $rqt = "SELECT titre,url,id FROM nouvelle where titre LIKE '%$motClef%' or description LIKE '%$motClef%'"; // on recherche tous les RSS contenant le mot clé dans le titre
      $result3 = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
      return $result3;
    }


    // Acces à un objet RSS à partir de son URL
    function readRSSfromURL($url) {
        // vérification de la présence du rss de l'url dans la base de données
        $rqt = "SELECT * FROM RSS WHERE url = '$url'";
        $result = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_BOTH );
        if (! $result) {
            return NULL;
        } else {
            $rqt = "SELECT id FROM RSS WHERE url = '$url'";
            $result = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
            return (new RSS ( $url, $result [0] ['id'] ));
        }
    }

   /**
    * Créé un utilisateur dans la base de donée
    * @return true si utilisateur créé, false si déjà existant
    */
    function createUser($login,$mdp):bool{
      $login = SQLite3::escapeString ($login);
      $mdp = SQLite3::escapeString ($mdp);
      $rqt = "SELECT login FROM utilisateur WHERE login='$login'"; //
      $result = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
      if(!$result){
        $rqt = "INSERT INTO utilisateur(login,mp) VALUES ('$login','$mdp')";
        $result = $this->db->exec($rqt);
        return true;
      } else{
      return false;
    }
    }

    function verifUser($login,$mdp){
      $login = SQLite3::escapeString ($login);
      $mdp = SQLite3::escapeString ($mdp);
      $rqt = "SELECT * FROM utilisateur WHERE login='$login' and mp='$mdp'"; //
      $result = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
      if($result){
        return true;
      }
      return false;
    }

    // Met à jour un flux
    function updateRSS(RSS $rss) {
        // Met à jour uniquement le titre et la date
        $titre = $this->db->quote ( $rss->titre () );
        $date = date('l jS \of F Y h:i:s A');
        $q = "UPDATE RSS SET titre=$titre, date='$date' WHERE url='" .
                 $rss->url () . "'";
        try {
            $r = $this->db->exec ( $q );
            if ($r == 0) {
                die ( "updateRSS error: no rss updated\n" );
            }
        } catch ( PDOException $e ) {
            die ( "PDO Error :" . $e->getMessage () );
        }
    }

    // ////////////////////////////////////////////////////////
    // Methodes CRUD sur Nouvelle
    // ////////////////////////////////////////////////////////

    // Acces à une nouvelle à partir de son titre et l'ID du flux
    function readNouvellefromTitre($titre, $RSS_id) {
        // vérification de la présence du rss de l'url dans la base de données
        $titre = SQLite3::escapeString ($titre); //Eviter les erreurs avec les caractères spéciaux dans la requête sql
        $RSS_id = SQLite3::escapeString ($RSS_id);
        $rqt = "SELECT * FROM nouvelle WHERE titre = '$titre' and RSS_id = '$RSS_id'";
        $result = $this->db->query ( $rqt )->fetchColumn ();
        if ($result == 0) {
            return NULL;
        } else {

            return ($result [0]);
        }
    }

    // Vidage du flux
    function vidageFlux($RSS_id){
      // On supprime les nouvelles de la BD
      $rqt = "DELETE FROM nouvelle WHERE RSS_id=$RSS_id";
      $result = $this->db->exec($rqt);

      // On recréé les nouvelles
      $rqt = "SELECT url FROM RSS WHERE id=$RSS_id";
      $result = $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
      $rss = $this->readRSSfromURL ( $result[0]['url'] ); // on lit l'url du flux
    }

    // Renvoi les informations d'une nouvelle en fontion de s
    function getInfoNouvelleFromRSSID($RSS_id){
      $rqt = "SELECT id FROM nouvelle WHERE RSS_id = '$RSS_id'";
      return $this->db->query ( $rqt )->fetchAll ( PDO::FETCH_ASSOC );
    }

    // Crée une nouvelle dans la base à partir d'un objet nouvelle
    // et de l'id du flux auquelle elle appartient
    function createNouvelle(Nouvelle $n, $RSS_id) {
        $nouvelle = $this->readNouvellefromTitre ( $n->titre (), $RSS_id );
        if ($nouvelle == NULL) {
            try {
                $urlImageNouvelle = SQLite3::escapeString ( $n->urlImage () );
                $dateNouvelle = SQLite3::escapeString ( $n->date () );
                $titreNouvelle = SQLite3::escapeString ( $n->titre () );
                $descriptionNouvelle = SQLite3::escapeString ( $n->description () );
                $urlNouvelle = SQLite3::escapeString ( $n->url () );
                $rqt = "INSERT INTO nouvelle (date,titre,description,url,image,RSS_id) VALUES ('$dateNouvelle','$titreNouvelle','$descriptionNouvelle','$urlNouvelle','$urlImageNouvelle',$RSS_id)";
                $result = $this->db->exec ( $rqt );
                if ($result == 0) {
                    die ( "createNouvelle error: no nouvelle inserted\n" );
                }
            } catch ( PDOException $e ) {
                die ( "PDO Error :" . $e->getMessage () );
            }
        }
    }

    // ////////////////////////////////////////////////////////
    // Methodes CRUD sur utilisateur
    // ////////////////////////////////////////////////////////

    function addFluxUtilisateur(int $RSS_id, string $utilisateur){
      $utilisateur = SQLite3::escapeString ( $utilisateur );
      $rqt = "INSERT INTO abonnement (utilisateur_login,RSS_id,nom) VALUES ('$utilisateur',$RSS_id,'abonnement')";
      echo "qlshkdqkljdqkljdlqdljqsdljqsdljqdlsjlqjldqjldj";
      $result = $this->db->exec ( $rqt );
    }


}
?>
