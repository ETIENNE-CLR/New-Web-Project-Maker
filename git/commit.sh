#!/bin/bash

# Activer les agents
source git/agents.sh

# Récupérer le message
message="${1:-}"
[ -z "$message" ] && read -p "Quel est votre message de commit : " message

# Commit
git add .
if git commit -m "$message"; then
    bash git/_displayMessage.sh "✅ Commit effectué avec succès"
else
    bash git/_displayMessage.sh "❌ Le commit n'a pas marché"
    exit 1
fi
