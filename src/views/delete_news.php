<?php

require_once 'db.php';

global $mysqli;

if ($user = User::getAuthUser()) {
    $article = News::getById(intval($_GET["id"]));

    if (!$article) {
        header("Location: index.php?action=news");
        exit;
    }

    if ($user->isAdmin() || $user->id == $article->author_id) {
        News::deleteById($article->id);
    }
}

header("Location: index.php?action=news");
