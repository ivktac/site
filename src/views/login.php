<?php

check_allow_rights();

global $conn;

$errors = [];

$data = new LoginData(
    $_POST["login"] ?? "",
    $_POST["password"] ?? ""
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $user = $data->signIn($conn);

        $_SESSION["user"] = serialize($user);

        header("Location: index.php");
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
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

        <?php require_once 'src/layout/error_list.php' ?>
    </div>
</section>