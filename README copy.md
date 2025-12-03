# Nom projet
Description

## 📝 Description du projet
Description

## ⚙️ Fonctionnalités prévues
Texte

## 🛠️ Technologies utilisées
Texte

## 🚀 Installation
### 🌐 Initialisation du backend
1. 📦Clonez le repo :
    ```bash
    git clone <lien de ce projet>
    ```

2. 📥 Initialisez composer :
    ```bash
    cd www
    composer install
    composer update
    cd ..
    ```

3. ⚙️ Créez le fichier `.env` (pour les variables de la BDD/JWT) :
    ```bash
    cd www
    echo -e "DB_HOST=localhost\nDB_NAME=xxxxx\nDB_USER=xxxxx\nDB_PASS=xxxxx\nDB_CHARSET=utf8mb4\nJWT_SECRET=xxxxx\nDEV_MOD=false\n" > .env
    cd ..
    ```

4. 🗃️ Initialisez la base de données (la première fois) :
    ```bash
    sudo apt install dos2unix
    dos2unix www/src/config/init_bdd.sh
    sudo chmod +x www/src/config/init_bdd.sh
    bash www/src/config/init_bdd.sh
    ```

    > Pour mettre à jour la base de données, il suffit de faire ça :
    > ```bash
    > bash www/src/config/init_bdd.sh
    > ```

5. 🖥️ Initialisez le vhost :<br>
    Executer `vhostMaker.sh` pour créer le fichier `.conf` automatiquement, le met dans Apache et met une copie dans `ww>/env` :
    ```bash
    sudo bash www/env/vhostMaker.sh
    ```
    Modifiez le fichier `C:\Windows\System32\drivers\etc` avec
    ```
    127.0.0.1       nom.projet
    ::1             nom.projet
    ```
    Accéder au site avec [nom.projet/](http://nom.projet/)


## 🧑‍💻 Contributeurs
**Équipe projet :**
- Etienne Caulier
