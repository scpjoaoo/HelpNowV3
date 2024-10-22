<?php
class Conexao {
    private static $instance = null;
    private $conn;

    private $servidor = "127.0.0.1";
    private $usuario = "root";
    private $senha = "";
    private $database = "helpnow";

    private function __construct() {
        $this->conectar();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Conexao();
        }
        return self::$instance;
    }

    private function conectar() {
        $this->conn = new mysqli($this->servidor, $this->usuario, $this->senha, $this->database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getConexao() {
        return $this->conn;
    }
}
?>