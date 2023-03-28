<?php

global $conn;

$sql = "SELECT * FROM news WHERE (visibility = 1";

if (isset($_SESSION["user"])) {
	$user = unserialize($_SESSION["user"]);
	$sql .= "OR $user->is_admin = 1 OR visibility = 0 AND $user->id = news.author_id";
}

$result = mysqli_query($conn, $sql . ") ORDER BY created_at DESC");
if (!$result) {
	die('Query failed: ' . mysqli_error($conn));
}

$news = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="page-news">
	<h1>News</h1>
	<?php foreach ($news as $article) : ?>
		<div class="article">
			<h2><?= $article["title"] ?></h2>
			<p class="date">Created at: <?= $article["created_at"] ?></p>
			<p class="author">Author: <?= $article["author_id"] ?></p>
			<div class="content">
				<?= $article["content"] ?>
			</div>
		</div>
	<?php endforeach; ?>
</main>