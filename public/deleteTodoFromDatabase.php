<?php

/**
 * On this page, you need to remove a todo from the sqlite database.
 * The id of the todo to delete will be passed as a POST parameter.
 * You need to handle the deletion of the todo from the database.
 * If there is an error, display an error message.
 * If the deletion is successful, redirect the user to the list of todos.
 */

$errors = [];
$idForDelete = filter_input(INPUT_POST, 'idForDelete', FILTER_SANITIZE_NUMBER_INT);

if (count($errors) === 0) {
    $dsn = 'sqlite:../database.db';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, null, null, $options);
        $stmt = $pdo->prepare('DELETE FROM todos WHERE id = :id');
        $stmt->execute(['id' => $idForDelete]);
        header('Location: displayAllTodosFromDatabase.php');
    } catch (Exception $e) {
        array_push($errors, $e->getMessage());
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo deletion</title>
</head>
<body>

<h1>Delete a todo error</h1>

<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<a href="displayAllTodosFromDatabase.php">Return to todo list</a>

</body>
</html>
