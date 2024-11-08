<?php

namespace App\Hexagon\Application\Requests\Select;

use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Services\Traits\TransformerTrait;
use App\Services\Utils\DataCleaner;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SelectRequest extends FormRequest
{
    use TransformerTrait;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'nullable|array',
            'limit' => 'required|integer|in:25,50,100,250|min:1',
            'page' => 'required|integer|min:1',
            'search' => 'nullable|string|max:255',
            'params' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'value.array' => __('messages.validation.array', ['attribute' => __('validation.attributes.value')]),

            'limit.required' => __('messages.validation.required', ['attribute' => __('validation.attributes.limit')]),
            'limit.integer' => __('messages.validation.integer', ['attribute' => __('validation.attributes.limit')]),
            'limit.in' => __('messages.validation.in', ['attribute' => __('validation.attributes.limit')]),
            'limit.min' => __('messages.validation.min.numeric', ['attribute' => __('validation.attributes.limit'), 'min' => 1]),

            'page.required' => __('messages.validation.required', ['attribute' => __('validation.attributes.page')]),
            'page.integer' => __('messages.validation.integer', ['attribute' => __('validation.attributes.page')]),
            'page.min' => __('messages.validation.min.numeric', ['attribute' => __('validation.attributes.page'), 'min' => 1]),

            'search.string' => __('messages.validation.string', ['attribute' => __('validation.attributes.search')]),
            'search.max' => __('messages.validation.max.string', ['attribute' => __('validation.attributes.search'), 'max' => 255]),

            'params.array' => __('messages.validation.array', ['attribute' => __('validation.attributes.params')]),
        ];
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }


    public function buildDto(): SelectRequestDto
    {
        return SelectRequestDto::from(DataCleaner::cleanData($this->validated()));
    }
}
