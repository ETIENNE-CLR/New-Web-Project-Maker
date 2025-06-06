#!/bin/bash

# Activer les agents de connexion
bash git/agents.sh

# Faire le push
if git push -u origin main; then
    bash git/_displayMessage.sh "✅ GitHub mis à jour"
else
    bash git/_displayMessage.sh "❌ Le push n'a pas marché"
fi
