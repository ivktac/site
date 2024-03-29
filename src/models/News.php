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
            (int) $data->id,
            $data->title,
            $data->content,
            (bool) $data->visibility,
            (int) $data->author_id,
            $data->created_at ?? null,
            $data->updated_at ?? null
        );
    }

    public static function getAll(): array
    {
        global $mysqli;

        $query = "SELECT news.*, users.login as login FROM news JOIN users ON news.author_id = users.id 
                WHERE visibility = 1";

        if (User::isAuth()) {
            $user = User::getAuthUser();
            if ($user->admin) {
                $query = str_replace("WHERE visibility = 1", "", $query);
            } else {
                $query .= " OR author_id = {$user->id}";
            }
        }

        $result = $mysqli->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById(int $id): ?News
    {
        global $mysqli;

        $result = $mysqli->query("SELECT * FROM news WHERE id = $id");

        if ($result->num_rows === 0) {
            return null;
        }

        $data = $result->fetch_object();

        return self::fromStdClass($data);
    }

    public static function deleteById(int $id): void
    {
        global $mysqli;

        $mysqli->query("DELETE FROM news WHERE id = $id");
    }

    public function save(): void
    {
        global $mysqli;

        $visibility = (int)$this->visibility;

        $mysqli->query("INSERT INTO news (title, content, visibility, author_id) VALUES ('{$this->title}', '{$this->content}', '{$visibility}', '{$this->author_id}')");
    }

    function update(): void
    {
        global $mysqli;

        $mysqli->query("UPDATE news SET title = '{$this->title}', content = '{$this->content}', visibility = '{$this->visibility}' WHERE id = '{$this->id}'");
    }

    function getAuthor(): User
    {
        return User::getById($this->author_id);
    }

    function getComments(): array
    {
        global $mysqli;

        $result = $mysqli->query("SELECT * FROM comments WHERE news_id = {$this->id}");

        $comments = [];

        while ($comment = $result->fetch_object()) {
            $comments[] =  Comment::fromStdClass($comment);
        }

        return $comments;
    }

    function getCommentsCount(): int
    {
        global $mysqli;

        $result = $mysqli->query("SELECT COUNT(*) as count FROM comments WHERE news_id = {$this->id}");

        return $result->fetch_object()->count;
    }
}
