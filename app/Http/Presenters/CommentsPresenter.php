<?php
declare(strict_types = 1);

namespace App\Http\Presenters;

use Illuminate\Support\Collection;

class CommentsPresenter
{
    /** @var Collection */
    private $comments;

    /** @var ?int */
    private $currentUserId;

    /** @var array */
    private $favouriteComments;

    /**
     * @param Collection $comments
     * @param array $favouriteComments
     * @param int|null $currentUserId
     */
    public function __construct(Collection $comments, array $favouriteComments, ?int $currentUserId)
    {
        $this->comments = $comments;
        $this->favouriteComments = $favouriteComments;
        $this->currentUserId = $currentUserId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->comments->map(function ($item) {
            return (new OneCommentPresenter($item, $this->favouriteComments, $this->currentUserId))->toArray();
        })->toArray();
    }

    /**
     * @return array
     */
    public function toTree(): array
    {
        $comments = $this->toArray();
        return $this->makeTree($comments);
    }

    private function makeTree(&$items, $root = 0) {
        $result = [];
        foreach ($items as &$item) {
            if ($item['parentId'] == $root) {
                $result[$item['id']] = $item;
                $result[$item['id']]['children'] = array_values($this->makeTree($items, $item['id']));
                unset($item);
            }
        }
        return array_values($result);
    }
}
