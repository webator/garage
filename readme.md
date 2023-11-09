Afin d'installer la webapp, voici les étapes:

Pré-requis techniques:
XAMP v3.3.0

1) Copier le contenu du dossier garage dans le dossier htdocs ou html ou www selon votre serveur web.

2) Configuration de Apache, modifier le fichier httpd-vhosts.conf en laissant uniquement ce VirtualHost et en adaptant le chemin d'accès au dossier où vous avez copier le projet:

<VirtualHost localhost:80>
    DocumentRoot "C:/xampp/htdocs/garage/public"
    DirectoryIndex index.php
    <Directory "C:/xampp/htdocs/garage/public">
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
</VirtualHost>

3) Créer la base de donnée (par exemple: garage) via phpMyAdmin

3) Lancer %url_web_server%/install/index.php et entrer les informations de connexion à la DB.

4) Le script créera les tables ainsi que les données exemple (services, témoignages...)

5) Le login admin est automatiquement créé:

Login portail administrateur:

/admin
Utilisateur: admin@admin.ch
Mot de passe: 12345678
.