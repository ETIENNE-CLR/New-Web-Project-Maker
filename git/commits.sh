#!/bin/bash

# Activer les agents de connexion
bash git/agents.sh

# Récupérer le message de commit
message="${1:-}"
if [ -z "$message" ]; then
    read -p "Quel est votre message de commit : " message
fi

# Faire le commit
git add .
if git commit -m "$message"; then
    bash git/_displayMessage.sh "✅ Commit effectué avec succès"
else
    bash git/_displayMessage.sh "❌ Le commit n'a pas marché"
fi
