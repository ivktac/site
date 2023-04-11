<?php

require_once 'db.php';

global $conn;

$article = News::getById(intval($_GET["id"]));

if (!User::isAuth()) {
    header("Location: index.php?action=news");
}

$user = User::getAuthUser();

if ($user->id != $article->author_id) {
    header("Location: index.php?action=news");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_escape_string($conn, $_POST["title"]);
    $content = mysqli_escape_string($conn, $_POST["content"]);
    $visibility = intval($_POST["visibility"]);

    $news = new News(
        intval($_GET["id"]),
        $title,
        $content,
        $visibility,
        $user->id,
    );
    $news->update();

    header("Location: index.php?action=news");
}

?>

<main class="page-edit-news">
    <h1>Edit news</h1>

    <form method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required value="<?= $article->title ?>">
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10" required><?= $article->content ?></textarea>
        <label for="visibility">Visibility</label>
        <select name="visibility" id="visibility">
            <?php if ($article->visibility == 1) : ?>
                <option value="1" selected>Public</option>
                <option value="0">Private</option>
            <?php else : ?>
                <option value="1">Public</option>
                <option value="0" selected>Private</option>
            <?php endif ?>
        </select>
        <input type="submit" value="Submit" onclick="confirm('Are you sure?')">
    </form>
</main>