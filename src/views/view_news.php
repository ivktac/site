<?php

if (!isset($_GET["id"])) {
    header("Location: index.php?action=news");
}

$article_id = intval($_GET["id"]);
$article = getNewsById($article_id);

?>

<main class="page-news">
    <?php if (!$article) : ?>
        <h1>Article not found</h1>
    <?php else : ?>
        <div class="article">
            <h2><?= $article["title"] ?></h2>
            <div class="article-info">
                <p class="date"><span>Created:</span> <?= date("d/m/Y H:i", strtotime($article["created_at"])) ?></p>
                <p class="author"><span>Author</span> <?= $article["login"] ?></p>
                <p class="date"><span> Updated:</span> <?= date("d/m/Y H:i", strtotime($article["updated_at"])) ?></p>
            </div>
            <div class="content">
                <?= $article["content"] ?>
            </div>

            <div class="article-actions">
                <?php if (isset($_SESSION["user"])) : ?>
                    <?php $user = unserialize($_SESSION["user"]); ?>
                    <?php if ($user->is_admin || $user->id == $article["author_id"]) : ?>
                        <a class="article-action" href="index.php?action=edit_news&id=<?= $article["id"] ?>">Edit</a>
                        <a class="article-action" href="index.php?action=delete_news&id=<?= $article["id"] ?>">Delete</a>
                    <?php endif ?>
                <?php endif; ?>
                <a class="article-action" href="index.php?action=news">Back</a>
            </div>
        </div>
    <?php endif ?>
</main>