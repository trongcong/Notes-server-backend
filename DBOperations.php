<?php 
class DBOperations{ 
    private $host = '127.0.0.1';
    private $user = 'root';
    private $db = 'notes';
    private $pass = '';
    private $conn;

    public function __construct(){
        try { 
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    public function insertUser($name, $email, $password, $phone){
        
 	    $unique_id = uniqid('', true);
        $hash = $this->getHash($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = "INSERT INTO users(unique_id, name, email, password, phone, status, salt, created_at) VALUES(:unique_id, :name, :email, :password, :phone, 'inactive', :salt, NOW() )";

        $query = $this->conn->prepare($sql);
        
        $query->execute(
            array(
                ':unique_id' => $unique_id, 
                ':name' => $name, 
                ':email' => $email, 
                ':password' => $encrypted_password, 
                ':phone' => $phone, 
                ':salt' => $salt,
            )
        );

        if ($query) { 
            return true; 
        } else { 
            return false; 
        }
    }

    public function checkUserExist($email){
        
        $sql = 'SELECT COUNT(*) from users WHERE email =:email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array('email' => $email));
    
        if($query){
    
            $row_count = $query -> fetchColumn();
    
            if ($row_count == 0){  
                return false; 
            } else {  
                return true; 
            }
        } else {  
            return false;
        }
    }

    public function checkLogin($email, $password) {
        
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));
        $data = $query -> fetchObject();
        $salt = $data -> salt;
        $hash = $data -> password;
    
        if ($this -> verifyHash($password.$salt, $hash) ) {
    
    
            $user["name"] = $data -> name;
            $user["email"] = $data -> email;
            $user["phone"] = $data -> phone;
            $user["unique_id"] = $data -> unique_id;
            return $user;
    
        } else {
    
            return false;
        }
    
        }

    public function getHash($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;
    }

    public function verifyHash($password, $hash) {
        return password_verify ($password, $hash);
    }

    public function checkPass($email, $password) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this-> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));
        $data = $query -> fetchObject();
        print_r($data);
        $salt = $data -> salt;
        $hash = $data -> password;
        if ($this->verifyHash($password.$salt, $hash)) {
            echo "Pass is correct!";
        } else {
            echo "Pass is error!";
        } 
    }
}
?>