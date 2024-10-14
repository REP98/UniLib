# Manager

## Métodos

- `Manager::I()` Crea la conexión de DB
- `public function create_table(string $table, array $columns, array|string $options = []): ?PDOStatement` Crea una nueva tabla en la DB
  - `$table` Nombre de la Tabla a crear
  - `$columns` Matriz de columnas
  - `$options` Matriz o texto de opciones
- `public function create_view(string $view, array|string $select): ?PDOStatement` Crea una vista en la DB
  - `$view` Nombre de la vista
  - `$select` matriz o sentencia SQL de la consulta
- `public function drop_table(string $table): ?PDOStatement` Borra una tabla de la DB
- `public function drop_view(string $table): ?PDOStatement` Borra una vista de la DB
- `Manager::new_db(string $name, string $path, $ext = "sqlite3")`: Crea una nueva DB Sqlite si no existe.
  - `$name` Nombre de la Base de Datos
  - `$path` Ruta de la Base de Datos
  - `$ext` Extensión de la DB

## Ejemplo de Uso

```php
$mg = Manager::I(); // Abre la conexión
$mg->create_table("account", [
  "id" => [
    "INT",
    "NOT NULL",
    "AUTO_INCREMENT"
  ],
  "email" => [
    "VARCHAR(70)",
    "NOT NULL",
    "UNIQUE"
  ],
  "PRIMARY KEY (<id>)"
], [
  "ENGINE" => "MyISAM",
  "AUTO_INCREMENT" => 200
]);
```

Esto crea una nueva tabla llamada account. [Método Create de Medoo](https://medoo.in/api/create)

```sql
CREATE TABLE IF NOT EXISTS account (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(70) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
)
ENGINE = MyISAM,
AUTO_INCREMENT = 200
```

Para borrarla, [Método Drop de Meddo](https://medoo.in/api/drop)

```php
$mg->drop_table("account"); // Esto borra la tabla de la DB
```

También tenemos métodos para las vistas

```php
$mg->create_view('seventh_grade_students', [
  "tabla" => 'students',
  "columns" => "*",
  "where" => [
     "grade" => "7mo"
  ]
]);
```

```sql
CREATE VIEW IF NOT EXISTS seventh_grade_students AS 
SELECT * FROM students WHERE grade = '7mo';
```

Para borrar las vistas usamos

```php
$mg->drop_view("seventh_grade_students"); 
```

Adicional a esto también hay un método para crear DB solo para Sqlite.

```php
$mg = Manager::new_db('name_db', 'path/to/folder', 'sqlite3');
```
