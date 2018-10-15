<?php
declare(strict_types = 1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $id
 * @property-read array $data
 */
class UpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return ! auth()->guest();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'integer|required',
            'data.html' => 'string|required',
            'data.json' => 'array|required',
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHtml(): string
    {
        return $this->data['html'];
    }

    /**
     * @return mixed
     */
    public function getJson(): array
    {
        return $this->data['json'];
    }
}
