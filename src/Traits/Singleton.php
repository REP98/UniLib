<?php
declare(strict_types=1);

namespace UniLib\Traits;
/**
 * Trait Singleton
 * establece función para evitar el new
 */
trait Singleton {
    /**
     * instance
     * @var null|static
     */
	private static $instance = null;
    /**
     * Carga la instance
     * @param mixed $arg Argumentos según la clase invocada
     * @return  self
     */
	public static function I(...$arg) {
		if(self::$instance === null) {
			self::$instance = new static(...$arg);
		}
		return self::$instance;
	} 

	private function __construct()
    {
        // Evitar la creación directa de la instancia
    }

    private function __clone()
    {
        // Evitar la clonación de la instancia
    }

    public function __wakeup()
    {
        // Evitar la deserialización de la instancia
    }
}