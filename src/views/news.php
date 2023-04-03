<?php

global $conn;

$sql = "SELECT news.*, users.login as login 
FROM news
JOIN users ON news.author_id = users.id
WHERE visibility = 1
";

if (isset($_SESSION["user"])) {
	$user = unserialize($_SESSION["user"]);
	if ($user->is_admin) {
		$sql = str_replace("WHERE visibility = 1", "", $sql);
	} else {
		$sql .= " OR author_id = " . $user->id;
	}
}

$result = mysqli_query($conn, $sql . " ORDER BY created_at DESC");
if (!$result) {
	die('Query failed: ' . mysqli_error($conn));
}

$news = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="page-news">
	<h1>News</h1>


	<div class="articles">
		<?php if (isset($_SESSION["user"])) : ?>
			<a class="article-action" href="index.php?action=create_news">Add news</a>
		<?php endif ?>
		<?php if (empty($news)) : ?>
			<p>There are no news to display.</p>
		<?php endif ?>
		<?php foreach ($news as $article) : ?>
			<div class="article">
				<h2><?= $article["title"] ?></h2>
				<div class="article-info">
					<p class="date"><span>Created:</span> <?= date("d/m/Y H:i", strtotime($article["created_at"])) ?></p>
					<p class="author"><span>Author</span> <?= $article["login"] == $user->login ? "You" : $article["login"] ?></p>
					<p class="date"><span> Updated:</span> <?= date("d/m/Y H:i", strtotime($article["updated_at"])) ?></p>
				</div>
				<div class="content">
					<?= substr($article["content"], 0, 100) ?>...
				</div>
				<p class="read-more"><a class="article-action" href="index.php?action=view_news&id=<?= $article["id"] ?>">Read more</a></p>
			</div>
		<?php endforeach; ?>
	</div>
</main>