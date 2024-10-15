# UniLib

Micro-Framework PHP modular para soluciones rápidas y eficientes. Combina librerías ligeras para crear aplicaciones sencillas y poderosas en tiempo récord. Perfecto para desarrolladores que buscan velocidad, simplicidad y flexibilidad sin comprometer el rendimiento.

## Clasess

- [Config](docs/Config.md)
- [File](docs/File.md)
- [Orm](docs/Orm.md)
- [Route](docs/Route.md)
- [View](docs/View.md)

Adicional tenemos una platilla que puede descargar y demos que ver.

- [Template]()
- [Demo](https://github.com/REP98/UniLib-demo)

## Clase Inicializadora

La `Core` es la que inicializa todo el ecosistema aunque puede usted crear su propia inicializacion, esta cuenta con los métodos:

- `public static function before(Callable $callback)` Permite ejecutar una función antes de la carga de las rutas pero despues de cargar las configuraciones
- `public static function start(array $config)` es la responsable de inicializar todo el sistema, las configuraciones recibidas aqui son la ruta de route y de setting.

### Ejemplo

```php
Core::start([
  "route" => ROOT_PATH.'route.php',
  "config" => ROOT_PATH.'setting.php',
]);
```

Esto establece la ruta de route a la raiz y la de setting

## Sessiones

Se ha integrado una clase especial que permite manipulas las secciones de manera mas optima.

```php
use UniLib\Utils\Session;

$s = Session::I(); // Esto inicializa la clase y verifica si session_start esta iniciado
$s->userId = 1; // Esto es los mismo que $_SESSION['userId'] = 1;
unset($s->userId); // Aqui destruimo solo userId
$s->destroy(); // Destruye todas las secciones
```

### Métodos

- `public function start(): bool` Inicia `session_start` si no esta activada, si lo esta reinicia las secciones
- `public function has(string|int $name): bool` Verifica si una clave existe en una sessión.
- `public function destroy()` Destruye las secciones

## Ayudantes

Aparte de los ayudantes que hay en las librerias integradas hemos integrado algunas más.

- `env(string $key, $default = null)` Permite buscar una clave en su archivo `.env`
- `config(string $key, $default = null)` Permite obtener una configuración.
- `view(string $tpl, array $data = [])` Permite renderizar una vista
- `session()` Invoca una clase llamada session que permite una forma mas elegantes de trabajar con secciones en forma de objectos.

## Librerias Utilizadas

- [League Config](https://config.thephpleague.com/)
- [League Flysystem](https://flysystem.thephpleague.com/docs/getting-started/)
  - [Local Filesystem Adapter](https://flysystem.thephpleague.com/docs/adapter/local/)
- [Medoo](https://medoo.in/api/new)
- [Monolog](https://seldaek.github.io/monolog/doc/01-usage.html)
- [PHP dotenv](https://github.com/vlucas/phpdotenv)
- [simple-router](https://github.com/skipperbent/simple-php-router/tree/master)
- [TWIG 3](https://twig.symfony.com/doc/3.x/)
  - [`twig/html-extra`](https://packagist.org/packages/twig/html-extra)
  - [`twig/intl-extra`](https://packagist.org/packages/twig/intl-extra)
  - [`twig/cssinliner-extra`](https://packagist.org/packages/twig/cssinliner-extra)
  - [`twig/markdown-extra`](https://packagist.org/packages/twig/markdown-extra)

## NOTA

> Espero les agrade este Micro-Framework, esto es solo para proyectos sencillos y escalabilidad controlada, si quieres algo mas robusto simpre puedes contar con nuestro amigo [Laravel](https://laravel.com/)
