<?php


namespace App\Services\ServiceTwoAssets;


class NoteItem
{
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $created_at;
    public $updated_at;

    /**
     * @param array $data
     */
    public function __construct( array $data )
    {
        $this->id      = $data['id'];
        $this->title   = $data['title'];
        $this->content = $data['content'];
        $this->user_id = $data['user_id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
