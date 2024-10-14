# Model

La clase abstracta Model permite crear un ORM más útil similar a Eloquent

## Propiedades

- `protected array $setting` Configuraciones adicionales para la conexión de DB
- `protected Medoo $db` Almacena la información de la DB
- `protected string $table` Nombre de la tabla de la DB
- `protected string $fieldID` Campo ID de la tabla por defecto es 'id'
- `protected ?array $join` Permite establecer las relaciones de la tabla
- `public int $id` ID de la ultima consulta

## Metodos

- `public function create(array $data): ?PDOStatement` Permite crear un nuevo registro en la table
  - `array $data` Datos de  registro
- `public function read(array|string $columns = '*', callable|array $where = []): ?array`  Obtiene todos los resultado de una consulta
  - `array|string $columns` Campos a consultar, por defecto es '*'
  - `callable|array $where` Función o matriz de condiciones para la consulta
- `public function update(array $data, array $where): ?PDOStatement` Actualiza un registro en su tabla
  - `array $data` Datos de  registro
  - `array $where` Condición para actualizar
- `public function delete(array $where): ?PDOStatement` Borra un registro de la tabla según la condición
  - `array $where` Condición para borrar
- `public function find(int $id, array|string $columns = '*')` Busca los datos de un ID y filtra según los campos dados
  - `int $id` Id a buscar
  - `array|string $columns` Columnas a filtrar para obtener
- `public function all(array|string $columns = '*'): array` Obtiene todos los resultados de la tabla
  - `array|string $columns` Columnas a filtrar para obtener
- `public function where(array $conditions)` Realiza una consulta según la condición dada.
  - `array $conditions` Condición
- `public function first(bool $withJoin = true)` Obtiene el primer resultado de la DB
  - `bool $withJoin` indica si se toma en cuenta las relaciones si las hay.
- `public function has(array $conditions, bool $withJoin = true): bool` Verifica si un resultado existe en la DB según la condición dada
  - `array $conditions` Condición
  - `bool $withJoin` indica si se toma en cuenta las relaciones si las hay.
- `public function length(?array $conditions = null, ?array $where = null, bool $withJoin = true): ?int` Cuenta la cantidad de registros que hay en la DB.
  - `array $conditions` Son las columnas a contar, en Medoo esto seria `$column`
  - `?array $where = null` Condición a aplicar
  - `bool $withJoin` indica si se toma en cuenta las relaciones si las hay.
- `public function transaction(callable $callback): void` Inicia una transacción en la DB para conocer mas vea [Action de Medoo](https://medoo.in/api/action)
- `public function log()` Muestra los registro log de la DB para que esto funcione debe configurar `logging` a `true` en la conexión o definir `DB_LOG` a `true` en el `.env`
- `public function save()` Permite guardar cuando hay cambios en los datos de la ultima consulta, los métodos `find` y `first` almacenan de forma temporal los datos obtenidos permitendo el uso de cosas como `$mymode->id` a si mismo el uso de cosas como `$Mymodel->name = 'Perez'` no se almacenaran el la DB hasta que haga uso de esta función.

Adicional a esto puedes usar funciones como `sum`, `max` u otros de Medoo ya que `Model` hace uso del método mágico `__call`.

## Ejemplo de Uso

```php
use UniLib\Orm\Model;

class User extends Model {
  protected string $table = 'users';
}

$user = User::I();
// Crea el Registro
$user->create([
  'username' => "myuser",
  "password" => "MyPass1234"
]);
// Consultamos el primero registro
$data = $user->first();
// Obtenemos el username
print($data->username); // Imprime myuser
```
