<?php
// admin_register.php
require_once 'classes/Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $connection = Connection::getInstance();
    $query = 'INSERT INTO admins (username, password) VALUES (:username, :password)';
    $statement = $connection->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);

    if ($statement->execute()) {
        echo "<script>alert('Admin registered successfully!');</script>";
        header("Location: admin_login.php");
        exit(); // Make sure to exit after redirecting
    } else {
        echo "<script>alert('Error registering admin.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Registration</title>
</head>
<body>
<a href="index.php" class="btn btn-primary btn-block">Home</a>

    <div class="container mt-5">
        <h2 class="text-center">Admin Registration</h2>
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <form action="admin_register.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="admin_login.php">Already have an account? Login here.</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
