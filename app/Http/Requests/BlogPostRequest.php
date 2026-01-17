<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    /**
     * @var int|mixed
     */
    public mixed $created_by;

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'subtitle' => ['required'],
            'content' => ['required'],
            'category' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
