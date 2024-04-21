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

    //*Get user data
    /**
     * @param $id used for get specific user
     * @return $res as an array of fetched data
     */
    public function getUser(int $id = null) {
        $sql = "SELECT * FROM user" . ($id !== null ? "WHERE `id` = :id" : "");
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($id != null) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (\PDOException $e) {
            die("Cannot get user data") . $e->getMessage();
        }
    }

    //*Create new user
    public function createUser(string $username, string $email, string $password) {
        //Create new user
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE(
        $sql = "INSERT INTO user(`username`,`email`,`password`) VALUES (:username,:email,:password)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username',$username,PDO::PARAM_STR);
            $stmt->bindParam(':email',$email,PDO::PARAM_STR);
            $stmt->bindParam(':password',$password,PDO::PARAM_STR);
            $stmt->execute();
            echo "Insert success";
        } catch (\PDOException $e) {
            die("Cannot create new user") . $e->getMessage();
        }
    }

    //*Update user data
    public function updateUser(int $id, array $updateData = []) {
        //Update user by id
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE
        $sql = "UPDATE user SET ";
        $params = [];

        $firstCol = true;
        foreach ($updateData as $col => $val) {
            if($firstCol) {
                $firstCol = false;
            } else {
                $sql .= ", ";
            }
            $sql .= "`$col` = :$col";
            $params[":$col"] = $val;
        }

        $sql .= " WHERE `id` = :id";
        $params[":id"] = $id;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            echo "Update success";
        } catch (\PDOException $e) {
            die('Cannot update user data') . $e->getMessage() . "(Error code = " . $e->getCode() . ")";
        }
    }

    //*Delete user data
    public function deleteUser(int $id, string $username = null) {
        //Delete user by id
        //! ADD CASCADE TO THE QUERY
        $sql = "DELETE FROM user WHERE `id` = :id" . ($username !== null ? " AND `username` = :username" : "");
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($username !== null) {
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            }

            $stmt->execute();
        } catch (\PDOException $e) {
            die("Cannot delete user data") . $e->getMessage();
        }
    }
}

?>