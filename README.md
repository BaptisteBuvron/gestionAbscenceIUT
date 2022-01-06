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

2 ) Création de la base de données

```bash
php bin/console doctrine:database:create
```

3 ) Faire les migrations de la base de données

```bash
php bin/console doctrine:database:migration
```

4 ) Création des fausses données

```bash
php bin/console doctrine:fixtures:load
```

5 ) Lancer le serveur de développement

```bash
php -S localhost:8000 -t public/
```