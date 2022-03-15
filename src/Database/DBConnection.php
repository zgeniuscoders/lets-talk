<?php


namespace Zgeniuscoders\Zgeniuscoders\Database;

use PDO;

class DBConnection
{
    /**
     * @var PDO
     */
    private PDO $_instance;
    /**
     * DBConnection constructor.
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string $password
     */
    public function __construct(
        private string $host,
        private string $dbname,
        private string $username,
        private string $password
    )
    {
    }

    /**
     * @return PDO
     */
    public function getPDO() : PDO
    {
        if(is_null($this->_instance))
        {
            $this->_instance = new PDO("mysql:dbname=$this->dbname;
                                            host=$this->host",
                                            $this->username,
                                            $this->password,[
                                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
                                        ]);
        }
        return $this->_instance;
    }
}