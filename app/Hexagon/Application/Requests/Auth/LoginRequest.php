<?php

namespace App\Hexagon\Application\Requests\Auth;

use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Services\Traits\TransformerTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.email')]),
            'email.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.email')]),
            'email.email' => __('messages.validation.email', ['attribute' => __('messages.validation.attributes.email')]),
            'email.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.email'),
                'max' => 255
            ]),

            'password.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.password')]),
            'password.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.password')]),
            'password.min' => __('messages.validation.min.string', [
                'attribute' => __('messages.validation.attributes.password'),
                'min' => 6
            ]),
            'password.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.password'),
                'max' => 255
            ]),
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


    /**
     * @throws InvalidClassException
     */
    public function buildDto(): BaseDto
    {
        return $this->transformToDTO(LoginRequestDto::class, $this->validated());
    }
}
