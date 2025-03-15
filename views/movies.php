<?php
session_start();
include 'auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            function addFavorite(id, title, poster) {
                fetch("../controllers/MovieController.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `add_favorite=1&movie_id=${id}&movie_title=${title}&poster_url=${poster}`
                })
                .then(response => response.text())
                .then(message => {
                    let modalMessage = document.getElementById("modal-message");
                    let modal = new bootstrap.Modal(document.getElementById("responseModal"));

                    if (modalMessage) {
                        modalMessage.innerText = message; // Insert message
                        modal.show(); // Show the modal
                    } else {
                        console.error("Modal element not found!"); // Debugging log
                    }
                })
                .catch(error => console.error("Error:", error));
            }

            // Attach function to the global window object so it can be called inline in HTML
            window.addFavorite = addFavorite;
        });

         function searchMovie() {
            let title = document.getElementById("search").value;
            fetch("../controllers/MovieController.php?search=" + title)
            .then(response => response.json())
            .then(data => {
                let results = document.getElementById("results");
                results.innerHTML = "";
                document.getElementById("latest-movies-container").remove();
                document.getElementById("additional-movies-container").remove();
                if (data.Response === "False") {
                    alert("Movie not found!");
                } else {
                    data.Search.forEach(movie => {
                        results.innerHTML += `<div class='card m-2 p-2 text-center' style='width: 18rem;'>
                            <img class='card-img-top' src="${movie.Poster}" alt="${movie.Title}">
                            <div class='card-body'>
                                <h5 class='card-title'>${movie.Title}</h5>
                                <button class='btn btn-primary' onclick="addFavorite('${movie.imdbID}', '${movie.Title}', '${movie.Poster}')">Add to Favorites</button>
                            </div>
                        </div>`;
                    });
                }
            });
        }


        function fetchLatestMovies() {
            fetch("https://www.omdbapi.com/?s=latest&apikey=55abc3a0")
            .then(response => response.json())
            .then(data => {
                let results = document.getElementById("latest-movies");
                results.innerHTML = "";
                if (data.Response === "False") {
                    results.innerHTML = "<p class='text-center text-danger'>No movies found!</p>";
                } else {
                    data.Search.forEach(movie => {
                        results.innerHTML += `<div class='card m-2 p-2 text-center' style='width: 18rem;'>
                            <img class='card-img-top' src="${movie.Poster}" alt="${movie.Title}">
                            <div class='card-body'>
                                <h5 class='card-title'>${movie.Title}</h5>
                                <button class='btn btn-dark' onclick="addFavorite('${movie.imdbID}', '${movie.Title}', '${movie.Poster}')">Add to Favorites</button>
                            </div>
                        </div>`;
                    });
                }
            });
        }

        function fetchAdditionalMovies() {
            fetch("https://www.omdbapi.com/?s=popular&apikey=55abc3a0")
            .then(response => response.json())
            .then(data => {
                let results = document.getElementById("additional-movies");
                results.innerHTML = "";
                if (data.Response === "False") {
                    results.innerHTML = "<p class='text-center text-danger'>No additional movies found!</p>";
                } else {
                    data.Search.forEach(movie => {
                        results.innerHTML += `<div class='card m-2 p-2 text-center' style='width: 18rem;'>
                            <img class='card-img-top' src="${movie.Poster}" alt="${movie.Title}">
                            <div class='card-body'>
                                <h5 class='card-title'>${movie.Title}</h5>
                                <button class='btn btn-dark' onclick="addFavorite('${movie.imdbID}', '${movie.Title}', '${movie.Poster}')">Add to Favorites</button>
                            </div>
                        </div>`;
                    });
                }
            });
        }

        function addFavorite(id, title, poster) {
            fetch("../controllers/MovieController.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `add_favorite=1&movie_id=${id}&movie_title=${title}&poster_url=${poster}`
            })
            .then(response => response.text())
            .then(message => {
                document.getElementById("modal-message").innerText = message; // Insert message into modal
                let modal = new bootstrap.Modal(document.getElementById("responseModal")); 
                modal.show(); // Show the modal
            });
        }

    </script>
</head>
<body class="container mt-5 pt-5" style="padding-top: 80px; padding-bottom: 60px;">
    <?php include 'header.php'; ?>
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="responseModalLabel">
                    <i class="bi bi-info-circle"></i> Notification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p id="modal-message" class="fw-bold fs-5 text-dark"></p> 
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-success px-4 py-2" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="mt-5 pt-4">
        <h2 class="text-center">Search Movies</h2>
        <div class="input-group mb-3">
            <input type="text" id="search" class="form-control" placeholder="Enter movie title">
            <button class="btn btn-primary" onclick="searchMovie()">Search</button>
        </div>
        <div id="results" class="d-flex flex-wrap justify-content-center"></div>
    </div>
    <div class="mt-5 pt-4" id="latest-movies-container">
        <h2 class="text-center">Latest Movies</h2>
        <div id="latest-movies" class="d-flex flex-wrap justify-content-center"></div>
    </div>
    <div class="mt-5 pt-4" id="additional-movies-container">
        <h2 class="text-center">Additional Popular Movies</h2>
        <div id="additional-movies" class="d-flex flex-wrap justify-content-center"></div>
    </div>
    <script>
        fetchLatestMovies();
        fetchAdditionalMovies();
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
