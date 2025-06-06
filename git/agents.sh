#!/bin/bash

# Lancer l'agent de connection
eval "$(ssh-agent -s)"

# Choisir la bonne clé SSH
cleSSH="Cle_github"     # Clé de mon PC portable
cleSSH="id_rsa"         # Clé de mon PC gaming
cleSSH="etienneclr_key" # Clé du PC de l'école

# Ajouter la clé à l'agent
ssh-add ~/.ssh/$cleSSH

# Tester la connexion à GitHub
ssh -T git@github.com

# Configurer la branche distante
brancheName="main"
git branch --set-upstream-to=origin/$brancheName $brancheName

# Configurer l'URL du dépôt distant
urlRepo="git@github.com:ETIENNE-CLR/New-Project-Maker.git"
git remote set-url origin $urlRepo

# Afficher un petit message
bash git/_displayMessage.sh "Les agents sont connectés"
