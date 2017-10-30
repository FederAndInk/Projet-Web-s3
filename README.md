# Site Web de veille d'information personnalisé
[Lien vers la Release]()\
[Lien du site exemple](http://www-etu-info.iut2.upmf-grenoble.fr/~deslotl/ProgWeb/Projet-Web-s3/)
## Installation
1. Extraire le contenu du dossier Projet-Web-s3 de l'archive dans le dossier de votre site web (là où vous voulez l'installer)
2. Verifier que les droits (ecriture/lecture et execution pour les dossiers) pour le groupe et les autres sont mis sur les dossiers/fichiers :
  * model/data (go+rwx)
  * model/rss.db (go+rw)
  * model/images (go+rwx)
  * tous les autres avec le droit de lecture (go+r) seulement et de traversement (go+rx) (pour les dossiers seulement)
```bash
chmod -R go-rwx,go+rX *<dossierRacine>*
chmod go+x *<dossierRacine>*
chmod go+rw model/data/rss.db
chmod go+rwx model/data/
chmod go+rwx model/images
```
3. Vous pouvez reinitialiser la base de données :
```bash
rm model/images/*
cd model/data/
sqlite3 rss.db
```
```sqlite
.read create.sql
.exit
```
4. C'est tout bon, le fichier index.php va rediriger automatiquement lorsque l'on va aller dans le dossier du site
  
## Mode d'emploi
1. Vous devez tout d'abord créer un compte utilisateur
2. Ajoutez votre premier flux RSS dans la zone prévue (ex : http://www.lemonde.fr/rss/une.xml)
3. Puis vous pouvez :
  * Afficher la liste des nouvelles d'un flux en cliquant sur le titre du flux
  * Afficher la mosaïque des images du flux en cliquant sur l'icone images à droite du flux
  * Chercher par mot clé dans toutes les nouvelles des flux (titre et description)
  * Vidanger un flux (Les nouvelles plus disponibles seront effacées)
  * Mettre à jour le flux pour récupérer les dernières nouvelles
  * Supprimer un flux
  * Se déconnecter
  * Se reconnecter ( avec ses informations :) )
