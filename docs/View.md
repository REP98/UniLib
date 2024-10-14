# View

Aqui se hace uso de la famosa libreria [TWIG](https://twig.symfony.com/) para la carga y manipulación de las vista en php. se ha creado un ayudante o función para hacer utilidad practica a esta sección, solo use la función `view`y podra cargar y renderizar las vista de forma rapida y practica.

## Configuraciones

El Esquema de configuraciónes para la vista es:

```php
return [
  // ..
  'view' => [
   'path' => '', // Ruta donde se alamacenarar las vistas en tu proyecto
    'ext' => 'twig', // Extension de la vistas
    'setting' => [
        // Folder Path Cache
        'cache' => env('DEBUG_MODE', false) ? false : ROOT_PATH.'/storage/cache', // Ruta donde se alamacenara la cache si el modo debug esta desactivo
        'debug' => env('DEBUG_MODE', false), // Modo debug
        'charset ' => 'utf-8' // Codificación
    ]
  ]
]
```

## Invocación

`view(string $tpl, array $data = []): string` Con esta funcion puede cargar sus vista de forma simple, la variable `$tpl` es la ruta de la vista despues de la carpeta configurada y `$data` el contexto a enviar.

Ejemplo

```php
echo view('pages.index', ["count" => 0]);
// si ha configurado view.path en /root/to/view
// esto buscara la vista /root/to/view/pages/index.twig y le pasara la variable $count
```
