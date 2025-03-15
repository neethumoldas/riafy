<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let alertBox = document.getElementById("successMessage");
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.transition = "opacity 1s ease-out";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 1000);
                }, 5000);
            }
        });
    </script>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center position-absolute top-0 mt-3 w-100">
        <?php
        session_start();
        if (isset($_SESSION['success_message'])) {
            echo '<div id="successMessage" class="alert alert-success w-50 mx-auto">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); 
        }
        ?>
    </div>

    <div class="card p-4 shadow-lg" style="width: 300px;">
        <h2 class="text-center">Login</h2>
        <form method="POST" action="../controllers/AuthController.php">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
        </form>
        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
