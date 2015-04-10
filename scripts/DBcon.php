<?php

class DBcon
{

	private  $mysqli;

public static function getDBcon()
    {
        static $dbcon = null;
        if (null === $dbcon) {
            $dbcon = new static();
        }

        return $dbcon;
    }

	private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    protected function __construct()
    {
	
			$this->mysqli = new mysqli("localhost", "root", "dbpw", "socialnetwork");
	if ($this->mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
	}
	
    }


    public function getMysqliObject()
	{
		return $this->mysqli;
	}
	
	public function closeConnection()
	{
		mysqli_close($this->mysqli);
	}
	
	
	
	
	

}

?>
