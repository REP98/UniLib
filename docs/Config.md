# Config

Sistema de configuraciones como archivos `.env` y archivos `config.php` o `.ini`

## Env

Esta clase hace uso de [Dotenv](https://github.com/vlucas/phpdotenv) para cargar archivos `.env`

### Métodos

- `public function get(string $key, $default = null): mixed` Obtiene una variable de configuración

Se han establecido algunas configuraciones obligatorias necesarias para Medoo y otros áreas

```ENV
APP_NAME='UniLib' ## NOMBRE DE LA APP USANDO POR TWIG
DEBUG_MODE=true ## MODO DEBUG USADO PARA LOG
# DATABASE USADO POR MEDOO
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password

```

### Ejemplo de Uso

```php
// I es un cargador universal alias getInstances
$env = Env::I();
$env->get('DB_HOST', 'localhost'); // Obtiene DB_HOST si no lo carga retornara localhost

```

## Class Config

Clase de configuraciones, permite usar archivos `.php` y `.ini` para crear archivos de configuraciones para nuestro proyecto esta clase hace uso de [league/config](https://config.thephpleague.com/) 

### Métodos

- `Config::I(string $filePath)`: Permite cargar un archivo de configuraciones
- `public function get(string $key, $default = null): mixed` Obtiene una configuración cargada previamente

### Ejemplo de uso

```php
$config = Config::I('path/of/file.php')
$config->get('cache.path', null);
```

file.php

```php
<?php
return [
  "cache" => [
    "path" => __DIR__."/../cache"
  ]
];
```
