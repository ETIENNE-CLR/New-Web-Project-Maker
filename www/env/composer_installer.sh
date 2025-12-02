#!/bin/bash

echo "🚮 Suppression de Composer installé via APT (si présent)..."
sudo apt remove -y composer

echo "🧹 Suppression manuelle du binaire global obsolète..."
sudo rm -f /usr/bin/composer
sudo rm -f /usr/local/bin/composer

echo "📥 Téléchargement de la dernière version stable de Composer..."
php -r "copy('https://getcomposer.org/composer-stable.phar', 'composer.phar');"

if [ -f "composer.phar" ]; then
    echo "✅ Fichier téléchargé avec succès."
else
    echo "❌ Échec du téléchargement de Composer. Vérifie ta connexion internet."
    exit 1
fi

echo "🚚 Installation globale dans /usr/local/bin..."
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

echo "🔎 Vérification de la version installée :"
composer --version
