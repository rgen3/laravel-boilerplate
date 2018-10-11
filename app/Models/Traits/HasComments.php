<?php
declare(strict_types = 1);

namespace App\Models\Traits;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(statid::class, 'commentable');
    }
}
