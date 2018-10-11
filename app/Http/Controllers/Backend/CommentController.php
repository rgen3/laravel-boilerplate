<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Backend;

use App\Models\Comment;
use App\Repositories\EloquentCommentRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Utils\RequestSearchQuery;
use Illuminate\Http\Request;


class CommentController extends BackendController
{
    /** @var EloquentCommentRepository */
    private $comments;

    /**
     * @param EloquentCommentRepository $comments
     */
    public function __construct(EloquentCommentRepository $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(Request $request)
    {
        /** @var Builder $query */
        $query = $this->comments->query();

        $query->join('users', 'users.id', '=', 'user_id');

        $requestSearchQuery = new RequestSearchQuery($request, $query);

        return $requestSearchQuery->result([
            'comments.id',
            'model_type',
            'model_id',
            'status',
            'body',
            'users.id as userId',
            'users.name',
            'comments.deleted_at',
            'comments.created_at',
            'comments.updated_at',
        ]);
    }

    /**
     * @param Comment $comment
     * @return Comment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);

        $user = $comment->owner;

        $comment->setAttribute('userForSelect', [
                'id' => $user->id,
                'title' => sprintf('#%d. %s (%s)', $user->id, $user->name, $user->email)
            ]
        );

        return $comment;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create');

        $category = $this->comments->make(
            $request->only('body', 'status')
        );

        $this->comments->save($category, $request->input());

        return $this->redirectResponse($request, __('alerts.backend.comment.created'));
    }

    public function update(Comment $comment, Request $request)
    {
        $this->authorize('update', $comment);

        $comment->fill(
            $request->only('id', 'body', 'status')
        );

        $this->comments->save($comment, $request->input(), $request->file('featured_image'));

        return $this->redirectResponse($request, __('alerts.backend.comment.updated'));
    }

    public function destroy(Comment $category, Request $request)
    {
        $this->authorize('delete');

        $this->comments->destroy($category);

        return $this->redirectResponse($request, __('alerts.backend.comment.deleted'));
    }
}
