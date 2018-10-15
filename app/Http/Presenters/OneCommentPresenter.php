<?php
declare(strict_types = 1);

namespace App\Http\Presenters;

use App\Models\Comment;
use Carbon\Carbon;

class OneCommentPresenter
{
    /** @var Comment */
    private $comment;

    /** @var int */
    private $currentUserId;

    public function __construct(Comment $comment, int $currentUserId)
    {
        $this->comment = $comment;
        $this->currentUserId = $currentUserId;
    }

    public function toArray()
    {
        return [
            'id' => $this->comment->id,
            'parentId' => $this->comment->parent_id,
            'text' => $this->comment->text,
            'json' => $this->comment->raw_comment,
            'isFavourite' => false,
            'canEdit' => $this->currentUserId === $this->comment->user_id,
            'commentTime' => Carbon::parse($this->comment->created_at)->toDateTimeString(),
            'updateTime' => Carbon::parse($this->comment->updated_at)->toDateTimeString()
        ];
    }
}
