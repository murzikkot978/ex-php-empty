<?php

/**
 * Get the todos from the sqlite database, and display them in a list.
 * You need to add a sort query parameter to the page to order by date or name.
 * If the query parameter is not set, the todos should be displayed in the order they were added.
 * If the request to the database fails, display an error message.
 * If the user wants to delete a todo, a form that sends a POST request to the deleteTodoFromDatabase.php page should be displayed on each todo elements.
 * The sort option selected must be remembered after the form submission (use a query parameter).
 * The todo title and date should be displayed in a list (date in american format).
 */
$errors = [];
$sort = filter_input(INPUT_GET, 'sort');
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (count($errors) === 0) {
        $dsn = 'sqlite:../database.db';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $todos = [];
            $pdo = new PDO($dsn, null, null, $options);
            if ($sort === "name") {
                $stmt = $pdo->query('SELECT * FROM todos ORDER BY title');
            } elseif ($sort === "date") {
                $stmt = $pdo->query('SELECT * FROM todos ORDER BY due_date');
            } else {
                $stmt = $pdo->query('SELECT * FROM todos');
            }
            $todos = $stmt->fetchAll();
        } catch (Exception $e) {
            array_push($errors, $e->getMessage());
        }
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
    <title>List of todos</title>
</head>
<body>

<h1>
    All todos
</h1>

<a href="writeTodoToDatabase.php">Ajouter une nouvelle todo</a>

<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->

<form $todos=[]; method="get">
    <select name="sort" id="">
        <option value="base" ; ?>Basic</option>
        <option value="name" ; ?>Name</option>
        <option value="date" ; ?>Date</option>
    </select>
    <input value="Select sort type" type="submit">
</form>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<ul>
    <?php foreach ($todos as $todo): ?>
        <li>
            <?= $todo['title'] ?><br/>
            <time><?= $todo['due_date'] ?></time>
            <form action="deleteTodoFromDatabase.php" method="post">
                <input type="hidden" name="idForDelete" value=<?= $todo['id'] ?>>
                <button type="submit">Delete</button>
            </form>
        </li>
    <?php endforeach ?>
</ul>
</body>
</html>