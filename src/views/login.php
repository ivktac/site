<?php

if (isSignedIn()) {
    header("Location: index.php");
}

global $conn;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = mysqli_escape_string($conn, $_POST["login"]);
    $password =  mysqli_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE login = '$login'";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die(mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $_SESSION["user"] = serialize(new User($user["id"], $user["login"], $user["email"], $user["admin"]));
        header("Location: index.php");
        exit();
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