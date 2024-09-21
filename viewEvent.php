<?php
require_once 'classes/Event.php';
require_once 'classes/EventTableGateway.php';
require_once 'classes/Connection.php';

if (!isset($_GET['id'])) {
    die("Illegal request");
}
$id = $_GET['id'];

$connection = Connection::getInstance();
$gateway = new EventTableGateway($connection);

$statement = $gateway->getEventsById($id);

$row = $statement->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    die("Illegal request");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <?php require 'utils/styles.php'; ?>
    <?php require 'utils/scripts.php'; ?>
</head>
<body>  
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <?php 
            if (isset($message)) {
                echo '<p>'.$message.'</p>';
            }
            ?>
            <table class="table table-hover">
                <thead><!--table labels-->
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Description</th>                    
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Cost</th>
                        <th>Location ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody><!--table contents, pulled from database-->
                    <?php
                    echo '<tr>';
                    echo '<td>' . (isset($row['eventID']) ? $row['eventID'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['Title']) ? $row['Title'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['Description']) ? $row['Description'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['StartDate']) ? $row['StartDate'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['EndDate']) ? $row['EndDate'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['Cost']) ? $row['Cost'] : 'N/A') . '</td>';
                    echo '<td>' . (isset($row['locationID']) ? $row['locationID'] : 'N/A') . '</td>';
                    echo '<td>'
                        . '<a class="delete" href="deleteEvent.php?id='. (isset($row['eventID']) ? $row['eventID'] : '') .'">Delete</a> '
                        . '</td>';
                    echo '</tr>';  
                    ?>
                </tbody>
            </table>
            <a class="btn btn-default" href="viewEvents.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>
</body>
</html>
