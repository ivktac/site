<?php

checkAllowedRights();

global $conn, $builder;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = $_POST["login"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["password-repeat"];
    $email = $_POST["email"];
    $captcha = $_POST["captcha"] ?? "";
    
    // check if user already exists
    $result = mysqli_query($conn, "SELECT * FROM users WHERE login = '$login' OR email = '$email'");

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $errors[] = "User with this login or email already exists";
    }

    if (!preg_match("/^[a-zA-Z0-9_-]{4,}$/", $login)) {
        $errors[] = "Login should has at least 4 symbols and only letters, numbers, underscore or dash";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/", $password)) {
        $errors[] = "Password should has at least 7 symbols, at least one uppercase letter, one lowercase letter and one number";
    }

    if ($password != $repeatPassword)
    {
        $errors[] = "Passwords do not match";
    }

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
        $errors[] = "Invalid email";
    }


    if (!$builder->compare($captcha, $_SESSION["captcha"]))
    {
        $errors[] = "Invalid captcha";
    }

    if (empty($errors)) {
        unset($_SESSION["captcha"]);

        $password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (login, password, email) VALUES ('$login', '$password', '$email')";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die(mysqli_error($conn));
        }

        $db_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE login = '$login'"));

        $user = new User($db_user["id"], $db_user["login"], $db_user["email"], $db_user["admin"]);

        $_SESSION["user"] = serialize($user);

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

        <?php require_once 'src/layout/error_list.php' ?>
    </div>
</section>