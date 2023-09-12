# Exécution d'un site en local avec WAMP ou MAMP

Voici comment exécuter un site en local sur Wamp ou Mamp.

## Prérequis

- Téléchargement de WAMP ou MAMP :
  - WAMP : (https://www.wampserver.com/)
  - MAMP : (https://www.mamp.info/)

## Étapes

### 1. Installation de WAMP ou MAMP

- Téléchargez et installez WAMP ou MAMP en suivant les instructions fournies sur les sites Web respectifs.

### 2. Copiez votre site dans le répertoire approprié

- Placez les fichiers de votre site web (HTML, PHP, CSS, JavaScript, etc.) dans le répertoire de votre serveur local. Le chemin habituel est le suivant :
  - WAMP : Copiez vos fichiers dans le répertoire `C:\wamp64\www\`.
  - MAMP : Copiez vos fichiers dans le répertoire `/Applications/MAMP/htdocs/`.

### 3. Démarrage du serveur

- **WAMP** : Recherchez l'icône de WAMP dans la barre des tâches (en bas à droite de votre écran), cliquez dessus, puis sélectionnez "Start All Services" pour démarrer le serveur Apache et MySQL.

- **MAMP** : Lancez l'application MAMP, cliquez sur "Start Servers" pour démarrer Apache et MySQL.

### 4. Accédez à votre site web en local

- Ouvrez un navigateur web (comme Google Chrome, Firefox, ou Safari) et entrez l'URL suivante :
  - WAMP : (http://localhost/votredossier/)
  - MAMP : (http://localhost:8888/votredossier/)

  Assurez-vous de remplacer "votredossier" par le nom du dossier contenant vos fichiers de site web.

### 5. Arrêt du serveur

- Lorsque vous avez terminé de travailler localement sur votre site, arrêtez le serveur en utilisant les options fournies par WAMP ou MAMP.

# Mise en place de la base de données et création de l'admin

### 1. La base de données

- Télécharger et Ouvrez MySQL Workbench.
- Ouvrez l'onglet Database et cliquez sur Connect to Database.
- Entrez l'Hostname: 127.0.0.1 et le Port: 3306 ainsi que l'Username: root et le Mot de Passe: root
- Une fois connecté à la base de données, ouvrez l'onglet server et cliquez sur Data Import. 
- Importer database_garage.sql en cochant la case Import from Self-Contained File et en selectionnant l'emplacement du fichier.
- Cliquez sur Start Import et la base de données garage est maintenant créer et fonctionnel.

### 2. Création de l'admin

- Vous pouvez voir qu'il y a déjà un admin de créer dans la table administrator.
-  Si vous souhaitez changer l'email et le mdp de l'admin, il vous suffit de cliquer dessus et d'appuyer sur apply.
