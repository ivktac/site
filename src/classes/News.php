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
}
