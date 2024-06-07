<?php
include('config-db.php');

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM `6` WHERE ID=".$id);
header('location: index.php');
