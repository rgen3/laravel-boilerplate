<?php
declare(strict_types = 1);

namespace App\Models;

use App\Models\Traits\Favouritable;
use App\Models\Traits\HasEditor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasEditor;
    use Favouritable;
    use SoftDeletes;

    public const STATUS_NEW = 0;
    public const STATUS_DRAFT = 1;
    public const STATUS_ON_MODERATION = 2;
    public const STATUS_PUBLISHED = 3;

    public $editorFields = [
        'text',
    ];

    protected $appends = [
        'state',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'status' => 'integer',
        'raw_comment' => 'json',
    ];

    protected $fillable = [
        'status',
        'text',
        'raw_comment'
    ];

    public $with = [
        'owner'
    ];

    public function getCanEditAttribute()
    {
        return true;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'labels.backend.comment.statuses.new',
            self::STATUS_DRAFT => 'labels.backend.comment.statuses.draft',
            self::STATUS_ON_MODERATION => 'labels.backend.comment.statuses.on_moderation',
            self::STATUS_PUBLISHED => 'labels.backend.comment.statuses.published',
        ];
    }

    public static function getStates()
    {
        return [
            self::STATUS_NEW => 'danger',
            self::STATUS_DRAFT => 'warning',
            self::STATUS_ON_MODERATION => 'info',
            self::STATUS_PUBLISHED => 'success',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status];
    }

    public function getStateAttribute()
    {
        return self::getStates()[$this->status];
    }

    public function getPublishedAttribute()
    {
        return self::STATUS_PUBLISHED === $this->status;
    }

    public function getCanDeleteAttribute()
    {
        return Gate::check('delete', $this);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeWithOwner(Builder $query, User $user)
    {
        return $query->where('user_id', '=', $user->id);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
