<?php


$article_id = intval($_GET["id"]);
$article = getNewsById($article_id);

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
    if ($user->id != $article["author_id"]) {
        header("Location: index.php?action=news");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $content = mysqli_real_escape_string($conn, $_POST["content"]);
    $visibility = intval($_POST["visibility"]);    

    $news = new News($title, $content, $visibility, $user->id);
    $news->id = $_GET["id"];
    $news->update();

    header("Location: index.php?action=news");
}

?>

<main class="page-edit-news">
    <h1>Edit news</h1>

    <form method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required value="<?= $article["title"] ?>">
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10" required><?= $article["content"] ?></textarea>
        <label for="visibility">Visibility</label>
        <select name="visibility" id="visibility">
            <?php if ($article["visibility"] == 1) : ?>
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