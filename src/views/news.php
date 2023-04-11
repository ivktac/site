<?php

require_once 'db.php';

global $conn;

$news = News::getAll();

$convertDateTime = function (string $date): string {
	return date("d/m/Y H:i", strtotime($date));
};
?>

<main class="page-news">
	<h1>News</h1>


	<div class="articles">
		<?php if (isset($_SESSION["user"])): ?>
			<a class="article-action" href="index.php?action=create_news">Add news</a>
		<?php endif ?>
		<?php if (empty($news)): ?>
			<p>There are no news to display.</p>
		<?php endif ?>
		<?php foreach ($news as $article): ?>
			<div class="article">
				<h2>
					<?= $article["title"] ?>
				</h2>
				<div class="article-info">
					<p class="date"><span>Created:</span>
						<?= $convertDateTime($article["created_at"]) ?>
					</p>
					<p class="author"><span>Author</span>
						<?= $article["login"] ?>
					</p>
					<p class="date"><span> Updated:</span>
						<?= $convertDateTime($article["updated_at"]) ?>
					</p>
				</div>
				<div class="content">
					<?= substr($article["content"], 0, 100) ?>...
				</div>
				<p class="read-more">
					<a class="article-action" href="index.php?action=view_news&id=<?= $article["id"] ?>">
						Read more</a>
				</p>
			</div>
		<?php endforeach; ?>
	</div>
</main>