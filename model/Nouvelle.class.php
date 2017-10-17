<?php
class Nouvelle {
    private $titre; // Le titre
    private $date; // Date de publication
    private $description; // Contenu de la nouvelle
    private $url; // Le lien vers la ressource associée à la nouvelle
    private $urlImage; // URL vers l'image

    // Fonctions getter
    function titre() {
        return $this->titre;
    }
    function date() {
        return $this->date;
    }
    function description() {
        return $this->description;
    }
    function url() {
        return $this->url;
    }
    function urlImage() {
        return $this->urlImages;
    }

    // Charge les attributs de la nouvelle avec les informations du noeud XML
    function update(DOMElement $item) {
        $this->titre = $item->getElementsByTagName ( 'title' )->item ( 0 )->textContent;
        $this->date = $item->getElementsByTagName ( 'pubDate' )->item ( 0 )->textContent;
        $this->url = $item->getElementsByTagName ( 'link' )->item ( 0 )->textContent;
        $this->urlImage = $item->getElementsByTagName ( 'enclosure' )->item ( 0 )->getAttribute (
                'url' )->textContent;
        $this->description = $item->getElementsByTagName ( 'description' )->item (
                0 )->textContent;
        $this->urlImage = '';
    }
    function downloadImage(DOMElement $item, $imageId) {
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
        $url = $item->getElementsByTagName ( 'enclosure' )->item ( 0 )->getAttribute (
                'url' );

        if ($url != NULL) {
            // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
            $this->image = 'images/' . $imageId . '.jpg';
            // On télécharge l'image à l'aide de son URL, et on la copie localement.
            file_put_contents ( $this->image, file_get_contents ( $url ) );
        }
    }
}
?>
