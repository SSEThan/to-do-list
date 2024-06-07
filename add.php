<?php
include('config-db.php');

if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    $date = date('Y-m-d H:i:s'); 
    $email = "test@example.com";
    $user = "defaultUser"; 

    if (empty($task)) {
        $errors = "You must fill in the task";
    } else {
        $query = "INSERT INTO `6` (IsChecked, Todo, Date, Email, User) VALUES (0, '$task', '$date', '$email', '$user')";
        mysqli_query($conn, $query);
        header('location: index.php');
    }
}

