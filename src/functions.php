<?php

function isSignedIn()
{
    if (isset($_SESSION["user"])) {
        $user = unserialize($_SESSION["user"]);
        if ($user) {
            return true;
        }
    }

    return false;
}

function updateUser($user)
{
    global $conn;

    $query = "UPDATE users SET first_name = ?, last_name = ?, birthdate = ?, password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $user->first_name,
        $user->last_name,
        $user->birthdate,
        $user->password,
        $user->id
    );

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die(mysqli_error($conn));
    }

    $user = getUserById($user->id);

    unset($_SESSION["user"]);

    $_SESSION["user"] = serialize($user);
}

function getUserById($id)
{
    global $conn;

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die(mysqli_error($conn));
    }

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return new User(
            $row["id"],
            $row["login"],
            $row["email"],
            $row["admin"],
            $row["first_name"],
            $row["last_name"],
            $row["birthdate"],
            $row["password"]
        );
    }
}

function getNewsById($id)
{
    if (!isset($_GET["id"])) {
        header("Location: index.php");
    }

    global $conn;

    $sql = "SELECT news.*, users.login as login
    FROM news
    JOIN users ON news.author_id = users.id
    WHERE news.id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die(mysqli_error($conn));
    }

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function saveNews(mysqli $conn, News $news)
{
    $sql = "INSERT INTO news (title, content, visibility, author_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssii",
        $news->title,
        $news->content,
        $news->visibility,
        $news->author_id
    );

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        die(mysqli_error($conn));
    }
}

function updateNews(mysqli $conn, News $news)
{
    $sql = "UPDATE news SET title = ?, content = ?, visibility = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssii",
        $news->title,
        $news->content,
        $news->visibility,
        $news->id
    );

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        die(mysqli_error($conn));
    }
}

function deleteNews(mysqli $conn, $id)
{
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        die(mysqli_error($conn));
    }
}
