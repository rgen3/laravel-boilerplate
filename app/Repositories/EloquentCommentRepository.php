<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Comment;

class EloquentCommentRepository extends EloquentBaseRepository
{
    /** @var Comment */
    protected $model;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function saveAndPublish()
    {}

    public function saveAndModerate()
    {}

    public function save()
    {}

    public function destroy()
    {}

}
