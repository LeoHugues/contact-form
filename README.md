# contact-form

Test Technique ACSEO

## Environnement de développement

### Pré-requis

* PHP 7.4
* Composer
* Symfony CLI
* Docker
* Docker-compose
* node v15.8.0
* npm 7.5.2

Il est possible de vérifier les prérequis (sauf pour Docker) avec la commande (CLI Symfony) :

```bash
symfony check:requirements
```

### Lancer l'environnement de développement

```bash
composer install
npm install
npm run build
docker-compose up -d
symfony serve -d
symfony console doctrine:migrations:migrate
```

### Créer un compte Admin

```bash
symfony console app:add-user --admin
```

### Lancer les tests

```bash
php bin/phpunit --testdox
```

### Pistes d'améliorations

* Créer des fixtures
* Améliorer le processus d'intégration continu
* Améliorer les tests
* Générer un fichier Json mieux organisé
* Mieux organiser le BackOffice
