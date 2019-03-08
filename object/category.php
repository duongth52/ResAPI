<?php
    class  Category{
        private $conn;
        private $tb_name = "categories";

        public  $id;
        public  $name;
        public $description;
        public $created;

        public function __construct($db){
            $this->conn = $db;
        }

        public  function  read(){
            $query = "SELECT id, name, description 
                      FROM " . $this->tb_name . "
                      ORDER BY name";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;

        }

        public  function  create(){

        }

        public  function  read_one(){

        }

        public  function  update(){
            
        }
        public  function  delete(){

        }


    }

?>