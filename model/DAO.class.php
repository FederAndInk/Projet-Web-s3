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

    // Créé un utilisateur dans la base de donée
    function createUser($login,$mdp){

    }

    // Met à jour un flux
    function updateRSS(RSS $rss) {
        // Met à jour uniquement le titre et la date
        $titre = $this->db->quote ( $rss->titre () );
        $q = "UPDATE RSS SET titre=$titre, date='" . $rss->date () . "' WHERE url='" .
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
}
?>
