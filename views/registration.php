<?php

$errors = [];

$data = new RegistrationData(
    $_POST["login"] ?? "",
    $_POST["password"] ?? "",
    $_POST["password-repeat"] ?? "",
    $_POST["email"] ?? "",
    $_POST["captcha"] ?? ""
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validateRegistrationData($data);

    if (empty($errors)) {
        unset($_SESSION["captcha"]);

        // registerUser($data);

        $_SESSION["user"] = $data->login;

        header("Location: index.php?action=registration_successful");
    }
}

?>

<section class="page-registration">
    <h1>Registration Form</h1>

    <form method="post">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" value="<?= $data->login ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?= $data->password ?>" required><br>

        <label for="password-repeat">Repeat Password:</label>
        <input type="password" name="password-repeat" id="password-repeat" value="<?= $data->repeatedPassword ?>"
            required><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $data->email ?>" required><br>

        <label for="captcha">Enter the characters shown in the picture:</label>
        <!-- NOTE See: https://github.com/Gregwar/Captcha/issues/45#issuecomment-341022248  -->
        <?php $_SESSION["captcha"] = $builder->phrase; ?>
        <img src="<?= $builder->inline() ?>" alt="captcha">
        <input type="text" name="captcha" id="captcha" value="<?= $data->captcha ?>" required>

        <input type="submit" value="Register">

        <?php include_once 'layout/error_list.php' ?>
</section>