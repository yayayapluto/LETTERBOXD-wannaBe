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
            $this->pdo = new PDO('mysql:host=localhost;dbname=letterboxd_wannabe', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('[Database connection failed]') . $e->getMessage();
        }
    }

    //*Get list of movie
    public function getMovie() {
        //Get all list of movie
    }

    //*Create new user
    public function insertMovie(string $cover_link, string $title, string $director, string $release_date, int $duration, string $description, string $trailer_link, string $actors, string $genre) {
        //Insert new movie
    }

    //*Update movie data
    public function updateMovie(int $id, string $cover_link, string $title, string $director, string $release_date, int $duration, string $description, string $trailer_link, string $actors, string $genre) {
        //Update movie data
    }

    //*Delete movie data
    public function deleteMovie(int $id, string $title) {
        //Delete movie data
    }
}

class MovieInteraction {
    
}

?>