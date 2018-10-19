<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Presenters\OneCommentPresenter;
use App\Http\Requests\Comment\CreateRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Models\Post;
use App\Repositories\Contracts\CommentRepository;
use App\Repositories\EloquentCommentRepository;

class CommentController extends Controller
{
    /** @var EloquentCommentRepository */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param UpdateRequest $request
     * @return array
     * @throws \Throwable
     */
    public function update(UpdateRequest $request)
    {
        $comment = $this->commentRepository->updateUserComment($request->getId(), $request->getHtml(), $request->getJson());

        return  [
            'comment' => (new OneCommentPresenter($comment, [], auth()->id()))->toArray(),
        ];
    }

    /**
     * @param CreateRequest $request
     * @return array
     * @throws \Throwable
     */
    public function createPostComment(CreateRequest $request)
    {
        $this->authorize('create comment');

        $comment = $this->commentRepository->save(
            Post::class,
            $request->getModelId(),
            auth()->id(),
            $request->getHtml(),
            $request->getJson(),
            $request->getParentId()
        );

        return [
            'comment' => (new OneCommentPresenter($comment, [], auth()->id()))->toArray(),
        ];
    }
}
