<?php
session_start();
include 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Favorite Movies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function removeFavorite(movie_id) {
            fetch("../controllers/MovieController.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `remove_favorite=1&movie_id=${movie_id}`
            }).then(response => response.text()).then(() => {
                location.reload();
            });
        }
    </script>
</head>
<body class="container mt-5 pt-5" style="padding-top: 80px; padding-bottom: 60px;">
    <?php include 'header.php'; ?>
    
    <h2 class="text-center">Your Favorite Movies</h2>

    <table class="table table-bordered mt-3">
        <?php
            include_once '../config/database.php';
            include_once '../models/Movie.php';

            $database = new Database();
            $db = $database->getConnection();
            $movie = new Movie($db);
            $favorites = $movie->getFavorites($_SESSION['user_id']);

            if (empty($favorites)) { 
        ?>
            <tr>
                <td colspan="3" class="text-center">No Favorite Movies Added</td>
            </tr>
        <?php 
            } else { 
        ?>
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($favorites as $fav): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($fav['poster_url']) ?>" width="50"></td>
                        <td><?= htmlspecialchars($fav['movie_title']) ?></td>
                        <td><button class="btn btn-danger" onclick="removeFavorite('<?= htmlspecialchars($fav['movie_id']) ?>')">Remove</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php } ?>
    </table>

    <?php include 'footer.php'; ?>
</body>
</html>
