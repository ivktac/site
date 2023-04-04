<?php

if (!isSignedIn()) {
    header("Location: index.php?action=login");
}

$user = unserialize($_SESSION["user"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_escape_string($conn, $_POST["title"]);
    $content = mysqli_escape_string($conn, $_POST["content"]);
    $visibility = mysqli_escape_string($conn, $_POST["visibility"]);

    $news = new News($title, $content, $visibility, $user->id);
    $news->save();

    header("Location: index.php?action=news");
}


?>

<main class="page-create-news">
    <form method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10" required></textarea>
        <label for="visibility">Visibility</label>
        <select name="visibility" id="visibility">
            <option value="1">Public</option>
            <option value="0">Private</option>
            <input type="submit" value="Submit" onclick="confirm('Are you sure?')">
    </form>
</main>