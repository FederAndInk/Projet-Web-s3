<?php
// Test de la classe RSS
require_once ('RSS.class.php');
require_once ('Nouvelle.class.php');
require_once ('DAO.class.php');

// Test de la classe DAO

$dao = new DAO ();

// Test si l'URL existe dans la BD
$url = 'http://www.lemonde.fr/m-actu/rss_full.xml';

$rss = $dao->readRSSfromURL ( $url );

if ($rss == NULL) {

    echo $url . " n'est pas connu\n";
    echo "On l'ajoute ... \n";
    $rss = $dao->createRSS ( $url );
}

$url = 'https://www.nasa.gov/rss/dyn/breaking_news.rss';

$rss = $dao->readRSSfromURL ( $url );

if ($rss == NULL) {

    echo $url . " n'est pas connu\n";
    echo "On l'ajoute ... \n";
    $rss = $dao->createRSS ( $url );
}

/*
 * // Une instance de RSS
 * $rss = new RSS('http://www.lemonde.fr/m-actu/rss_full.xml',);
 *
 * // Affiche le titre
 * echo $rss->titre()."\n";
 * echo $rss->date()."\n";
 *
 * // Affiche le titre et la description de toutes les nouvelles
 * foreach($rss->nouvelles() as $nouvelle) {
 * echo ' '.$nouvelle->titre().' '.$nouvelle->date()."\n";
 * echo ' '.$nouvelle->description()."\n";
 * }
 *
 */

// Mise à jour du flux
$rss = $dao->createRSS ( $url );
$rss->update ();
$titre = $rss->titre ();
$nouvelle = $rss->nouvelles () {0};
$nouvelle = $dao->createNouvelle ( $nouvelle, $rss->id () );

?>
