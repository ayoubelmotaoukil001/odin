<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;

class StoreLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
        {
            return [
                'title' => 'required|string|max:255',
                'url' => [
                    'required',
                    'url',
                
                    Rule::unique('links')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
                ],
                'category_id' => 'nullable|exists:categories,id',
            ];
        }
}
