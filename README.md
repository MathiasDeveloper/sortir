# Sortir.com - ENI project <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v7.4&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

[![symfony](https://img.shields.io/static/v1?label=Symfony&message=v5.2&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com)
[![symfony-cli](https://img.shields.io/static/v1?label=Symfony%20CLI&message=v4.23&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com/download)

[![tailwind](https://img.shields.io/static/v1?label=Tailwind%20CSS&message=v2.0&color=38B2AC&style=flat-square&logo=tailwind-css&logoColor=ffffff)](https://tailwindcss.com)

- [Links](#links)
- [I. Setup](#i-setup)
  - [I. a. More](#i-a-more)
- [II. Tools](#ii-tools)
  - [II. a. Install Symfony CLI](#ii-a-install-symfony-cli)
  - [II. b. Merge from original repository](#ii-b-merge-from-original-repository)
  - [II. c. Entities modification](#ii-c-entities-modification)
  - [II. d. PHP Lint](#ii-d-php-lint)
  - [II. e. PHPstan](#ii-e-phpstan)

## Links

- [Google Sheet de suivi](https://docs.google.com/spreadsheets/d/131CAxNME372qm2FX7gnCs4deH3-LuFOWtwokA7fnBF0/edit)
- [DocumentVision](https://drive.google.com/file/d/1VQM9pxCYF7nC5RkaQD6G_TdjFPG_hPs_/view?usp=sharing)
- Diagrammes:
  - [DiagClasse](https://drive.google.com/file/d/1ns1J-5P5rwfAdU1aXhhQy-cJGs3LURWH/view?usp=sharing)
  - [DiagEtatSortie](https://drive.google.com/file/d/10Bbsz8DzsUwOveYMYyf-s6MR-kxf3f80/view?usp=sharing)
- [ProcessusGestionSorties](https://drive.google.com/file/d/1NXGoYOBPdm4q3xlo5j3_CrcF_UBUPmM0/view?usp=sharing)
- Design:
  - [SortiesDesktop](https://drive.google.com/file/d/18MFFSH4v3AcdpCw-rArNVaNX5upjOeO9/view?usp=sharing)
  - [SortiesSmartphone](https://drive.google.com/file/d/1flaWmtIMdJw1qO2YJcEZv4HUNZKcahAv/view?usp=sharing)

## I. Setup

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

### I. a. More

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

## II. Tools

- [**Tailwind CSS IntelliSense**](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss): intellisense for Tailwind CSS on VS Code

### II. a. Install Symfony CLI

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

**OR**

```ps1
Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh') ; scoop install symfony-cli
```

### II. b. Merge from original repository

```bash
git remote add upstream git@github.com:MathiasDeveloper/sortir.git
git fetch upstream
git merge upstream/main
```

### II. c. Entities modification

```bash
php bin/console doctrine:schema:update --force ; php bin/console doctrine:migrations:migrate
```

### II. d. PHP Lint

```bash
composer phpcs
```

```bash
./vendor/bin/php-cs-fixer fix
```

### II. e. PHPstan

```bash
composer phpstan
```
