<?php

require_once 'db.php';

global $mysqli;

if (!User::isAuth()) {
    header('Location: index.php');
    exit;
}

$user = User::getAuthUser();

$user = User::getById($user->id);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];

    if (!empty($old_password)) {
        if (!password_verify($old_password, $user->password)) {
            $errors[] = 'Incorrect old password.';
            return;
        }

        if (empty($new_password) || $new_password !== $repeat_password) {
            $errors[] = 'New password is empty or does not match.';
            return;
        }

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/", $new_password)) {
            $errors[] = "Password should have at least 7 symbols, at least one uppercase letter, one lowercase letter, and one number";
            return;
        }
    }

    if (empty($errors)) {
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->birthdate = $birthdate;
        $user->password = $new_password;

        $user->update();

        $_SESSION['user'] = serialize($user);

        header('Location: index.php?action=profile');
        exit;
    }
}
?>

<main class="edit-profile">
    <h1>Edit Profile</h1>

    <form method="post">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= $user->first_name ?? '' ?>">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= $user->last_name ?? '' ?>">

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" value="<?= $user->birthdate ?? '' ?>">

        <label for="old_password">Old Password:</label>
        <input type="password" name="old_password">

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password">

        <label for="repeat_password">Repeat New Password:</label>
        <input type="password" name="repeat_password">

        <button type="submit">Save Changes</button>
    </form>

    <?php require_once 'layout/error_list.php' ?>
</main>