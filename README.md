# Symfony - Gestion des Absences IUT Laval

Étudiants de deuxième année en informatique à l’IUT de Laval, nous devons mettre en œuvre un projet web avec symfony.

## Etudiants

* Baptiste Buvron
* [Morgan Nehdi](https://morgan-nehdi.com/)
* Antoine Lancelot
* Ludovic Cheron


## Démarrer avec le projet

1 ) Création fichier .env.local
Mettre les informations de sa base de donnée dans le fichier .env.local

2 ) Composer & npm

```bash
composer install
npm install
```

3 ) Création de la base de données

```bash
php bin/console doctrine:database:create
```

4 ) Faire les migrations de la base de données

```bash
php bin/console doctrine:migrations:migrate
```

5 ) Création des fausses données

```bash
php bin/console doctrine:fixtures:load
```

5 ) UI

```bash
npm run dev-server
```

5 ) Lancer le serveur de développement

```bash
php -S localhost:8000 -t public/
```