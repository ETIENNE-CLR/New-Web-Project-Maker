# New Web Project Maker
Base de projet PHP Slim avec API pour démarrer rapidement un nouveau site web

## Présentation
Ce dépôt est une **base de projet web** prête à l'emploi, construite autour du micro-framework [Slim PHP](https://www.slimframework.com/). 

L'idée est simple :  
- Quand tu veux créer un nouveau site ou une API en PHP Slim, tu clones ce repo
- Puis tu changes l'URL du dépôt distant (origin) pour ton propre repo
- Ensuite tu commences à développer ton projet rapidement sans repartir de zéro

## Prérequis
* PHP 7.4 ou supérieur
* Composer (si vous n'avez pas composer, executez `bash www/env/composer_installer.sh`)
* Serveur web local (Apache)

## Installation
1. 📦Clonez le repo :
    ```bash
    git clone git@github.com:ETIENNE-CLR/New-Web-Project-Maker.git
    ```

2. 📥 Initialisez composer :
    ```bash
    cd www
    composer install
    composer update
    cd ..
    ```

3. ✏️ Si vous prévoyez de faire un vhost, avant de le build avec `www/env/vhostMaker.sh`, changer le nom de la variable `APP_NAME` par le nom de votre application
    ```bash
    APP_NAME="new-web-project-maker" # ici
    ```

4. 🔃 Changer le readme :
    ```bash
    mv 'README copy.md' 'README.md'
    ```

## Contenu
- Framework Slim configuré et prêt  
- Structure basique MVC adaptée  
- Exemple d'API REST intégrée  

--- 

Bonne création de projets web rapides et efficaces ! 🚀
