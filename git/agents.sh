#!/bin/bash

# Lancer l'agent SSH
eval "$(ssh-agent -s)"

# Choisir la bonne clé SSH
cleSSH="Cle_github"     # Clé de mon PC portable
cleSSH="id_rsa"         # Clé de mon PC gaming
cleSSH="etienneclr_key" # Clé du PC de l'école

# Ajouter la clé à l'agent
ssh-add ~/.ssh/$cleSSH

# Tester la connexion SSH GitHub
ssh -T git@github.com

# Configurer l'URL du dépôt distant
urlRepo="git@github.com:ETIENNE-CLR/New-Web-Project-Maker.git"
git remote set-url origin $urlRepo

# Message
bash git/tools/displayMessage.sh "🌐 Les agents sont connectés"

