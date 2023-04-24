<?php

require_once 'db.php';

global $mysqli;

if (!isset($_GET["id"])) {
    header("Location: index.php?action=news");
}

$article = News::getById(intval($_GET["id"]));

if ($article) {
    $author = $article->getAuthor();
}

$user = User::getAuthUser();
$is_admin = User::isAdmin();

?>

<main class="page-news">
    <div class="article">
        <?php if (!$article) : ?>
            <h1>Article not found</h1>
        <?php else : ?>
            <a class="button-back" href="index.php?action=news">Back</a>
            <br>
            <br>

            <div class="article-actions">
                <?php if ($is_admin || (User::isAuth() && $article->author_id === $user->id)) : ?>
                    <a class="article-action" href="index.php?action=edit_news&id=<?= $article->id ?>">Edit</a>
                    <a class="article-action" href="index.php?action=delete_news&id=<?= $article->id ?>">Delete</a>
                <?php endif ?>
            </div>

            <h2><?= $article->title ?></h2>
            <div class="article-info">
                <p class="date"><span>Created:</span> <?= date("d/m/Y H:i", strtotime($article->created_at)) ?></p>
                <p class="author"><span>Author</span> <?= $author->login ?></p>
                <p class="date"><span> Updated:</span> <?= date("d/m/Y H:i", strtotime($article->updated_at)) ?></p>
            </div>
            <div class="content">
                <?= $article->content ?>
            </div>

            <div class="news-comments">
                <h3>Comments</h3>
                <?php if (User::isAuth()) : ?>
                    <a class="article-action" href="index.php?action=create_comment&news_id=<?= $article->id ?>">Add comment</a>
                <?php else : ?>
                    <p>You must be logged in to leave a comment.</p>
                <?php endif ?>
                <?php foreach ($article->getComments() as $comment) : ?>
                    <p>
                        <span><?= $comment->getAuthor()->login ?></span>
                        (<?= date("d/m/Y H:i", strtotime($comment->created_at)) ?>):
                        <?= $comment->text ?>
                        <?php if ($is_admin || (User::isAuth() && $comment->user_id === $user->id)) : ?>
                            <a class="article-action delete-comment-action" href="index.php?action=delete_comment&id=<?= $comment->id ?>">Delete</a>
                        <?php endif ?>
                    </p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</main>