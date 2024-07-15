<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|uuid|exists:categories,id',
            'settings' => 'sometimes|array',
            'settings.*.price' => 'required|numeric',
            'settings.*.visibility' => 'required|boolean',
            //'settings.*.main_picture' => 'required|image|max:2048',
            'settings.*.colors' => 'required|array',
            'settings.*.colors.*.id' => 'required|uuid',
            'settings.*.colors.*.name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'category_id.required' => 'The category field is required.',
            'category_id.uuid' => 'The category ID must be a valid UUID.',
            'category_id.exists' => 'The selected category does not exist.',
            'settings.array' => 'The settings must be an array.',
            'settings.*.price.required' => 'The price field is required for each setting.',
            'settings.*.price.numeric' => 'The price must be a number.',
            'settings.*.visibility.required' => 'The visibility field is required for each setting.',
            'settings.*.visibility.boolean' => 'The visibility must be true or false.',
           
            'settings.*.colors.required' => 'The colors field is required for each setting.',
            'settings.*.colors.array' => 'The colors must be an array.',
            'settings.*.colors.*.id.required' => 'The color ID is required for each color.',
            'settings.*.colors.*.id.uuid' => 'The color ID must be a valid UUID.',
            'settings.*.colors.*.name.required' => 'The color name is required for each color.',
            'settings.*.colors.*.name.string' => 'The color name must be a string.',
        ];
    }

  /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

}
