<?php

require_once 'db.php';
require_once 'captcha.php';

global $builder, $conn;

if (User::isAuth()) {
    header("Location: index.php");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $repeatPassword = $_POST["password-repeat"];
    $captcha = $_POST["captcha"] ?? "";

    $user = User::fromStdClass((object)[
        "id" => 0,
        "login" => $_POST["login"],
        "email" => $_POST["email"],
        "password" => $_POST["password"],
        "admin" => false,
        "first_name" => null,
        "last_name" => null,
        "birthdate" => null,
    ]);

    // check if user already exists
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE login = '$user->login' OR email = '$user->email'");

    $isExistAlready = mysqli_fetch_row($result)[0];

    if ($isExistAlready != 0) {
        $errors[] = "User with this login or email already exists";
    }

    $errors = array_merge($errors, User::validate($user));

    if ($user->password != $repeatPassword) {
        $errors[] = "Passwords do not match";
    }

    if (!$builder->compare($captcha, $_SESSION["captcha"])) {
        $errors[] = "Invalid captcha";
    }

    if (empty($errors)) {
        unset($_SESSION["captcha"]);

        $user->save();

        header("Location: index.php?action=registration_successful");
    }
}

?>

<section class="page-registration">
    <h1>Registration Form</h1>

    <div class="grid-2">
        <form method="post">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" value="<?= $_POST["login"] ?? "" ?>" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?= $_POST["password"] ?? "" ?>" required><br>

            <label for="password-repeat">Repeat Password:</label>
            <input type="password" name="password-repeat" id="password-repeat" value="<?= $_POST["password-repeat"] ?? "" ?>" required><br>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?= $_POST["email"] ?? "" ?>" required><br>

            <label for="captcha">Enter the characters shown in the picture:</label>
            <!-- NOTE See: https://github.com/Gregwar/Captcha/issues/45#issuecomment-341022248  -->
            <?php $_SESSION["captcha"] = $builder->phrase; ?>
            <img src="<?= $builder->inline() ?>" alt="captcha">
            <input type="text" name="captcha" id="captcha" value="<?= $_POST["captcha"] ?? "" ?>" required>

            <input type="submit" value="Register">
        </form>

        <?php require_once 'layout/error_list.php' ?>
    </div>
</section>