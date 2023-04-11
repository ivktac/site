<?php

require_once 'db.php';

global $conn;

if (!User::isAuth()) {
    header("Location: index.php?action=login");
}

if (!isset($_GET["id"])) {
    header("Location: index.php?action=news");
}

$article = News::getById(intval($_GET["id"]));

if (!$article) {
    header("Location: index.php?action=news");
}

$user = User::getAuthUser();

if ($user->id != $article->author_id) {
    header("Location: index.php?action=news");
}

if (isset($_GET["action"]) && $_GET["action"] == "delete_news") {
    News::deleteById($article->id);
}

header("Location: index.php?action=news");
