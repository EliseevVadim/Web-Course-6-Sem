<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'attachment' => 'required|max:1024|mimes:csv,xlsx,xlsm'
        ];
    }
}
