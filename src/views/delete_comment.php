<?php

require_once 'db.php';

global $mysqli;

if (!User::isAuth()) {
    header("Location: index.php?action=login");
}

$comment_id = intval($_GET["id"]);

$comment = Comment::getById($comment_id);

if (!$comment) {
    header("Location: index.php?action=news");
}

if ($user = User::getAuthUser()) {
    if ($user->isAdmin() || $user->id == $comment->user_id) {
        Comment::deleteById($comment->id);
    }
}

header("Location: index.php?action=view_news&id=$comment->news_id");
