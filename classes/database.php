<?

class database {

	private $_connection;
	private static $_instance; //The single instance
	private $_host = "localhost";
	private $_username = "root";
	private $_password = "************";
	private $_database = "gk";
	

	
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() 
	{
		if(!self::$_instance) 
		{ 
			// If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __destruct() 
	{
		$this->_connection = null;
    }
	// Constructor
	private function __construct() 
	{
		
		try 
		{	 
			$this->_connection = new PDO( 
				'mysql:host=localhost;dbname=gk', 
				'root', 
				'*******************', 
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
			);	
								 
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		
		
	}
	
	

	private function __clone() 
	{
		//throw new \Exception("Cannot unserialize a singleton.");
	}
	
	public function __wakeup()
    {
        //throw new \Exception("Cannot unserialize a singleton.");
    }

	
	// Get mysqli connection
	public function getConnection()
	{
		return $this->_connection;
	}

	

}