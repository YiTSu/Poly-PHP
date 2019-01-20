<?php
    class DB{
        static private $instance;
        static private $connectsource;
        private $db = array('host'=>'127.0.0.1',
            'user'=>'sql188_131_157_',
            'password'=>'pmp837xnH5',
            'database'=>'sql188_131_157_'
        );
        private function construct(){
            
        }
        static public function getinstance(){
            if(!(self::$instance instanceof self)){
                self::$instance = new self();
            }
            return self::$instance;
        }
        public  function connect(){
            if(!self::$connectsource){
                self::$connectsource=mysqli_connect(
                    $this->db['host'],
                    $this->db['user'],
                    $this->db['password']
                    );
                if(!self::$connectsource){
                    throw new Exception("mysql connect error".mysqli_connect_error());
                    //die('mysql connect error'.mysqli_error());
                }
                mysqli_select_db(self::$connectsource,$this->db['database']);
                mysqli_query(self::$connectsource, "set names utf8");
            }
            
            
            return self::$connectsource;
        }
    }

    ?>