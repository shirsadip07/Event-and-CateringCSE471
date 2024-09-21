<?php
require_once 'classes/Connection.php';
require_once 'utils/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $connection = Connection::getInstance();
    $query = 'SELECT * FROM admins WHERE username = :username';
    $statement = $connection->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->execute();
    $admin = $statement->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        session_start();
        $_SESSION['admin_id'] = $admin['AdminID'];
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div>
        <ul>
        <a href="index.php" class="btn btn-primary btn-block">Home</a>

        </ul>
    </div>

<div class="container">
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    <p class="text-center mt-3"><a href="admin_register.php">Register as Admin</a></p>
</div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
