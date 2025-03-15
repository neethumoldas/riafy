<?php
include_once '../config/database.php';
include_once '../models/Movie.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$movie = new Movie($db);

if (isset($_GET['search'])) {
    $title = $_GET['search'];
    $movies = $movie->searchMovie($title);
    echo json_encode($movies);
    exit();
}

if (isset($_POST['add_favorite'])) {
    $user_id = $_SESSION['user_id'];
    $movie_title = $_POST['movie_title'];
    $movie_id = $_POST['movie_id'];
    $poster_url = $_POST['poster_url'];

    // Call the new function from Movie model
    if ($movie->isMovieFavorite($user_id, $movie_id)) {
        echo json_encode(["status" => "error", "message" => "Movie already in favorites."]);
    } else {
        if ($movie->addFavorite($user_id, $movie_title, $movie_id, $poster_url)) {
            echo json_encode(["status" => "success", "message" => "Movie added to favorites."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error adding movie."]);
        }
    }
    exit();
}



if (isset($_POST['remove_favorite'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = $_POST['movie_id'];
    if ($movie->removeFavorite($user_id, $movie_id)) {
        echo "Movie removed from favorites.";
    } else {
        echo "Error removing movie.";
    }
    exit();
}
?>

