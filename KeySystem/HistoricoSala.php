<?php
    class HistoricoSala
    {
        private $conn;

        public function __construct()
        { $this->conn = Connection::Connect(); }

        public function __destruct()
        { $this->conn = null; }
    }
?>