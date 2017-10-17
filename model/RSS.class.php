<?php
require_once 'Nouvelle.class.php';
require_once 'DAO.class.php';
class RSS {
    private $titre; // Titre du flux
    private $url; // Chemin URL pour télécharger un nouvel état du flux
    private $id; // id de du flux RSS
    private $date; // Date du dernier téléchargement du flux
    private $nouvelles; // Liste des nouvelles du flux dans un tableau d'objets Nouvelle

    // Fonctions getter
    function titre() {
        return $this->titre;
    }
    function id() {
        return $this->id;
    }
    function url() {
        return $this->url;
    }
    function date() {
        return $this->date;
    }
    function nouvelles() {
        return $this->nouvelles;
    }

    // Récupère un flux à partir de son URL
    function update() {
        echo 'test';
        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument ();

        // Telecharge le fichier XML dans $rss
        $doc->load ( $this->url );

        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
        $nodeList = $doc->getElementsByTagName ( 'title' );

        // Met à jour le titre dans l'objet
        $this->titre = $nodeList->item ( 0 )->textContent;

        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'date'
        $nodeList = $doc->getElementsByTagName ( 'pubDate' );

        // Met à jour le titre dans l'objet
        $this->date = $nodeList->item ( 0 )->textContent;

        $this->nouvelles = array ();

        // TODO : changer pour prendre toutes les imgages

        // Récupère tous les items du flux RSS
        foreach ( $doc->getElementsByTagName ( 'item' ) as $node ) {

            // Création d'un objet Nouvelle à conserver dans la liste $this->nouvelles
            $nouvelle = new Nouvelle ();

            // Modifie cette nouvelle avec l'information téléchargée
            $nouvelle->update ( $node );

            // On créé la nouvelle dans la BD

            $db = new DAO (); // FIXME : dans le foreach ???? t'es sur, c'est juste pour l'acces à la BD non ?

            $db->createNouvelle ( $nouvelle, $this->id );

            // on récupère le titre de la nouvelle dans la DB
            $titre = SQLite3::escapeString ( $nouvelle->titre () );
            ;

            // On va chercher l'id de l'image dans la DB
            $rqt = "SELECT id FROM nouvelle WHERE RSS_id = '$this->id' and url = '$this->url'"; // FIXME : url c'est l'url pour la nouvelle donc pas l'url du RSS !!
                                                                                                // FIXME ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~^^^^^^^^^^
                                                                                                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Url de RSS ≠ url de la nouvelle

            var_dump ( $rqt );
            $result = $db->db ()->query ( $rqt )->fetchall ();
            var_dump ( $result );
            // $nomLocalImage = ($this->id)."_".$result[0][0++]; // FIXME : serieux 0++ ? xD

            // Télécharge l'image
            $nouvelle->downloadImage ( $node, $nomLocalImage );

            // ajoute la nouvelle au tableau des nouvelles
            $this->nouvelles [] = $nouvelle;

            // On change l'id de l'image
        }
    }

    // Contructeur
    function __construct($url, $id) {
        $this->url = $url;
        $this->id = $id;

        $this->update ();
    }
}

?>
