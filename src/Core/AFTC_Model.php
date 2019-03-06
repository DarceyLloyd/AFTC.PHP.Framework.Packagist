<?php
/**
 * Author: Darcey Lloyd
 * Date: 16/12/2015
 */

namespace AFTC\Framework\Core;

use AFTC\Framework\Config;
use Doctrine\DBAL\DriverManager;
use AFTC\Framework\Core\AFTCDataBase;


class Model
{
	// http://www.doctrine-project.org/projects/dbal.html
	// http://doctrine-orm.readthedocs.io/projects/doctrine-dbal/en/latest/index.html
	// https://www.thedevfiles.com/2014/08/simplifying-database-interactions-with-doctrine-dbal/
    // https://www.doctrine-project.org/projects/doctrine-dbal/en/2.7/reference/query-builder.html#sql-query-builder
    
    // Usage Examples
    
    // $result = $this->db->con->executeQuery("select * from users");
    // pre($result);
    // $rows = $result->rowCount();
    // pre($rows);
    // pre( $this->db->con->rowCount() );
    
    // $low = 2;
    // $sql = "SELECT * FROM users where user_id <= ?";
    // $stmt = $this->db->con->prepare($sql);
    // $stmt->bindValue(1, $low);
    // $result = $stmt->execute();
    // pre($stmt->fetchAll());
    // pre($stmt->rowCount());
    
    // $users = $this->db->con->fetchAll('SELECT * FROM users');
    // pre($users);
    
    // $low = 2;
    // $queryBuilder = $this->db->con->createQueryBuilder();
    // $stmt = $queryBuilder
    //     ->select('user_id', 'first_name')
    //     ->from('users')
    //     ->where('user_id <= ?')
    //     ->setParameter(0, $low);
    // $results = $queryBuilder->execute()->fetchAll();
    // pre($results);
    

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	//public $con;
	private $database;
	protected $db;
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
	    if (!Config::$useDatabase){
	        $p1 = get_class ($this);
            // $p2 = get_class ($p1);
	        $html = "
<h1>AFTC Framework</h1>
<h2>ERROR</h2>
<p>The class <b>". $p1 . "</b> is attempting to access a database when database access has been disabled in config!<br>
<b>Please enable database connectivity in App/Config/Config.php by setting \$useDatabase to true</b></p>
<hr>
<p>NOTE: If you wish to control database access on a controller by controller (page by page) level,
enable database access in Config.php and then enable or disable db access in your routes App/Config/Routes.php</p>
";
	        echo($html);
	        die();
        }
	    
        
        // NOTE This will connect if no connection has been created already
		$this->database = AFTCDataBase::getInstance();
		$this->db = $this->database->con; // To allow developer models to use $this->db->dbalCommand
		//trace("Database(): Instance created/obtained id:[" . $this->database->getID() . "]");
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function getConnection()
	{
		return $this->database->con;
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}