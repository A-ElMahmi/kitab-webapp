<?php


class DB {
    private static $db;
    
    public static function connect() {
        if (isset($_ENV["VERCEL_DEV"]) === false) {
            $dotenv = new Symfony\Component\Dotenv\Dotenv();
            $dotenv->load(__DIR__."/.env");
        }

        $host = $_ENV["POSTGRES_HOST"];
        $dbName = $_ENV["POSTGRES_DATABASE"];
        $user = $_ENV["POSTGRES_USER"];
        $password = $_ENV["POSTGRES_PASSWORD"];
        $endpoint = explode(".", $host)[0];

        try {
            $dsn = "pgsql:host=$host;port=5432;dbname=$dbName;options=endpoint=$endpoint;sslmode=require";
            self::$db = new PDO( $dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException) {
            throw new Exception("Unable to connect to server");
        }
    }

    
    public static function query(string $queryStatement, array $options = []) : array|false {
        return self::baseQuery($queryStatement, $options)->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function queryAll(string $queryStatement, array $options = []) : array|false {
        return self::baseQuery($queryStatement, $options)->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function baseQuery(string $queryStatement, array $options = []) : PDOStatement {
        $sql = self::$db->prepare($queryStatement);
        $sql->execute($options);
        return $sql;
    }
}