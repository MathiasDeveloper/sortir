# Sortir.com - ENI project <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v7.4&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)

[![symfony](https://img.shields.io/static/v1?label=Symfony&message=v5.2&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com)
[![symfony-cli](https://img.shields.io/static/v1?label=Symfony%20CLI&message=v4.23&color=000000&style=flat-square&logo=symfony&logoColor=ffffff)](https://symfony.com/download)

[![tailwind](https://img.shields.io/static/v1?label=Tailwind%20CSS&message=v2.0&color=38B2AC&style=flat-square&logo=tailwind-css&logoColor=ffffff)](https://tailwindcss.com)

- [Links](#links)
- [I. Setup](#i-setup)
  - [Local](#local)
  - [Production](#production)
- [II. Tools](#ii-tools)
  - [II. a. Install Symfony CLI](#ii-a-install-symfony-cli)
  - [II. b. Merge from original repository](#ii-b-merge-from-original-repository)
  - [II. c. Entities modification](#ii-c-entities-modification)
  - [II. d. PHP Lint](#ii-d-php-lint)
  - [II. e. PHPstan](#ii-e-phpstan)
  - [III. Translate](#iii-translate)

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

### Local

Download composer dependencies

```bash
composer install ; npm i ; npm run dev
```

If you want to compile CSS and JS in live

```bash
npm run watch
```

Migrate database
> Migrate new migrations, fixtures for data  
> If you have any error, it's often about current data which not compatible with new migration  
> Truncate table where you have errors

```bash
php bin/console doctrine:migrations:migrate ; php bin/console doctrine:fixtures:load
```

Launch local server

```bash
symfony server:start
```

### Production

Build webpack

```bash
npm run build
```

## II. Tools

- [**Tailwind CSS IntelliSense**](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss): intellisense for Tailwind CSS on VS Code

Get info about project

```bash
php bin/console about
```

if use Symfony CLI

```bash
symfony console about
```

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

Make new migration file from entities modifications

```bash
php bin/console make:migration
```

Check if entities are valid

```bash
php bin/console doctrine:schema:validate
```

Launch new migrations
> If current data are not compatible with changements, you will have some errors, try to truncate tables

```bash
php bin/console doctrine:migrations:migrate
```

Update database with entities modifications and migrate

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

### III. Translate

If you need to translate message on app :

Use this on twig file for to tell symfony to read the message between the tags

```twig
    {% trans %}Your profile{% endtrans %}
```

All configuration of translation is present to _project/config/packages/translation.yaml_

For add new language you need specify on fallbacks new languages in array for exemple '_es_'

```yaml
    fallbacks: ['en', 'fr', 'es']
```

Generate files with command symfony :

```bash
    php bin/console translation:update --force [fr] or other language 
```
