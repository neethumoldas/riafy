
<nav class="navbar navbar-expand-lg" style="background-color: #fb555a; position: fixed; top: 0; width: 100%; z-index: 1000; left: 0; right: 0; padding: 10px;">
    <div class="container-fluid">
        <a class="nav-link text-white" href="movies.php">Dashboard</a>
        <div class="ms-auto d-flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="nav-link text-white me-3" href="favorites.php">Favorite Movies</a>
                <a class="nav-link text-white me-3" href="../controllers/AuthController.php?logout=true">Logout</a>
            <?php else: ?>
                <a class="nav-link text-white me-3" href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>