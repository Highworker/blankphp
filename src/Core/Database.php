<?php
namespace Sergejandreev\Blankphp\Core;
use PDO;
class Database
{
    public function connection(): PDO
    {
        $dsn = "pgsql:host=localhost;port=5432;dbname=postgres;";
        // make a database connection
        return new PDO($dsn, '', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}