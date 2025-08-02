<!-- Texte à remplacer : 'new.project.maker' -->

## Commandes à executer pour le vhost
### Activer le vhost
Copier le fichier `*.conf` présent dans ce répertoire dans le dossier `/etc/apache2/sites-available`.
```bash
sudo cp www/env/new.project.maker.conf /etc/apache2/sites-available
```

Avant d'activer le vhost, il faut s'assurer qu'il n'y ait pas d'erreur de syntaxe dans le fichier (petite vérification). :
```bash
sudo apache2ctl -t
```
> Qui doit retourner :
> ```bash
> Syntax OK
> ```
Ensuite activez le vhost grâce à cette commande :
```bash
sudo a2ensite new.project.maker.conf
```

Si la syntaxe est ok, rechargez Apache2 :
```bash
sudo service apache2 reload
```

### Activer l'host sur Windows pour la reconnaissance de l'URL
Pour ce faire ouvrez le bloc-notes **en tant qu'administrateur**, puis ouvrez le fichier `hosts` qui se trouve dans `C:\Windows\System32\drivers\etc`.

Copiez-y les lignes suivantes en fin de fichier :
```
127.0.0.1       new.project.maker
::1             new.project.maker
```

### Accéder au site
En vous rendant sur <a href="http://new.project.maker/"><button>new.project.maker/</button></a>.