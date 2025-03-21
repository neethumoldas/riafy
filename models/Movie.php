<?php
class Movie {
    private $conn;
    private $table_name = "favorite_movies";
    private $api_key = "55abc3a0";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function searchMovie($title) {
        $url = "http://www.omdbapi.com/?apikey=" . $this->api_key . "&s=" . urlencode($title);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function addFavorite($user_id, $movie_title, $movie_id, $poster_url) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, movie_title, movie_id, poster_url) VALUES (:user_id, :movie_title, :movie_id, :poster_url)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":movie_title", $movie_title);
        $stmt->bindParam(":movie_id", $movie_id);
        $stmt->bindParam(":poster_url", $poster_url);
        return $stmt->execute();
    }

    public function removeFavorite($user_id, $movie_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND movie_id = :movie_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":movie_id", $movie_id);
        return $stmt->execute();
    }

    public function getFavorites($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isMovieFavorite($user_id, $movie_id) {
        $query = "SELECT * FROM favorite_movies WHERE user_id = :user_id AND movie_id = :movie_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":movie_id", $movie_id);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Returns true if the movie exists
    }
}
?>
