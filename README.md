# contact-form

Test Technique ACSEO

## Environnement de développement

### Pré-requis

* PHP 7.4
* Composer
* Symfony CLI
* Docker
* Docker-compose

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
```

### Créer un compte Admin

```bash
symfony console app:add-user --admin
```

### Lancer les tests

```bash
php bin/phpunit --testdox
```
