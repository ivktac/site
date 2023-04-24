<?php

class Comment
{
    public int $id;
    public string $text;
    public int $user_id;
    public int $news_id;
    public ?string $created_at  = null;

    public function __construct($id, $text, $user_id, $news_id, ?string $created_at = null)
    {
        $this->id = $id;
        $this->text = $text;
        $this->user_id = $user_id;
        $this->news_id = $news_id;
        $this->created_at = $created_at;
    }

    public static function fromStdClass(stdClass $data): Comment
    {
        return new self(
            (int) $data->id,
            $data->text,
            (int) $data->user_id,
            (int) $data->news_id,
            $data->created_at ?? null
        );
    }

    public static function getById(int $id): ?Comment
    {
        global $mysqli;

        $query = "SELECT * FROM comments WHERE id = $id";

        $result = $mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        return self::fromStdClass($result->fetch_object());
    }

    public static function deleteById(int $id): void
    {
        global $mysqli;

        $query = "DELETE FROM comments WHERE id = $id";

        $mysqli->query($query);
    }

    public function save(): void
    {
        global $mysqli;

        $query = "INSERT INTO comments (text, user_id, news_id) VALUES ('$this->text', $this->user_id, $this->news_id)";

        $mysqli->query($query);
    }

    public function getAuthor(): User
    {
        return User::getById($this->user_id);
    }
}
