<?php

class BaseController
{
    protected $pdo;

    private function connect()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=LETTERBOXD_wannaBe', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Cannot connect to the database\t") . $e->getMessage() . "\t" . $e->getCode();
        }
    }

    public function __construct()
    {
        $this->connect();
    }
}

class UserController extends BaseController
{
    //*Get user data
    public function getUser(int $id = null)
    {
        $sql = "SELECT * FROM user" . ($id !== null ? " WHERE `id` = :id" : "");
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($id != null) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return $res;
            foreach ($res as $users) {
                echo "[id]: " . $users['id'] . PHP_EOL;
                echo "  [username]  : " . $users['username'] . PHP_EOL;
                echo "  [email]     : " . $users['email'] . PHP_EOL;
                echo "  [password]  : " . $users['password'] . PHP_EOL . "\n";
            }
        } catch (\PDOException $e) {
            die("Cannot get user data") . $e->getMessage();
        }
    }

    //*Create new user
    public function createUser(string $username, string $email, string $password)
    {
        //Create new user
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE(
        $sql = "INSERT INTO user(`username`,`email`,`password`) VALUES (:username,:email,:password)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            echo "Insert success";
        } catch (\PDOException $e) {
            die("Cannot create new user") . $e->getMessage();
        }
    }

    //*Update user data
    public function updateUser(int $id, array $updateData = [])
    {
        //Update user by id
        //! PASSWORD MUST BE HASHED BEFORE INSERTED TO THE DATABASE
        $sql = "UPDATE user SET ";
        $params = [];

        $firstCol = true;
        foreach ($updateData as $col => $val) {
            if ($firstCol) {
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
    public function deleteUser(int $id, string $username = null)
    {
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

class MovieController extends BaseController
{
    //*Get list of movie
    public function getMovie(int $id = null)
    {
        $sql = "SELECT * FROM movie" . ($id !== null ? "WHERE `id` = :id" : "");
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($id != null) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return $res;
            foreach ($res as $movies) {
                echo "[id]: " . $movies['id'] . PHP_EOL;
                echo "  [cover_link]  : " . $movies['cover_link'] . PHP_EOL;
                echo "  [trailer_link]: " . $movies['trailer_link'] . PHP_EOL;
                echo "  [title]       : " . $movies['title'] . PHP_EOL;
                echo "  [director]    : " . $movies['director'] . PHP_EOL;
                echo "  [release_date]: " . $movies['release_date'] . PHP_EOL;
                echo "  [duration]    : " . $movies['duration'] . PHP_EOL;
                echo "  [description] : " . $movies['description'] . PHP_EOL;
                echo "  [actors]      : " . $movies['actors'] . PHP_EOL;
                echo "  [genre]       : " . $movies['genre'] . PHP_EOL . "\n";
            }
        } catch (\PDOException $e) {
            die("Cannot get user data") . $e->getMessage();
        }
    }

    //*Create new user
    public function insertMovie(string $cover_link, string $title, string $director, string $release_date, int $duration, string $description, string $trailer_link, string $actors, string $genre)
    {
        $sql = "INSERT INTO movie(`cover_link`,`trailer_link`,`title`,`director`,`release_date`,`duration`,`description`,`actors`,`genre`) VALUES (:cover_link,:trailer_link,:title,:director,:release_date,:duration,:description,:actors,:genre)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cover_link', $cover_link, PDO::PARAM_STR);
            $stmt->bindParam(':trailer_link', $trailer_link, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':director', $director, PDO::PARAM_STR);
            $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
            $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':actors', $actors, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->execute();
            echo "Insert success";
        } catch (\PDOException $e) {
            echo "Cannot insert movie: " . $e->getMessage() . PHP_EOL;
        }
    }

    //*Update movie data
    public function updateMovie(int $id, array $updateData = [])
    {
        //Update movie data
        $sql = "UPDATE movie SET ";
        $params = [];

        $firstCol = true;
        foreach ($updateData as $col => $val) {
            if ($firstCol) {
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
            die('Cannot update movie data') . $e->getMessage() . "(Error code = " . $e->getCode() . ")";
        }
    }

    //*Delete movie data
    public function deleteMovie(int $id)
    {
        //Delete movie data
        $sql = "DELETE FROM movie WHERE `id` = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Cannot delete movie data") . $e->getMessage();
        }
    }
}

class InteractionController extends BaseController{
    public function getRating(int $userId = null, int $movieId = null)
    {
        try {
            $sql = "SELECT * FROM rating";
            if ($userId !== null || $movieId !== null) {
                $sql .= ($userId !== null ? " WHERE `user_id` = :user_id" : "WHERE `movie_id` = :movie_id");
                $stmt = $this->pdo->prepare($sql);
                $param = ($userId !== null ? ":user_id" : ":movie_id");
                $value = ($userId !== null ? $userId : $movieId);
                $stmt->bindParam($param, $value, PDO::PARAM_INT);
            } else {
                $stmt = $this->pdo->prepare($sql);
            }
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($res as $ratings) {
                echo "[id] => " . $ratings['id'] . PHP_EOL;
                echo "\t[user_id] => " . $ratings['user_id'] . PHP_EOL;
                echo "\t[movie_id] => " . $ratings['movie_id'] . PHP_EOL;
                echo "\t[rating] => " . $ratings['rating'] . PHP_EOL;
            }
        } catch (\PDOException $e) {
            die("Cannot get data\t") . $e->getMessage();
        }
    }
    public function insertRating(int $userId, int $movieId, int $rating) {
        try {
            $sql = "INSERT INTO rating(`user_id`,`movie_id`,`rating`) VALUES (:user_id,:movie_id,:rating)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->execute();
            echo "Insert data success";
        } catch (\PDOException $e) {
            die("Cannot insert data\t") . $e->getMessage();
        }
    }
    public function updateRating(int $id, int $userId, int $movieId, int $rating) {
        try {
            $sql = "UPDATE rating SET `user_id` = :user_id, `movie_id` = :movie_id, `rating` = :rating WHERE `id` = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Update rating success";
        } catch (\PDOException $e) {
            die("Cannot update data\t") . $e->getMessage();
        }
    }
    public function deleteRating(int $id) {
        try {
            $sql = "DELETE FROM rating WHERE `id` = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Cannot delete data\t") . $e->getMessage();
        }
    }
}
?>