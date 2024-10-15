<?php 
declare(strict_types=1);

namespace UniLib\Utils;

/**
 * Session
 */
class Session
{
	/**
	 * Status Constante
	 */
	const SESSION_STARTED = true;
	const SESSION_NOT_STARTED = false;
	/**
	 * Session State
	 * @var bool
	 */
	private $sessionState = self::SESSION_NOT_STARTED;
	/**
	 * Instance
	 * @var static
	 */
	private static $instance;
	/**
	 * Constructor
	 */
	private function __construct(){ }
	/**
	 * Instanceador de sessiones
	 * @return static
	 */
	public static function I()
	{
		if ( !isset(self::$instance))
        {
            self::$instance = new self;
        }
        
        self::$instance->start();
        
        return self::$instance;
	}
	/**
	 * (Re)start Session
	 * @return bool
	 */
	public function start(): bool
	{
		if ( $this->sessionState == self::SESSION_NOT_STARTED )
        {
            $this->sessionState = session_start();
        }
        
        return $this->sessionState;
	}

	public function has(string|int $name): bool
	{
		return array_key_exists($name, $_SESSION);
	}

	 /**
    *    Stores datas in the session.
    *    Example: $instance->foo = 'bar';
    *    
    *    @param    name    Name of the datas.
    *    @param    value    Your datas.
    *    @return    void
    **/
    
    public function __set( $name , $value )
    {
        $_SESSION[$name] = $value;
    }
    
    
    /**
    *    Gets datas from the session.
    *    Example: echo $instance->foo;
    *    
    *    @param    name    Name of the datas to get.
    *    @return    mixed    Datas stored in session.
    **/
    
    public function __get( $name )
    {
        if ( isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
    }
    
    
    public function __isset( $name )
    {
        return isset($_SESSION[$name]);
    }
    
    
    public function __unset( $name )
    {
        unset( $_SESSION[$name] );
    }

     /**
    *    Destroys the current session.
    *    
    *    @return    bool    TRUE is session has been deleted, else FALSE.
    **/
    
    public function destroy()
    {
        if ( $this->sessionState == self::SESSION_STARTED )
        {
            $this->sessionState = !session_destroy();
            unset( $_SESSION );
            
            return !$this->sessionState;
        }
        
        return FALSE;
    }
}
?>