<?php
/*
// Test de la classe RSS
  require_once('RSS.class.php');
  require_once('Nouvelle.class.php');
  // Une instance de RSS
  $rss = new RSS('http://www.lemonde.fr/m-actu/rss_full.xml');

  // Affiche le titre
  echo $rss->titre()."\n";
  echo $rss->date()."\n";

  // Affiche le titre et la description de toutes les nouvelles
  foreach($rss->nouvelles() as $nouvelle) {
    echo ' '.$nouvelle->titre().' '.$nouvelle->date()."\n";
    echo '  '.$nouvelle->description()."\n";
  }
  */

  // Test de la classe DAO
  require_once('DAO.class.php');
  $dao = new DAO();
  // Test si l'URL existe dans la BD
  $url = 'http://www.lemonde.fr/m-actu/rss_full.xml';

  $rss = $dao->readRSSfromURL($url);
  if ($rss == NULL) {
    echo $url." n'est pas connu\n";
    echo "On l'ajoute ... \n";
    $rss = $dao->createRSS($url);
    
  }

  // Mise à jour du flux
  $rss = $dao->createRSS($url);
  $titre = $rss->titre();
  $rss->update();

   ?>
