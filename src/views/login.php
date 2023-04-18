<?php

require_once 'db.php';

global $mysqli;

if (User::isAuth()) {
    header("Location: index.php");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = mysqli_escape_string($mysqli, $_POST["login"]);
    $password =  mysqli_escape_string($mysqli, $_POST["password"]);

    $user = User::getBy(["login" => $login]);

    if (!is_null($user) && password_verify($password, $user->password)) {
        $user->auth();
        header("Location: index.php");
    }

    $errors[] = "Invalid login or password";
}

?>

<section class="page-login">
    <h1>Login form</h1>

    <div class="grid-2">

        <form method="post">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Login">
        </form>

        <?php require_once 'layout/error_list.php' ?>
    </div>
</section>