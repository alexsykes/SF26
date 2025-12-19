<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'Subject' => ['required'],
            'Content' => ['required'],
            'Attachment' => ['nullable'],
            'UpdatedBy' => ['nullable'],
            'ReplyToAddress' => ['nullable'],
            'ReplyToName' => ['nullable'],
            'OriginalName' => ['nullable'],
            'MimeType' => ['nullable'],
            'Summary' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
