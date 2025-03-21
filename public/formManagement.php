<?php

/**
 * On this page, you should display a form with two fields, one for the Name and one for the Age.
 * The server should respond to the form submission by displaying the same page with the name and age in a h1 "Toto is 20 years old".
 * If there is no submission or only one of the two fields, the h1 should display "Submit the form".
 * If the user have a name with more than 6 characters, the name must be displayed in red (only the name, not all h1).
 * If the user is more than 18 years old, you should display a list with one line per year of the age of the user.
 * The data submitted should remain displayed in the form after the submission.
 * (Your form should be semantically correct, use a label and name your fields)
 */
$name = $_POST['name'];
$age = $_POST['age'];

function verification($name, $age)
{
    if ($name && $age) {
        if (mb_strlen($name) > 6) {
            return "<span style='color: red'>$name</span> is $age years old";
        } else {
            return "$name is $age years old";
        }
    } else {
        return "Submit the form";
    }
}

function submitAge($age)
{
    if ($age > 18) {
        for ($i = 1; $i <= $age; $i++) {
            $a .= "<li>$i</li>";
        }
        return $a;
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
    <title>Form management</title>
</head>
<body>
<form method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?= $name ?>">
    <label for="age">Age</label>
    <input type="number" name="age" id="age" value="<?= $age ?>">
    <button type="submit">submit</button>
</form>
<h1><?= verification($name, $age) ?></h1>
<ul><?= submitAge($age) ?></ul>
<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->
</body>
</html>