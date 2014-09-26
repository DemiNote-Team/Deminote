<?php

    class user {
        public $authorized = false;
        public $data = array();
        protected $db;

        public function __construct(database $db) {
            $this->db = $db;

            if ($_SESSION['session']) {
                $q = $this->db->query("SELECT * FROM `user` WHERE `session` = '{$_SESSION[session]}'");
                if ($this->db->num_rows($q) != 1) {
                    $this->authorized = false;
                } else {
                    $this->authorized = false;
                    $this->data = $this->db->fetch($q);
                }
            } else if ($_COOKIE['session']) {
                $q = $this->db->query("SELECT * FROM `user` WHERE `session` = '" . $this->db->filter($_COOKIE['session']) ."'");
                if ($this->db->num_rows($q) != 1) {
                    $this->authorized = false;
                } else {
                    $this->authorized = false;
                    $this->data = $this->db->fetch($q);
                    $_SESSION['session'] = $this->data['session'];
                }
            } else {
                $this->authorized = false;
            }
        }
    }

?>