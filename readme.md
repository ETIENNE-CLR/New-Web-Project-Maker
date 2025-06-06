# New Web Project Maker
Base de projet PHP Slim avec API pour démarrer rapidement un nouveau site web

## Présentation

Ce dépôt est une **base de projet web** prête à l'emploi, construite autour du micro-framework [Slim PHP](https://www.slimframework.com/). 

L'idée est simple :  
- Quand tu veux créer un nouveau site ou une API en PHP Slim, tu clones ce repo  
- Puis tu changes l'URL du dépôt distant (origin) pour ton propre repo  
- Ensuite tu commences à développer ton projet rapidement sans repartir de zéro  

## Contenu
- Framework Slim configuré et prêt  
- Structure basique MVC adaptée  
- Exemple d'API REST minimale intégrée  
- Scripts pratiques pour Git (push, commit, gestion SSH)  
- Configuration légère pour un démarrage rapide 

## Comment utiliser ce projet ?
1. Cloner ce dépôt :
```bash
git clone git@github.com:ETIENNE-CLR/New-Web-Project-Maker.git mon-nouveau-projet
cd mon-nouveau-projet
```

2. Changer l'URL du dépôt distant pour ton nouveau repo :
```bash
git remote set-url origin git@github.com:TON-UTILISATEUR/ton-nouveau-repo.git
```

3. Installer les dépendances via Composer :
```bash
cd www
composer install
```

4. Configurer ton serveur local :
Vous trouverez un fichier `/www/env/commandes.pdf` qui donne chaque commandes à executer pour lancer le vhost.

5. Commencez à coder !

## Prérequis
* PHP 7.4 ou supérieur
* Composer
* Serveur web local (Apache, Nginx...)
* Git et SSH configurés (optionnel mais recommandé)

## Scripts Git inclus
Dans le dossier `git/`, plusieurs scripts facilitent la gestion de commits, push, et la configuration SSH, pour automatiser et simplifier le workflow.

--- 

Bonne création de projets web rapides et efficaces ! 🚀

---

*ETIENNE-CLR*
