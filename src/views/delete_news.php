<?php

global $conn;

if (!isSignedIn()) {
    header("Location: index.php?action=login");
}

if (!isset($_GET["id"])) {
    header("Location: index.php?action=news");
}

$article_id = intval($_GET["id"]);
$article = getNewsById($article_id);

if (!$article) {
    header("Location: index.php?action=news");
}

if ($_SESSION["user"]) {
    $user = unserialize($_SESSION["user"]);
    if ($user->is_admin || $user->id == $article["author_id"]) {
        if (isset($_GET["action"]) && $_GET["action"] == "delete_news") {
            deleteNews($conn, $article_id);

            header("Location: index.php?action=news");
        }
    }
}

header("Location: index.php?action=news");
