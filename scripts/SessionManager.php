<?php

/*
Singleton class that handles sessions for us
*/

class SessionManager{


	public static function getManager()
    {
        static $manager = null;
        if (null === $manager) {
            $manager = new static();
        }

        return $manager;
    }


    protected function __construct()
    {
    }


    private function __clone()
    {
    }

    private function __wakeup()
    {
    }


	public function startSession()
	{
	if (session_status() == PHP_SESSION_NONE) {
	session_start();
	}
	session_regenerate_id();
	}

	public function endSession()
	{
		session_destroy();
	}

	public function setSessionVar($var, $value)
	{
		$_SESSION["'".$var."'"] = $value;
	}

	public function getSessionVar($var)
	{
		if(isset($_SESSION["'".$var."'"]))
		{
			return $_SESSION["'".$var."'"];
		}
		else
		{
			return "invalid";
		}
	}

}


?>