# Setup app

Look at this documentation to know how to install the application

## Sommary

[I. Architecture](#i-architecture)

## I. Architecture

_Assets :_ 

```bash
     assets
     ├── app.js
     ├── boot
     │   └── bootstrap.js
     ├── components
     │   └── form.css
     └── styles
         ├── app.css
         ├── boot
         │   └── tailwind.css
         └── extras.css
```

Boot directory contain all the dependencies the application needs when starting the application


_Bin :_ 


```bash
    bin
    ├── console
    └── phpunit
```

If you need to use commands on symfony if you dont have Symfony CLI, you can use php bin/console make:wathever --argument 
for use commands.


_config :_ 


```bash
config/
├── bundles.php
├── packages
│   ├── assets.yaml
│   ├── cache.yaml
│   ├── datatables.yaml
│   ├── dev
│   │   ├── debug.yaml
│   │   ├── monolog.yaml
│   │   └── web_profiler.yaml
│   ├── doctrine.yaml
│   ├── doctrine_migrations.yaml
│   ├── framework.yaml
│   ├── mailer.yaml
│   ├── notifier.yaml
│   ├── prod
│   │   ├── deprecations.yaml
│   │   ├── doctrine.yaml
│   │   ├── monolog.yaml
│   │   ├── routing.yaml
│   │   └── webpack_encore.yaml
│   ├── routing.yaml
│   ├── security.yaml
│   ├── sensio_framework_extra.yaml
│   ├── test
│   │   ├── framework.yaml
│   │   ├── monolog.yaml
│   │   ├── twig.yaml
│   │   ├── validator.yaml
│   │   ├── web_profiler.yaml
│   │   └── webpack_encore.yaml
│   ├── translation.yaml
│   ├── twig.yaml
│   ├── validator.yaml
│   └── webpack_encore.yaml
├── preload.php
├── routes
│   ├── annotations.yaml
│   └── dev
│       ├── framework.yaml
│       └── web_profiler.yaml
├── routes.yaml
└── services.yaml
```

In this directory we find all the configurations of the application 
that the application needs, in particular the authentication but
also the security of the routes.






