<?php 

class UserController{
    protected string $username;
    protected string $email;
    protected string $password;

    protected $pdo;

    public function __construct() {
        $this->connect();
    }

    //*Database Connection
    private function connect() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=LETTERBOXD_wannaBe', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('[Database connection failed]') . $e->getMessage();
        }
    }

    //*Create new user
    public function createUser(string $username, string $email, string $password) {
        //Create new user
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE
    }

    //*Update user data
    public function updateUser(int $id, string $username, string $email, string $password) {
        //Update user by id
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE
    }

    //*Delete user data
    public function deleteUser(int $id) {
        //Delete user by id
        //! ADD CASCADE TO THE QUERY
    }
}

?>