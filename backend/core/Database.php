<?php

class Database 
{
    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

        if($this->connection->connect_errno)
        {
            die("Can't connect to database:" . $this->connection->connect_errno);
        }
    }

    public function get()
    {
        return $this->connection;
    }
}