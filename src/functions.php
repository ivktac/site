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