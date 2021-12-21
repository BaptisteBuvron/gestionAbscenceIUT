Tuto d'installation

1 ) Création fichier .env.local
Mettre les informations de sa base de donnée dans le fichier .env.local

1 ) Création de la base de données
php bin/console doctrine:database:create

2 ) Création des fausses données
php bin/console doctrine:fixtures:load