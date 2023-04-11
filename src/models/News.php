<?php


class News
{
    public int $id = 0;
    public string $title;
    public string $content;
    public bool $visibility;
    public int $author_id;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(
        int $id,
        string $title,
        string $content,
        bool $visibility,
        int $author_id,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->visibility = $visibility;
        $this->author_id = $author_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromStdClass(stdClass $data): News
    {
        return new self(
            (int)$data->id,
            $data->title,
            $data->content,
            (bool)$data->visibility,
            (int)$data->author_id,
            $data->created_at ?? null,
            $data->updated_at ?? null
        );
    }

    public static function getAll(): array
    {
        global $conn;

        $query = "SELECT news.*, users.login as login 
        FROM news
        JOIN users ON news.author_id = users.id
        WHERE visibility = 1
        ";

        if (User::isAuth()) {
            $user = User::getAuthUser();
            if ($user->admin) {
                $query = str_replace("WHERE visibility = 1", "", $query);
            } else {
                $query .= "OR author_id = {$user->id}";
            }
        }

        $result = mysqli_query($conn, $query);

        if (!$result) {
            die(mysqli_error($conn));
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function getById(int $id): ?News
    {
        global $conn;

        $query = "SELECT * FROM news WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $id);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die(mysqli_error($conn));
        }

        $result = mysqli_stmt_get_result($stmt);

        $news = mysqli_fetch_object($result);

        if (!$news) {
            return null;
        }

        return self::fromStdClass($news);
    }

    public static function deleteById(int $id): void
    {
        global $conn;

        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    public function save(): void
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
            $this->author_id
        );

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    function update(): void
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
}
