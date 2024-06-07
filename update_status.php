<?php
include 'config-db.php';

if (isset($_POST['id']) && isset($_POST['isChecked'])) {
    $id = $_POST['id'];
    $isChecked = $_POST['isChecked'];

    $sql = "UPDATE `6` SET IsChecked=$isChecked WHERE ID=$id";
    mysqli_query($conn, $sql);
}
