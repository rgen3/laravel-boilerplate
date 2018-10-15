<?php
declare(strict_types = 1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $modelId
 * @property-read int|null $parentId
 * @property-read string $html
 * @property-read string $json
 */
class CreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return !auth()->guest();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'modelId' => 'integer|required',
            'parentId' => 'integer|nullable',
            'html' => 'string|required',
            'json' => 'array|required',
        ];
    }

    /**
     * @return int
     */
    public function getModelId(): int
    {
        return $this->modelId;
    }

    /**
     * @return int
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @return mixed
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return mixed
     */
    public function getJson(): array
    {
        return (array) $this->json;
    }
}
