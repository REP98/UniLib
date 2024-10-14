# Files

Gracias al uso de [league/flysystem](https://flysystem.thephpleague.com/docs/getting-started/) tenemos algunas clases para manejar los archivos y directorios

## Clases

Todas la clases tienen estos métodos:

- `public static function disk(FilesystemAdapter $adapter): self` Inicia la conexión según el adaptador
- `public function set_config(array $config): self` Establece configuraciones adicionales

- *class Dir* Maneja directorios.
  - `public function create(string $path): self` Crea un nuevo directorio
    - `string $path` ruta del directorio a crear
  - `public function delete(string $path): self` Borra un directorio
    - `public function exists(string $path): bool`  Verifica si un directorio existe
- *class Stream* Maneja recursos
  - `public function write(string $path, $stream): self` Escribe el recurso
    - `string $path` ruta del recurso
    - `Resource $stream` Archivo de Recurso
  - `public function read(string $path)` Lee un recurso
    - `string $path` ruta del recurso
- *class File* Maneja Archivos
  - `public function write(string $path, $contents): self` Escribe un nuevo archivo
    - `string $path` ruta del recurso
    - `string $contents` Contenido
  - `public function read(string $path)` Lee un archivo
  - `public function delete(string $path): self` Borra un Archivo
  - `public function copy($source, $destination): self` Copia un archivo
  - `public function move($source, $destination): self` Mueve un archivo
  - `public function exists(string $path): bool` verifica si un archivo existe
  - `public function has(string $path): bool` Esta función verifica si existe o no un archivo o directorio
  - `public function contents(string $path, bool $recursive = true, bool $toArray = false): DirectoryListing|array` Esta función permite leer el contenido de un directorio y obtener una matriz de `['file' => [/*Archivo encontrados*/], 'dir' => [/*Directorios encontrados*/]]` si `$toArray` es `true`; si quieres conocer más de esta función revisa [Directory Listings](https://flysystem.thephpleague.com/docs/usage/directory-listings/)

Adicional a esta todas esta clases hacer uso del método mágico `__call` para invocar funciones directamente de [league/flysystem](https://flysystem.thephpleague.com/docs/getting-started/).

También esta la clase `Adapter` con métodos para adaptadores preconfigurados

- `public static function local(string $rootPath = null, $visibility = null) : LocalFilesystemAdapter` Permite la configuración del adaptador local, si `rootPath` no se define intentara verificar si existe la constante `ROOT_PATH` o si existe la configuración de `[root => [path => 'path/']]`
- `public static visibility(array $file, array $dirname)` permite establecer las configuraciones de visibilidad
- `public static function FTP(array $settings)` permite crear un adaptador FTP para comunicación, para conocer mas visita [FTP Adapter](https://flysystem.thephpleague.com/docs/adapter/ftp/) y recuerde instalar el adaptador correcto.

## Ejemplo de Uso

```php
use UniLib\Files\Adapter;
use UniLib\Files\Dir;
use UniLib\Files\File;

$path = "path/to/folder";
$file = "myfile.txt";
$ds = DIRECTORY_SEPARATOR;

$dir = Dir::disk(Adapter::local());
// Creamos la carpeta si no existe
if (!$dir->exists($path)) {
    $dir->create($path);
}

$fileSystem = File::disk(Adapter::local());
// Creamos el archivo si no existe
if (!$fileSystem->has($path.$ds.$file)) {
    $file->write($path.$ds.$file, "Esto es un archivo");
}
```

## Log

Se a configurado una clase para el uso de registros de archivos log de sistema a travez del uso de la libreria [`Monolog\Monolog`](https://seldaek.github.io/monolog/doc/01-usage.html).

Su uso es muy simple, de forma automatica se carga para el registro de errores en el sistem.

- `Log::init()` Inicializa el sistema de log.

Tambien tiene los métodos:

- Debug
- Notice
- Info
- Warning
- Error
- Critical
- Alert
- Emergency

### Uso

```php
Log::int(); // Inicializa los Log
Log::Debug('Prueva de evento debug'); //Registra el debug

var $underfine; // Registra un error
```
