<?php
    class database {
        public $queryCount = 0;
        public $queryTotalTime = 0;
        public $queries = Array();
        public $log;
        protected $db;
        protected $host;
        protected $user;
        protected $pass;
        protected $name;

        function __construct($host, $user, $pass, $name) {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->name = $name;
            $this->MySQLiConnect();
        }

        protected function MySQLiConnect() {
            $db = mysqli_connect($this->host, $this->user, $this->pass, $this->name) or die("Error! " . mysqli_error($db));
            $this->db = $db;
            $this->query('SET names utf8');
        }

        public function fetch($res) {
            return mysqli_fetch_assoc($res);
        }

        public function query($string) {
            $this->queryCount++;
            $startQueryTime = microtime(true);
            $q = mysqli_query($this->db, $string);
            $endQueryTime = microtime(true);
            $this->queryTotalTime += $endQueryTime - $startQueryTime;
            $this->queries[] = $string;
            $this->log .= "\r\n[" . microtime(true) . "] " . $string . " - " . (round($endQueryTime - $startQueryTime) * 1000) . " мс.";
            return $q;
        }

        public function insert_id() {
            return mysqli_insert_id($this->db);
        }

        public function filter($string) {
            if (gettype($string) == "string")
                return mysqli_real_escape_string($this->db, $string);
            else return $string;
        }

        public function num_rows($res) {
            return mysqli_num_rows($res);
        }

        public function error() {
            return mysqli_error($this->db);
        }

        protected function mysqli_result($res, $row = 0, $col = 0){
            if (mysqli_num_rows($res) && $row <= (mysqli_num_rows($res)-1) && $row >= 0){
                mysqli_data_seek($res,$row);
                $resrow = mysqli_fetch_row($res);
                if (isset($resrow[$col])){
                    return $resrow[$col];
                }
            }
            return false;
        }

        public function result($res, $row) {
            return $this->mysqli_result($res, $row);
        }

        public function power_query($query) {
            $q = $this->query($query);
            return $this->fetch($q);
        }

    }
?>