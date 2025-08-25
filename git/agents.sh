#!/bin/bash

# Lancer l'agent SSH
eval "$(ssh-agent -s)"

# Choisir la bonne clé SSH
cleSSH="Cle_github"     # Clé de mon PC portable
cleSSH="cfpt_key"       # Clé du PC de l'école
cleSSH="gitkey"         # Clé de mon PC gaming

# Ajouter la clé à l'agent
ssh-add ~/.ssh/$cleSSH

# Tester la connexion SSH GitHub
ssh -T git@github.com

# Configurer l'URL du dépôt distant
urlRepo="git@github.com:ETIENNE-CLR/New-Web-Project-Maker.git"
git remote set-url origin $urlRepo

# Message
bash git/tools/displayMessage.sh "🌐 Les agents sont connectés"

