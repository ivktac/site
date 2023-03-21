<?php

check_allow_rights();

global $conn;

$errors = [];

$data = LoginData::fromRequest($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = sign_in_user($conn, $data);

    if ($user) {
        $_SESSION["user"] = serialize($user);
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

        <?php require_once 'src/layout/error_list.php' ?>
    </div>
</section>