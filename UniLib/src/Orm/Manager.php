<?php
declare(strict_types=1);

namespace UniLib\Orm;

use Medoo\Medoo;
use UniLib\Orm\DB;
use UniLib\Traits\Singleton;
use UniLib\Files\Dir;
use UniLib\Files\File;
use UniLib\Files\Adapter;
use PDOStatement;
use PDO;
/**
 * Manager
 */
class Manager extends DB
{
	use Singleton;

	private function __construct(?array $config = []) {
		parent::__construct($config);
	}

	private static function connected($pdo): self
	{
		$db = new self([
			'pdo' => $pdo,
			'type' => 'sqlite'
		]);
		return $db;//->set_connect($pdo);
	}

	public function set_connect($pdo): self
	{
		parent::__construct([
			'pdo' => $pdo,
			'type' => 'sqlite'
		]);

		return $this;
	}
	/**
	 * Crea tabla en la DB
	 * @param  string       $table   Nombre de la tabla
	 * @param  array        $columns Columnas y configuraciones de la tabla
	 * @param  string|array $options Opciones de la tabla
	 * @return \PDOStatement|null
	 */
	public function create_table(string $table, array $columns, array|string $options = []): ?PDOStatement
	{
		if ( empty($options) && $this->type == "mysql") {
			$options = ["ENGINE" => "InnoDB"];
		}
		return $this->create($table, $columns, $options);
	}
	/**
	 * Borra una tabla de DB
	 * @param  string $table Nombre de Tabla
	 * @return \PDOStatement|null
	 */
	public function drop_table(string $table): ?PDOStatement
	{
		return $this->drop($table);
	}
	/**
	 * Crea Vistas en la DB
	 * @param  string $view   Nombre de la vista
	 * @param  string $select Matriz o sintaxis SQL de la consulta de la vista
	 * @return \PDOStatement|null
	 */
	public function create_view(string $view, array|string $select): ?PDOStatement
	{
		$viewName = $this->tableQuote($view);
		$querySelect = "";
		if (is_array($select)) {
			$map = [];
			$table = $select['table'];
			$where = array_key_exists('where', $select) ? $select['where'] : null;
			$columns = array_key_exists('columns', $select) ? $select['columns'] : null;
			$join = array_key_exists('join', $select) ? $select['join'] : null;
			$querySelect = $this->selectContext($table, $map, $join, $columns, $where);
		} else if(is_string($select)) {
			$querySelect = $select;
		}

		$command = 'CREATE VIEW';

        if (in_array($this->type, ['mysql', 'pgsql', 'sqlite'])) {
            $command .= ' IF NOT EXISTS';
        }
		return $this->exec("{$command} {$viewName} AS {$querySelect}");
	}
	/**
	 * Borra un vista creada
	 * @param  string $view Nombre de la vista a crear
	 * @return \PDOStatement|null
	 */
	public function drop_view(string $view): ?PDOStatement
	{
		return $this->exec("DROP VIEW {$view};");
	}

	// SQLITE
	public static function new_db(string $name, string $path, $ext = "sqlite3"): ?Manager 
	{
		$dir = Dir::disk(Adapter::local());
		$file = File::disk(Adapter::local());

		if (!$dir->exists($path)) {
			$dir->create($path);
		}

		$fileName = $path.DIRECTORY_SEPARATOR.$name.".".$ext;

		if ( !$file->exists($fileName) ) {
			$pdo = new PDO("sqlite:".$fileName);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::connected($pdo);
		}

		return null;
	}
}
?>