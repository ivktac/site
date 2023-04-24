<?php

require 'db.php';

global $mysqli;

$user = User::getAuthUser();

$news_id = intval($_GET["id"]);

$news = News::getById($news_id);

if (!$news) {
    header("Location: index.php?action=news&id=$news_id");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = $mysqli->escape_string($_POST["text"]);

    $comment = new Comment(0, $text, $user->id, $news->id);

    $comment->save();
    header("Location: index.php?action=view_news&id=$news_id");
}

?>

<main class="page-create-comment">
    <h1>Add comment</h1>
    <form method="POST">
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <button type="submit">Add comment</button>
    </form>
</main>