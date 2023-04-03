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