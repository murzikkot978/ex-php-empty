<?php

/**
 * On this page, you will create a simple form that allows user to create todos (with a name and a date).
 * The form should be submitted to this PHP page.
 * Then get the inputs from the post request with `filter_input`.
 * Then, the PHP code should verify the user inputs (minimum length, valid date...)
 * If the user input is valid, insert the new todo information in the sqlite database
 * table `todos` columns `title` and `due_date`. Then redirect the user to the list of todos.
 * If the user input is invalid, display an error to the user
 */
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = filter_input(INPUT_POST, 'name');
    $date = filter_input(INPUT_POST, 'date');

    if ($date === "") {
        array_push($errors, "Date is not a valid date");
    }


    if ($name === "") {
        array_push($errors, "Name is not a valid name");
    }


    if (count($errors) === 0) {
        $dsn = 'sqlite:../database.db';
        $user = 'root';
        $pass = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $stmt = $pdo->prepare("INSERT INTO todos (title, due_date) VALUES (:name, :date)");
            $stmt->execute(["name" => $name, "date" => $date]);
            header("Location: displayAllTodosFromDatabase.php");
            exit();
        } catch (Exception $e) {
            var_dump($e);
            array_push($errors, $e->getMessage());
        }
    }
}


function displayTodos($name, $date)
{
    if ($name && $date) {
        return "$name  $date";
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
    <title>Create a new todo</title>
</head>
<body>

<h1>
    Create a new todo
</h1>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<form method="post" action="writeTodoToDatabase.php" ?>
    <label for="title">Name</label>
    <input type="text" name="name" id="title" value="<?= $name ?>">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="<?= $date ?>">
    <button type="submit">submit</button>
</form>

<ul>
    <li>
        <?= displayTodos($name, $date) ?>
    </li>
</ul>
<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->
</body>
</html>