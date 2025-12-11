#!/bin/bash

# Initialisation
APP_NAME="new-web-project-maker"
VHOST_FILENAME="$APP_NAME.conf"
WWW_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && cd ../ && pwd)"
PUBLIC_DIR="$WWW_DIR/public"

# Navigation vers le répertoire env
cd "$WWW_DIR/env" || exit 1

cat > $VHOST_FILENAME <<EOF
<VirtualHost *:80>
    ServerName $APP_NAME
    ServerAdmin webmaster@localhost
    DocumentRoot $PUBLIC_DIR

    <Directory $PUBLIC_DIR>
        Options -Indexes +FollowSymLinks
        AllowOverride All
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/$APP_NAME-error.log
    CustomLog \${APACHE_LOG_DIR}/$APP_NAME-access.log combined
</VirtualHost>
EOF

# Initialisation du vhost
sudo cp $WWW_DIR/env/$VHOST_FILENAME /etc/apache2/sites-available
sudo apache2ctl -t
sudo a2ensite $VHOST_FILENAME
sudo service apache2 reload

echo "✅ Le VirtualHost pour $APP_NAME a été créé et activé avec succès."
echo "Accessible avec : http://$APP_NAME"
