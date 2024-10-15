<?php
declare(strict_types=1);

namespace UniLib\Orm;

use Medoo\Medoo;
use UniLib\Orm\DB;
use UniLib\Traits\Singleton;
use PDOStatement;
/**
 * Clase Abstracta Modelo
 * @abstract
 */
abstract class Model {

	use Singleton;

	/**
	 * Configuraciones para la conexion de DB
	 * @access protected
	 * @var array
	 */
	protected array $setting = [];
	/**
	 * Conección de DB
	 * @access protected
	 * @var  \Medoo\Medoo
	 */
	protected Medoo $db;
	/**
	 * Nombre de la Tabla
	 * @access protected
	 * @var  string
	 */
	protected string $table;
	/**
	 * Campo ID de la Tabla
	 * @access protected
	 * @var string
	 */
	protected string $fieldID = 'id';
	/**
	 * Relaciones de consultas
	 * @access protected
	 * @var array|null
	 */
	protected ?array $join = null;
	/**
	 * Ultimos resultados
	 * @var mixed
	 */
	private $lastQuery = null;
	/**
	 * ID de la consulta
	 * @access public
	 * @var  int|string
	 */
	public int|string $id;

	private function __construct() {
		$this->db = DB::Connection($this->setting);
	}
	/**
	 * Crea un nuevo o varios nuevos registros 
	 * Ejemplo: https://medoo.in/api/insert
	 * @param  array  $data datos a insertar
	 * @return \PDOStatement
	 */
	public function create(array $data): ?PDOStatement
    {
        $statement = $this->db->insert($this->table, $data);
        $this->id = (int)$this->db->id();
        return $statement;
    }
    /**
     * Obtiene datos de la DB
     * @param  array|string $columns Columnas a filtrar
     * @param  array  $where   Condiciones
     * @return array|null
     */
    public function read(array|string $columns = '*', callable|array $where = []): ?array
    {
    	if (!empty($this->join)) {
    		return $this->db->select($this->table, $this->join, $columns, $where);
    	}
        return $this->db->select($this->table, $columns, $where);
    }
    /**
     * Actualiza los registro
     * @param  array  $data  Datos a actualizar
     * @param  array  $where Condicion de actualización
     * @return \PDOStatement|null
     */
    public function update(array $data, array $where): ?PDOStatement
    {
        return $this->db->update($this->table, $data, $where);
    }
    /**
     * Borra Registros de la DB
     * @param  array  $where Condicion
     * @return PDOStatement|null
     */
    public function delete(array $where): ?PDOStatement
    {
        return $this->db->delete($this->table, $where);
    }
    /**
     * Busca un resultado en la DB
     * @param  int    $id      ID de la DB
     * @param  string $columns (Opcional) Filtrar columnas
     * @return mixed
     */
    public function find(int $id, array|string $columns = '*')
    {
        $this->lastQuery = $this->db->get($this->table, $columns, [$this->fieldID => $id]);
        $this->id = $id;
        return $this->lastQuery;
    }
    /**
     * Obtiene todo los resultados
     * @param  array|string $columns Filtra por Columnas
     * @return array
     */
    public function all(array|string $columns = '*'): array
    {
        return $this->db->select($this->table, $columns);
    }
    // Métodos para queries complejas
    /**
     * Consulta todo con condiciones
     * @param  array  $conditions Condición
     * @return mixed
     */
    public function where(array $conditions)
    {
        return $this->db->select($this->table, '*', $conditions);
    }
    /**
     * Obtiene el primero elemento de la DB
     * @param  bool|boolean $withJoin Indica si se usa las relaciones si existen, por defecto es true
     * @return mixed
     */
    public function first(bool $withJoin = true)
    {
        $this->lastQuery = !empty($this->join) && $withJoin ?
        	$this->db->get($this->table, $this->join, '*') :
        	$this->db->get($this->table, '*');

        return $this->lastQuery;
    }
    /**
     * Verifica si existe un resultado basado en condicion
     * @param  array        $conditions Condiciones a validar
     * @param  bool|boolean $withJoin   Indica si se usa las relaciones si existen, por defecto es true
     * @return boolean
     */
    public function has(array $conditions, bool $withJoin = true): bool 
    {
    	return !empty($this->join) && $withJoin ?
    		$this->db->has($this->table, $this->join, $conditions) :
    		$this->db->has($this->table, $conditions);
    }

    // UTILES
    /**
     * Cuenta el numero de elementos de la DB
     * @param  ?array        $conditions Columna de destio a contar
     * @param  bool|boolean $withJoin   Indica si se usa las relaciones si existen, por defecto es true
     * @return int
     */
    public function length(?array $conditions = null, ?array $where = null, bool $withJoin = true): ?int
    {
    	if (!empty($this->join) && $withJoin) {
    		return !empty($conditions) ?
    			$this->db->count($this->table, $this->join, $conditions, $where) :
    			$this->db->count($this->table, $where);
    	} else {
    		return $this->db->count($this->table, $where);
    	}
    }
    /**
     * Inicia una Transacción
     * @param  callable $callback Función
     * @return void
     */
    public function transaction(callable $callback): void
    {
    	$this->db->action($callback);
    }
    /**
     * Registro Log de la DB
     * Para que funcione debe tener "logging" => true en las configuraciones de la DB
     * @return array
     */
    public function log()
    {
    	return $this->db->log();
    }

    public function save() 
    {
        if (!empty($this->lastQuery)) {
            $id = $this->lastQuery['id'];
            return $this->update($this->lastQuery, [$this->fieldID => $id]);
        }
    }

    // Metódos Magicos

    public function __call(string $name, array $args) 
    {
    	if (method_exists(Medoo::class, $name)) {
    		$default = [$this->table];
    		if (!empty($this->join)) {
    			$default[] = $this->join;
    		}
    		$arrguments = array_merge($default, $args);
    		return call_user_func_array([$this->db, $name], $arrguments);
    	}
    }

    public function __get(string $name)
    {
    	if(!empty($this->lastQuery)) {
    		$data = $this->lastQuery;
    	} else if (!empty($this->id)) {
    		$data = $this->find($this->id);
    	}

    	if ( is_array($data) && array_key_exists($name, $data) ) {
    		return $data[ $name ];
    	}
    }

    public function __set(string $key, $value)
    {
        if (array_key_exists($key, $this->lastQuery)) {
            $this->lastQuery[$key] = $value;
        }
    }
}