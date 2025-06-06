#!/bin/bash

# Activer les agents
source git/agents.sh

# Pousser en créant la branche distante si besoin
git push -u origin main || git push origin main

if [ $? -eq 0 ]; then
    bash git/_displayMessage.sh "✅ Push effectué avec succès"
else
    bash git/_displayMessage.sh "❌ Le push n'a pas marché"
fi
