<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["password-repeat"];
    $email = $_POST["email"];

    if (!preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $login)) {
        $errors[] = "Login must be at least 4 characters long and contain only letters, numbers, dashes and underscores";
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/', $password)) {
        $errors[] = "Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter and one number";
    }

    if (!($password == $repeatPassword)) {
        $errors[] = "Passwords do not match";
    }

    if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors[] = "Invalid email";
    }

    if (empty($errors)) {
        header("Location: index.php?action=registration_successful");
    }
}

?>

<section class="page-registration">
    <h1>Registration Form</h1>

    <form method="POST">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="password-repeat">Repeat Password:</label>
        <input type="password" name="password-repeat" id="password-repeat" required><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>

        <input type="submit" value="Register">

        <ul class="error-list">
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= $error ?>
                </li>
            <?php endforeach; ?>
        </ul>
</section>