<?php

namespace App\Hexagon\Application\Requests\Auth;

use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Services\Traits\TransformerTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|min:6|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.name')]),
            'name.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.name')]),
            'name.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.name'),
                'max' => 255
            ]),

            'surname.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.surname')]),
            'surname.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.surname')]),
            'surname.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.surname'),
                'max' => 255
            ]),

            'username.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.username')]),
            'username.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.username')]),
            'username.min' => __('messages.validation.min.string', [
                'attribute' => __('messages.validation.attributes.username'),
                'min' => 6
            ]),
            'username.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.username'),
                'max' => 255
            ]),
            'username.unique' => __('messages.validation.unique', ['attribute' => __('messages.validation.attributes.username')]),

            'email.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.email')]),
            'email.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.email')]),
            'email.email' => __('messages.validation.email', ['attribute' => __('messages.validation.attributes.email')]),
            'email.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.email'),
                'max' => 255
            ]),
            'email.unique' => __('messages.validation.unique', ['attribute' => __('messages.validation.attributes.email')]),

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
            'password.confirmed' => __('messages.validation.confirmed', ['attribute' => __('messages.validation.attributes.password')]),
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
        return $this->transformToDTO(RegisterRequestDto::class, $this->validated());
    }
}
