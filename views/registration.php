<?php

use SimpleCaptcha\Builder;

$builder = Builder::create();
$builder->applyPostEffects = false;
$builder->applyScatterEffect = false;
$builder->applyNoise = false;
$builder->bgColor = "#ffffff";
$builder->build();

$data = [
    'login' => $_POST["login"] ?? '',
    'password' => $_POST["password"] ?? '',
    'password-repeat' => $_POST["password-repeat"] ?? '',
    'email' => $_POST["email"] ?? '',
    'captcha' => $_POST["captcha"] ?? '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $_POST["login"])) {
        $errors["login"] = "Login must be at least 4 characters long and contain only letters, numbers, dashes and underscores";
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/', $_POST["password"])) {
        $errors[] = "Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter and one number";
    }

    if ($_POST["password"] != $_POST["password-repeat"]) {
        $errors[] = "Passwords do not match";
    }

    if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["email"])) {
        $errors[] = "Invalid email";
    }

    if (!$builder->compare($_POST["captcha"], $_SESSION["captcha"])) {
        $errors[] = "Invalid captcha";
    }

    try {
        // check if user or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
        $stmt->execute([$data['login'], $data['email']]);

        if ($stmt->num_rows() > 0) {
            $errors[] = "Login or email already exists";
        }
    } catch (mysqli_sql_exception $e) {
    }


    if (empty($errors)) {
        unset($_SESSION["captcha"]);

        try {
            $conn->prepare("INSERT INTO users (login, password, email) VALUES (?, ?, ?)")
                ->execute([$data['login'], password_hash($data['password'], PASSWORD_DEFAULT), $data['email']]);
        } catch (mysqli_sql_exception $e) {
        }

        header("Location: index.php?action=registration_successful");
    }
}

?>

<section class="page-registration">
    <h1>Registration Form</h1>

    <form method="post">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" value="<?= $data["login"] ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?= $data["password"] ?>" required><br>

        <label for="password-repeat">Repeat Password:</label>
        <input type="password" name="password-repeat" id="password-repeat" value="<?= $data["password-repeat"] ?>" required><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $data['email'] ?>" required><br>

        <label for="captcha">Enter the characters shown in the picture:</label>
        <!-- NOTE See: https://github.com/Gregwar/Captcha/issues/45#issuecomment-341022248  -->
        <?php $_SESSION["captcha"] = $builder->phrase; ?>
        <img src="<?= $builder->inline() ?>" alt="captcha">
        <input type="text" name="captcha" id="captcha" value="<?= $data['captcha'] ?>" required>

        <input type="submit" value="Register">

        <ul class="error-list">
            <?php foreach ($errors as $name => $error) : ?>
                <li>
                    <?= $error ?>
                </li>
            <?php endforeach; ?>
        </ul>
</section>