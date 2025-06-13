#!/bin/bash

# Activer les agents SSH
source git/agents.sh

# Récupérer l'état du repo
git fetch

# Mode test uniquement
if [[ "$1" == "--test" ]]; then
    LOCAL=$(git rev-parse @)
    REMOTE=$(git rev-parse @{u})

    if [[ "$LOCAL" == "$REMOTE" ]]; then
        bash git/tools/displayMessage.sh "✅ Aucun pull nécessaire"
    elif [[ "$LOCAL" != "$REMOTE" ]]; then
        bash git/tools/displayMessage.sh "📥 Vous avez besoin de pull"
    fi
    exit 0
fi

# Vérifier si des commits locaux n'ont pas été push
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse @{u})
BASE=$(git merge-base @ @{u})

if [[ "$LOCAL" == "$REMOTE" ]]; then
    # Tout est à jour
    git pull && bash git/tools/displayMessage.sh "✅ Pull effectué"
    exit 0
elif [[ "$LOCAL" == "$BASE" ]]; then
    # Le repo distant a des commits en avance
    git pull && bash git/tools/displayMessage.sh "✅ Pull effectué"
    exit 0
elif [[ "$REMOTE" == "$BASE" ]]; then
    # Le repo local a des commits non pushés
    bash git/tools/displayMessage.sh "⚠️  Vous avez des commits non pushés."
    read -p "❓ Voulez-vous écraser vos commits locaux avec le pull ? (o/n) " confirm

    if [[ "$confirm" == "o" ]]; then
        git reset --hard origin/$(git rev-parse --abbrev-ref HEAD)
        bash git/tools/displayMessage.sh "🧨 Commits locaux écrasés, pull effectué"
    else
        bash git/tools/displayMessage.sh "❌ Pull annulé pour éviter la perte de commits"
        exit 1
    fi
else
    # Historique divergent
    bash git/tools/displayMessage.sh "⚠️ Conflit entre vos commits et ceux de GitHub"
    bash git/tools/displayMessage.sh "❌ Pull impossible automatiquement. Veuillez résoudre les conflits manuellement."
    exit 1
fi
