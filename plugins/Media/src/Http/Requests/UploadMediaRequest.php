<?php

namespace plugins\Media\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UploadMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id' => [
                'required',
                'uuid',
            ],
            'file' => [
                'required',
                'file',
                'mimes:mp4,mov,avi,pdf,docx,zip,png,jpg',
                'max:51200',
            ],
        ];
    }

    public function lessonId(): string
    {
        return $this->validated('lesson_id');
    }

    public function uploadedFile(): UploadedFile
    {
        return $this->file('file');
    }
}
