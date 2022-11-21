# SAFER

## Prérequis

- Nodejs >= 8.19.3
- composer >= 2.4.3
- Symfony cli

## Extensions PhpStorm (optional)

- Symfony Support
- .env file support
- PHP Annotations
- Atom Material Icons

## Initialisation du projet

Installation des packages php
```bash
composer install
```

Installation des packages js/css
```bash
npm i
```

Installation du certificat ssl
```bash
symfony server:ca:install
```

## Démarrer le serveur

Lancer le serveur de développement
```bash
symfony server:start
```

Lancer le serveur de compilation des assets (webpack)
```bash
npm run watch
```





