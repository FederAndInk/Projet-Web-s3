# Site Web de veille personnalisée
[Telechargement]()
## Installation
1. Extraire l'archive dans le dossier de votre site web (là où vous voulez l'installer)
2. Verifier que les droits (ecriture/lecture et execution pour les dossiers) pour le groupe et les autres sont mis sur les dossiers/fichiers :
  * model/data (go+rwx)
  * model/rss.db (go+rw)
  * model/images (go+rwx)
  * tous les autres avec le droit de lecture (go+r) seulement et de traversement (go+rx) (pour les dossiers seulement)
```bash
chmod go+rw model/data/rss.db
chmod go+rwx model/data/
chmod go+rwx model/images
```
3. Vous pouvez reinitialiser la base de données :
```bash
rm model/images/*
cd model/data/
sqlight3 rss.db
```
```sqlight
.read create.sql
.exit
```
4. C'est tout bon, le fichier index.php va rediriger automatiquement lorsque l'on va aller dans le dossier du site
  
## Mode d'emploi
1. 
