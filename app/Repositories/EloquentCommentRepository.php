<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\CommentRepository;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepository
{
    /** @var Comment */
    protected $model;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $commentId
     * @param $commentHtml
     * @param $commentJson
     * @return Comment
     * @throws \Throwable
     */
    public function updateUserComment($commentId, $commentHtml, $commentJson)
    {
        /** @var Comment $comment */
        $comment = $this->model->query()->findOrFail($commentId);

        if (! Gate::check('update', $comment)) {
//            throw new GeneralException(__('exceptions.backend.comments.update'));
        }

        $comment->setAttribute('text', $commentHtml);
        $comment->setAttribute('raw_comment', $commentJson);
        $comment->saveOrFail();
        return $comment;
    }

    public function saveAndPublish()
    {}

    public function saveAndModerate()
    {}

    /**
     * @param string $modelType
     * @param int $modelId
     * @param int $userId
     * @param string $html
     * @param array $json
     * @param null $parentId
     * @return Comment
     * @throws \Throwable
     */
    public function save(string $modelType, int $modelId, int $userId, string $html, array $json, $parentId = null): Comment
    {
        /** @var Comment $comment */
        $comment = new Comment();
        $comment->setAttribute('model_type', $modelType);
        $comment->setAttribute('model_id', $modelId);
        $comment->setAttribute('user_id', $userId);
        $comment->setAttribute('text', $html);
        $comment->setAttribute('raw_comment', $json);
        $comment->setAttribute('parent_id', $parentId);
        $comment->setAttribute('status', Comment::STATUS_NEW);

        $comment->saveOrFail();

        return $comment;
    }

    public function destroy()
    {}

    public function getAllModelComments(string $type, int $id)
    {
        return $this->model->query()
            ->where(['model_type' => $type, 'model_id' => $id])
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
