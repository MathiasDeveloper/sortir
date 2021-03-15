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

Download composer dependencies

```bash
composer install ; npm i ; npm run dev
```

Migrate database

```bash
php bin/console doctrine:migrations:migrate
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

Watch on NPM

```bash
npm run watch
```

## Tools

- [**Tailwind CSS IntelliSense**](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss): intellisense for Tailwind CSS on VS Code

### Merge from original repository

```bash
git remote add upstream git@github.com:MathiasDeveloper/sortir.git
git fetch upstream
git merge upstream/main
```
