<?php
session_start();
require_once 'classes/Connection.php';
require_once 'utils/functions.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Sample data for the dashboard
$adminId = $_SESSION['admin_id'];
$connection = Connection::getInstance();

// Get admin details
$query = 'SELECT username, role FROM admins WHERE AdminID = :adminId';
$statement = $connection->prepare($query);
$statement->bindParam(':adminId', $adminId);
$statement->execute();
$admin = $statement->fetch(PDO::FETCH_ASSOC);

// Get counts of events, locations, and users
$eventsCountQuery = 'SELECT COUNT(*) FROM events'; // Adjust table name if needed
$locationsCountQuery = 'SELECT COUNT(*) FROM locations'; // Adjust table name if needed
$usersCountQuery = 'SELECT COUNT(*) FROM users'; // Adjust table name if needed

$eventsCount = $connection->query($eventsCountQuery)->fetchColumn();
$locationsCount = $connection->query($locationsCountQuery)->fetchColumn();
$usersCount = $connection->query($usersCountQuery)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .welcome-message {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="welcome-message">Welcome, <?php echo htmlspecialchars($admin['username']); ?>!</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-header">Total Events</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $eventsCount; ?></h5>
                    <p class="card-text">Manage and view all events.</p>
                    <a href="viewEvents.php" class="btn btn-light">View Events</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-header">Total Locations</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $locationsCount; ?></h5>
                    <p class="card-text">Manage and view all locations.</p>
                    <a href="viewLocations.php" class="btn btn-light">View Locations</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $usersCount; ?></h5>
                    <p class="card-text">Manage all registered users.</p>
                    <a href="viewUsers.php" class="btn btn-light">View Users</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
