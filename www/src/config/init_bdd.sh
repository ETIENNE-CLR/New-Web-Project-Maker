#!/usr/bin/env bash
set -euo pipefail

# --------------------------
# Code généré par ChatGPT
# --------------------------

# répertoire du script (résout le problème des chemins relatifs)
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
INIT="$SCRIPT_DIR/init_bdd.sql"
INSERT="$SCRIPT_DIR/insert_data.sql"

# vérification des fichiers
for f in "$INIT" "$INSERT"; do
  if [ ! -f "$f" ]; then
    echo "Erreur : fichier introuvable : $f" >&2
    exit 2
  fi
done

# concatène en mémoire et pipe vers mysql
cat "$INIT" "$INSERT" | mysql -u root -p

# Message de sortie
echo "✅ La base de données a été importé avec succès."
