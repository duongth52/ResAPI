<?php
    class Product{
        private $conn;
        private $tb_name = "products";
        public $id;
        public  $name;
        public $description;
        public $price;
        public $category_id;
        public $category_name;
        public $created;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
           $query =   "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created 
                        FROM ". $this->tb_name. " p   LEFT JOIN categories c ON p.category_id = c.id 
                        ORDER BY p.created DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
        public function create(){
            $query = "INSERT INTO products (`name`, `description`, `price`, `category_id`, `created`) 
                      VALUES (:name, :description, :price, :category_id, :created)";

            $stmt = $this->conn->prepare($query);

            /*htmlspecialchars() : các thẻ  html không có tác dụng, có thể echo ra ngoài */
            /*strip_tags() loại bỏ các các thẻ html và php*/

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->created = htmlspecialchars(strip_tags($this->created));

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':created', $this->created);


            if($stmt->execute()){
                return true;
            }
            return false;

        }


        public  function  read_one(){
            $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                      FROM " .$this->tb_name. " p LEFT JOIN categories c ON p.category_id = c.id 
                      WHERE p.id = ? LIMIT 0,1 ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1,$this->id);
            $stmt->execute();


            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->name = $row['name'];
            $this->price = $row['price'];
            $this->description = $row['description'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            $this->created = $row['created'];
        }


        public  function update(){
            $query = "UPDATE " .$this->tb_name." 
                      SET 
                        name = :name,
                        description = :description,
                        price = :price,
                        category_id = :category_id
                      WHERE id = :id ";
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id=htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
            if($stmt->execute()){
                return true;
            }
            return false;

        }
        public  function delete(){
            $query = "DELETE FROM ". $this->tb_name." WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $this->id=htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id);

            // execute query
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        public  function search($keywords){
            $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                      FROM " . $this->tb_name . " p LEFT JOIN categories c ON p.category_id = c.id
                      WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                      ORDER BY p.created DESC";

            $stmt = $this->conn->prepare($query);
            $keywords=htmlspecialchars(strip_tags($keywords));
            $keywords = "%{$keywords}%";
            $stmt->bindParam(1, $keywords);
            $stmt->bindParam(2, $keywords);
            $stmt->bindParam(3, $keywords);

            $stmt->execute();
            return $stmt;
        }


        public function readPaging($from_record_num, $record_per_page){
            $query =  "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                        FROM " . $this->tb_name . " p LEFT JOIN categories c ON p.category_id = c.id
                        ORDER BY p.created DESC
                        LIMIT ?, ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(2, $record_per_page, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public  function  count(){
            $query = "SELECT COUNT(*) as total_rows FROM " . $this->tb_name . " ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_rows'];
        }

    }

?>