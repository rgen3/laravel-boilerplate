<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Presenters\CommentsPresenter;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Facades\SEOMeta;
use App\Repositories\Contracts\CommentRepository;
use App\Repositories\EloquentCommentRepository;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\PostRepository;

class BlogController extends FrontendController
{
    /**
     * @var PostRepository
     */
    protected $posts;

    /** @var EloquentCommentRepository */
    private $commentRepository;

    /**
     * @param PostRepository $posts
     * @param CommentRepository $commentRepository
     */
    public function __construct(PostRepository $posts, CommentRepository $commentRepository)
    {
        parent::__construct();

        $this->posts = $posts;
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        return view('frontend.blog.index')->withPosts(
            $this->posts->published()->paginate(9)
        );
    }

    public function tag(Tag $tag)
    {
        $this->setTranslatable($tag);

        return view('frontend.blog.tag')->withTag($tag)->withPosts(
            $this->posts->publishedByTag($tag)->paginate(9)
        );
    }

    public function owner(User $user)
    {
        $this->setLocalesAttributes(['user' => $user->slug]);

        return view('frontend.blog.owner')
            ->withUser($user)
            ->withPosts($this->posts->publishedByOwner($user)->paginate(9));
    }

    public function show(Post $post, Request $request)
    {
        // If not published, only user with edit access can see it
        if (! $post->published && ! Gate::check('update', $post)) {
            abort(404);
        }

        SEOMeta::setTitle($post->meta_title);
        SEOMeta::setDescription($post->meta_description);

        $this->setTranslatable($post);

        $comments = $this->commentRepository->getAllModelComments(Post::class, $post->id);
        $commentsTree = (new CommentsPresenter($comments, auth()->guest() ? -1 : auth()->id()));

        return view('frontend.blog.show')
            ->withComments($commentsTree->toTree())
            ->withPost($post);
    }
}
