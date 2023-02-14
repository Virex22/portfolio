# Portfolio REMY Vincent

## Description

Voici mon portfolio, il est en cours de construction, il sera mis à jour régulièrement. Le but est de présenter
mes projets, mes compétences et mes expériences. Il est réalisé avec le framework [Symfony](https://symfony.com/) sous
la version 5.4

## Installation

### Prérequis

- PHP 7.4
- Composer
- Npm
- Docker (optionnel)

### Installation

Cloner le projet avec

```
git clone https://github.com/Virex22/portfolio.git
```

Installer les dépendances php avec

```
composer install
```

Installer les dépendances js avec

```
npm install
```

Créer un fichier `.env.local` à la racine du projet et y ajouter les variables d'environnement suivantes :

- DATABASE_URL

Mettre à jour la base de données avec :

```
php bin/console doctrine:schema:update --force
```

(en attendant de mettre en place les migrations)

## Lancement des tests

### Lancement des tests sans code coverage

Lancer les tests avec

```
php bin/phpunit
```

### Lancement des tests avec code coverage

Lancer les tests avec

```
php bin/phpunit --coverage-html var/coverage
```

## Lancement du projet

### Lancement avec Docker

Lancer les containers avec

```
docker-compose up -d
```

### Lancement sans Docker

Lancer le serveur avec

```
symfony server:start
```

## Auteur

Vincent REMY

## License

Ce projet est sous licence GNU AFFERO GENERAL PUBLIC LICENSE - voir le fichier [LICENCE.md](LICENCE.md) pour plus de
détails
