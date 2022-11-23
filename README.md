# SAFER Symfony

## Prérequis

- Nodejs >= 8.19.3
- composer >= 2.4.3
- Symfony cli

## Extensions PhpStorm (optional)

- Symfony Support
- .env file support
- PHP Annotations
- Atom Material Icons

## Les technos du projet

- Assets avec webpack encore
  - [Boostrap](https://getbootstrap.com/docs/5.2/getting-started/introduction/)
  - [Boostrap Icons](https://icons.getbootstrap.com/)
  - [Sass/Scss](https://sass-lang.com/documentation/)

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

## Lancer le projet

Pour pouvoir lancer l'application il est nécéssaire de lancer plusieurs scripts

### Démarrer le serveur avec Symfony CLI

Lancer le serveur de développement
```bash
symfony server:start
```

### Gestion des assets

Lancer le serveur de compilation des assets (webpack)
```bash
npm run watch
```

### Gestion des mails

Lancer le worker qui traite les mails
```bash
npm run worker
```





