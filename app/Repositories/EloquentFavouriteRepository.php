<?php

namespace App\Repositories;

use App\Models\Favourite;
use App\Repositories\Contracts\FavouriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EloquentFavouriteRepository extends EloquentBaseRepository implements FavouriteRepository
{
    /** @var Favourite */
    protected $model;

    public function __construct(Favourite $model)
    {
        parent::__construct($model);
    }

    /**
     * @param bool $toggle
     * @param string $modelType
     * @param int $modelId
     * @param int $userId
     */
    public function toggleFavourite(bool $toggle, string $modelType, int $modelId, int $userId)
    {
        if ($toggle) {
            $this->addToFavourite($modelType, $modelId, $userId);
        } else {
            $this->removeFromFavourite($modelType, $modelId, $userId);
        }
    }

    /**
     * @param string $modelType
     * @param int $modelId
     * @param int $userId
     *
     * @return Favourite
     */
    public function addToFavourite(string $modelType, int $modelId, int $userId)
    {
        /** @var Favourite $model */
        $model = $this->query()->firstOrCreate([
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'user_id'    => $userId,
        ]);

        return $model;
    }

    /**
     * @param string $modelType
     * @param int $modelId
     * @param int $userId
     *
     * @return bool|mixed|null
     */
    public function removeFromFavourite(string $modelType, int $modelId, int $userId)
    {
        return $this->query()->firstOrNew([
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'user_id'    => $userId,
        ])->delete();
    }

    /**
     * @param string $type
     * @param int $userId
     *
     * @return Builder
     */
    public function getUserFavouritesByType(string $type, int $userId): Builder
    {
        if (! array_key_exists($type, Favourite::EXISTING_TYPES)) {
            abort(404);
        }

        /** @var Model $model */
        $model = Favourite::EXISTING_TYPES[$type];

        return $model::with(['favourite'])
            ->join('favourites', 'favourites.model_id', 'id', 'inner')
            ->where([
                'favourites.model_type'         => $model,
                'favourites.user_id' => $userId,
            ])
            ->orderBy('favourites.created_at', 'desc');
    }

    /**
     * @param int $userId
     * @param string $modelType
     * @param array $modelIds
     * @return array
     */
    public function getIsUserFavouriteByIds(int $userId, string $modelType, array $modelIds): array
    {
        return $this->model->query()
            ->select(['model_id'])
            ->where([
                'model_type' => $modelType,
                'user_id' => $userId
            ])
            ->whereIn('model_id', $modelIds)
            ->get()
            ->pluck('model_id', 'model_id')
            ->toArray();
    }
}
