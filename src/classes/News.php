<?php


class News
{
    public int $id;
    public string $title;
    public string $content;
    public int $visibility;
    public int $author_id;


    public function __construct(string $title, string $content, int $visibility, int $author_id)
    {
        $this->id = -1;
        $this->title = $title;
        $this->content = $content;
        $this->visibility = $visibility;
        $this->author_id = $author_id;
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

    public function update()
    {
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
