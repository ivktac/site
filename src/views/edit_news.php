<?php

require_once 'db.php';

global $mysqli;

if (!User::isAuth()) {
    header("Location: index.php?action=news");
}

$article = News::getById(intval($_GET["id"]));

$user = User::getAuthUser();

if (is_null($article) || $user->id != $article->author_id) {
    header("Location: index.php?action=news");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // remove sql injections
    $title = $mysqli->real_escape_string($_POST["title"]);
    $content = $mysqli->real_escape_string($_POST["content"]);
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

$options = [
    "0" => ["name" => "Private", "value" => "0"],
    "1" => ["name" => "Public", "value" => "1"],
];
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
            <?php foreach ($options as $option) : ?>
                <option value="<?= $option["value"] ?>" <?= $article->visibility == $option["value"] ? "selected" : "" ?>>
                    <?= $option["name"] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Submit" onclick="confirm('Are you sure?')">
    </form>
</main>