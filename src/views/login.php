<?php

require_once 'db.php';

global $conn;

if (User::isAuth()) {
    header("Location: index.php");
}


$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = mysqli_escape_string($conn, $_POST["login"]);
    $password =  mysqli_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE login = '$login'";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die(mysqli_error($conn));
    }

    $result = mysqli_fetch_assoc($result);

    if (!password_verify($password, $result["password"])) {
        $errors[] = "Invalid login or password";
    }

    if (empty($errors)) {
        User::authenticate($result);
        header("Location: index.php");
        exit();
    }
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