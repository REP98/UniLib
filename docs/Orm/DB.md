# DB

Clase que permite la conexión de DB

## Métodos

- `public static function Connection(?array $config = []): Medoo` Permite crear una conexión con la DB y recibe configuraciones adicionales que permiten ajustar la conexiones
- `public static function reset(): void` Reinicia la conexión de la DB

## Ejemplo de Uso

```php
$db = DB::Connection();
$db->select("mytable", '*'); // Obtiene datos de mytable
print_r($db->info()); // Imprime información de la conexión.
```
