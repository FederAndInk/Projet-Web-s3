<?php
require_once ('RSS.class.php');
class DAO {
    private $db; // L'objet de la base de donnée

    // Ouverture de la base de donnée
    function __construct() {
        $dsn = 'sqlite:data/rss.db'; // Data source name
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
                $q = "INSERT INTO RSS (url) VALUES ('$url')"; // TODO c'est quoi ces noms de variable >_>
                $r = $this->db->exec ( $q );
                if ($r == 0) {
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
            // $sq = new RSS ( $url, $result [0] ['id'] ); TODO var not used !!
            return (new RSS ( $url, $result [0] ['id'] ));
        }
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
        var_dump ( $n );
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
