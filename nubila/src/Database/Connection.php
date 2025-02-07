<?php

namespace Nubila\Database;

use PDO;

class Connection
{
    private $pdo;

    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}