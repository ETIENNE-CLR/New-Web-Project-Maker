# New Web Project Maker
Base de projet PHP Slim avec API pour démarrer rapidement un nouveau site web

## Présentation
Ce dépôt est une **base de projet web** prête à l'emploi, construite autour du micro-framework [Slim PHP](https://www.slimframework.com/). 

L'idée est simple :  
- Quand tu veux créer un nouveau site ou une API en PHP Slim, tu clones ce repo
- Puis tu changes l'URL du dépôt distant (origin) pour ton propre repo
- Ensuite tu commences à développer ton projet rapidement sans repartir de zéro

## Comment utiliser ce projet ? - Comment créer un projet web
### Structure Git
1. Cloner ce dépôt :
    ```bash
    git clone https://github.com/ETIENNE-CLR/New-Web-Project-Maker.git
    ```

2. Renommer le projet :
    ```bash
    mv New-Web-Project-Maker/ Mon-Projet/
    ```
    ```bash
    cd Mon-Projet/
    ```

2. Changer l'URL du repo **important** :<br>
    Dans le fichier `git/agents.sh`, changez la ligne qui définit l'URL du repo avec l'URL de **VOTRE** repo.
    > La ligne qui définit la variable `urlRepo` :
    > ```bash
    > urlRepo="git@github.com:ETIENNE-CLR/New-Web-Project-Maker.git"
    > ```

3. Tu crées le premier commit de ton nouveau projet :
    ```bash
    bash git/commit.sh "first commit - initialisation from 'https://github.com/ETIENNE-CLR/New-Web-Project-Maker.git'"
    ```

### Structure PHP
4. Installer les dépendances via Composer :
    ```bash
    cd www
    composer install
    cd ..
    ```
5. **IMPORTANT !!**<br>
    Si vous allez utiliser **une base de donnée,** vous allez devoir créer le fichier `.env` **à la racine** du projet web :
    ```bash
    cd www
    sudo vi .env
    cd ..
    ```
    Dans ce fichier `.env`, insérez le contenu ci-dessous :
    ```env
    DB_HOST=localhost
    DB_NAME=ma_base
    DB_USER=root
    DB_PASS=Super
    DB_CHARSET=utf8mb4
    ```
    > Bien sûr, changez les informations de *votre Base de Donnée* pour que cela convienne à votre environnement

6. Recommittez les changements !
    ```bash
    bash git/commit.sh "intialisation de mon fichier `.env` pour la bdd"
    ```


7. Commencez à coder !
    > Vous trouverez un fichier `/www/env/commandes.pdf` qui donne chaque commandes à executer pour lancer le vhost.
    > Avant de lancer le vhost, pensez bien à modifier le fichier `.conf` !

## Contenu
- Framework Slim configuré et prêt  
- Structure basique MVC adaptée  
- Exemple d'API REST minimale intégrée  
- Scripts pratiques pour Git (push, commit, gestion SSH)  
- Configuration légère pour un démarrage rapide 

## Prérequis
* PHP 7.4 ou supérieur
* Composer
* Serveur web local (Apache, Nginx...)
* Git et SSH configurés (optionnel mais recommandé)

## Scripts Git inclus
Dans le dossier `git/`, plusieurs scripts facilitent la gestion de commits, push, et la configuration SSH, pour automatiser et simplifier le workflow.

--- 

Bonne création de projets web rapides et efficaces ! 🚀
