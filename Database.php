<?php

class Database
{
    private string $host;
    private string $base;
    private string $user;
    private string $password;
    private PDO $pdo;

    public function __construct($dbName){
        require __DIR__ . '/vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
    
        $this->host = $_ENV['DB_HOST'];
        $this->base = $_ENV[$dbName];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];

        $this->connect();

    }

    private function connect()
    {
        try{
            $strConection = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->base);
            $this->pdo = new PDO($strConection, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            printf("Falha na conexão: %s", $e->getMessage());
        }
    }
    
    public function query(string $strQuery, array $params = [], bool $fetchResults = true)
    {
        $stmt = $this->pdo->prepare($strQuery);
        $stmt->execute($params);
        return $fetchResults ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->rowCount();
    }
}