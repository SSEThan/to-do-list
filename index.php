<?php
include 'config-db.php';
session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT * FROM `6`';
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de la récupération des tâches : " . mysqli_error($conn));
}

$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
$taskNumber = mysqli_num_rows($result);
$tasky = "";
$errors = $addtaskErr = "";

if (isset($_POST['submit']) && $_POST['submit'] === "Add") {
    if (isset($_POST['addtask']) && !empty($_POST['addtask'])) {
        $tasky = filter_var($_POST['addtask'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user = "defaultUser";

        $sql = "INSERT INTO `6` (Todo, User) VALUES ('$tasky', '$user')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            $errors = "Erreur lors de l'ajout de la tâche : " . mysqli_error($conn);
            echo $errors;
        }
    } else {
        $errors = "Veuillez ajouter une tâche";
        echo $errors;
    }
}

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    $sql = "DELETE FROM `6` WHERE `ID` = $id";
    if (!mysqli_query($conn, $sql)) {
        die("Erreur lors de la suppression de la tâche : " . mysqli_error($conn));
    }
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>ToDoList</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">To Do List</h1>

        <p class="text-center">Nombre de tâches : <?php echo $taskNumber; ?></p>
        
        <?php if (!empty($errors)) : ?>
            <p class="text-center text-danger"><?php echo $errors; ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form-inline justify-content-center mt-4 mb-4">
            <div class="form-group mx-sm-3 mb-2">
                <label for="addtask" class="sr-only">Add a task</label>
                <input type="text" class="form-control" id="addtask" name="addtask" placeholder="Enter task">
            </div>
            <button type="submit" name="submit" value="Add" class="btn btn-primary mb-2">Add Task</button>
        </form>

        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <?php echo $task['Todo']; ?>
                    </div>
                    <div>
                        <a href="index.php?del_task=<?php echo $task['ID']; ?>" class="badge badge-danger badge-pill">X</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
