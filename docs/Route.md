# Router

UniLib hace uso de la libreria popula [`pecee/simple-router`](https://github.com/skipperbent/simple-php-router) para el manejo simple de rutas.

## Uso

La clase responsable es `Route` extendida a `\Pecee\SimpleRouter\SimpleRouter` quien tiene solo un método:

- `public static function init($fileRouters, array $settings = []): void` Esta método recibe como parametros la ruta del archivo de tus rutas y una matriz de configuraciones y aqui se inicializa las rutas, por defecto este metodo se carga automataicamente en la clase `Core` lo cual permite que te dediques solo a tus rutas.

### Configuraciones de Route

En su archivo de configuraciones puede usar el siguiente esquema para configurar las rutas:

```php

use UniLib\Router\Views\ErrorPage;

return [
  // resto de configuraciones
  'route' => [
    "namespace" => null, // Permite establecer un NameSpace para los controladores
    'csrfVerifier' => new \UniLib\Router\Middlewares\CsrfVerifier(), // Middlewares Responsable de la verificación de CSRF
    // Vistas Establecidas para errores
    "errview" => [
      'unauthorized' => [ErrorPage::class, 'unauthorized'],
      'forbidden' => [ErrorPage::class, 'forbidden'],
      'notFound' => [ErrorPage::class, 'notFound'],
      'methodNotAllowed' => [ErrorPage::class, 'methodNotAllowed']
   ]
  ],
  // ...
]

```

Para conocer mas visita [Simple Route](https://github.com/skipperbent/simple-php-router/blob/master/README.md).

### Ejemplo

index.php

```php
<?php
// Definimos Ruta raiz
if (!defined("DS")) {
  define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("ROOT_PATH")) {
  define("ROOT_PATH", __DIR__.DS);
}
// Cargamos el Autoload Composer
require "vendor/autoload.php";
// Inicamos la librerias
use UniLib\Core;

Core::start([
  "route" => ROOT_PATH.'route.php',
  "config" => ROOT_PATH.'setting.php',
]);
```

.htaccess

```htaccess
RewriteEngine on
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-l
RewriteRule ^(.*)$ index.php/$1
```

`ROOT_PATH.'route.php'`

```php
<?php
use UniLib\Router\Route;

Route::get('/', function(){
   echo "Welcome to UniLib";
});
```

Listo como puedes apreciar no hay configuraciones adicionales ni más.
