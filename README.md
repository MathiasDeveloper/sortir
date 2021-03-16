# Sortir.com - ENI project

[![php](https://img.shields.io/static/v1?label=PHP&message=v7.4&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

[![symfony](https://img.shields.io/static/v1?label=Symfony&message=v5.2&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com)
[![symfony-cli](https://img.shields.io/static/v1?label=Symfony%20CLI&message=v4.23&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com/download)

[![tailwind](https://img.shields.io/static/v1?label=Tailwind%20CSS&message=v2.0&color=38B2AC&style=flat-square&logo=tailwind-css&logoColor=ffffff)](https://tailwindcss.com)

## Links

- [Google Sheet de suivi](https://docs.google.com/spreadsheets/d/131CAxNME372qm2FX7gnCs4deH3-LuFOWtwokA7fnBF0/edit)

## Setup

**Link for get Symfony CLI**

MACOS : 
```bash
curl -sS https://get.symfony.com/cli/installer | bash
```

LINUX :

```bash
wget https://get.symfony.com/cli/installer -O - | bash
```

WINDOWS :

[Downloads exe](https://symfony.com/download)

---

Download composer dependencies

```bash
composer install ; npm i ; npm run dev
```

Migrate database

```bash
php bin/console doctrine:migrations:migrate ; php bin/console doctrine:fixtures:load
```

Execute local server

```bash
symfony server:start
```

### More

Get info about project

```bash
php bin/console about
```
if use Symfony CLI

```bash
symfony console about
```

Build webpack

```bash
npm run watch; npm run dev; npm run build;
```

## Tools

- [**Tailwind CSS IntelliSense**](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss): intellisense for Tailwind CSS on VS Code

### Merge from original repository

```bash
git remote add upstream git@github.com:MathiasDeveloper/sortir.git
git fetch upstream
git merge upstream/main
```

### Entities modification

```bash
php bin/console doctrine:schema:update --force ; php bin/console doctrine:migrations:migrate
```

### PHP Lint

```bash
composer phpcs
```

```bash
./vendor/bin/php-cs-fixer fix
```

### PHPstan

```bash
composer phpstan
```

