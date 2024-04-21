<?php 

class MovieController{
    protected string $cover_link;
    protected string $title;
    protected string $director;
    protected string $release_date;
    protected string $duration;
    protected string $description;
    protected string $trailer_link;
    protected string $like;
    protected string $dislike;
    protected string $actors;
    protected string $genre;

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

    //*Get list of movie
    public function getMovie(int $id = null) {
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
                echo "  [like]        : " . $movies['like'] . PHP_EOL;
                echo "  [dislike]     : " . $movies['dislike'] . PHP_EOL;
                echo "  [actors]      : " . $movies['actors'] . PHP_EOL;
                echo "  [genre]       : " . $movies['genre'] . PHP_EOL . "\n";
            }
        } catch (\PDOException $e) {
            die("Cannot get user data") . $e->getMessage();
        }
    }

    //*Create new user
    public function insertMovie(string $cover_link, string $title, string $director, string $release_date, int $duration, int $like, int $dislike, string $description, string $trailer_link, string $actors, string $genre) {
        $sql = "INSERT INTO movie(`cover_link`,`trailer_link`,`title`,`director`,`release_date`,`duration`,`description`,`like`,`dislike`,`actors`,`genre`) VALUES (:cover_link,:trailer_link,:title,:director,:release_date,:duration,:description,:like,:dislike,:actors,:genre)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cover_link', $cover_link, PDO::PARAM_STR);
            $stmt->bindParam(':trailer_link', $trailer_link, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':director', $director, PDO::PARAM_STR);
            $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
            $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':like', $like, PDO::PARAM_INT);
            $stmt->bindParam(':dislike', $dislike, PDO::PARAM_INT);
            $stmt->bindParam(':actors', $actors, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->execute();
            echo "Insert success";
        } catch (\PDOException $e) {
            echo "Cannot insert movie: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    //*Update movie data
    /**
     * @param $updateData [string cover_link, string trailer_link, string title, string director, string release_date, int duration, string description, int like, int dislike, string actors, string genre]
     */
    public function updateMovie(int $id, array $updateData = []) {
        //Update movie data
        $sql = "UPDATE movie SET ";
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
            die('Cannot update movie data') . $e->getMessage() . "(Error code = " . $e->getCode() . ")";
        }
    }

    //*Delete movie data
    public function deleteMovie(int $id) {
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

class MovieInteraction {
    //Like movie
    //Dislike movie

    //Watch later movie
    //Review movie
}

?>