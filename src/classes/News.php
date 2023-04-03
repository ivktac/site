<?php

class News
{
    public $id;
    public $title;
    public $content;
    public $visibility;
    public $author_id;


    public function __construct()
    {
        $this->id = -1;
        $this->title = "";
        $this->content = "";
        $this->visibility = 1;
        $this->author_id = -1;

    }

    public function save()
    {
        global $conn;

        $sql = "INSERT INTO news (title, content, visibility, author_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssii",
            $this->title,
            $this->content,
            $this->visibility,
            $this->author_id,
        );

        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    public function update() {
        global $conn;

        $sql = "UPDATE news SET title = ?, content = ?, visibility = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssii",
            $this->title,
            $this->content,
            $this->visibility,
            $this->id
        );

        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    public function delete()
    {
        global $conn;

        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $this->id);

        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            die(mysqli_error($conn));
        }
    }
}
