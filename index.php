<?php 

include_once('controller/movieController.php');
$Movie = new MovieController();

$Movie->getMovie();
?>