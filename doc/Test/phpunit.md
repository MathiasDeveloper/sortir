# How to work test on app 

When you develop on app, you need to use phpunit for create test suite.

## Configuration 

### Units tests
For test unit you can find a directory :

```bash
tests/
└── units
```

On this directory you can set all what you need for test your entity.


### Integration test 

On Symfony you can develop functionnal test for test app integration.

```bash
├── bootstrap.php
└── integrations
    └── Services
        └── RegisterTest.php
```

On project we have _phpunit.xml.dist_ files for set configuration of phpunit on application.
We use this file for set bootstrap so that phpunit knows which file loaded when starting the application.

On this file we set environment variable for use component Kernel. We can use functionnal-test
for test if data is send on database or not, for this we need to use KernelTestCase which is a php unit testcase overlay
belonging to Symfony

### Bootstrap file 

see that :

_Bootstrap file instructs autoloading to composer._

```php
require dirname(__DIR__).'/vendor/autoload.php';
```

we can specify variable environment on .env file, All the environment variables 
that the application needs are embedded in this file and loaded using the DotEnv component


```php
use Symfony\Component\Dotenv\Dotenv;

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
```
