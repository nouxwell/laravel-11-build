<?php

namespace App\Hexagon\Application\Requests\Datatable;

use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Services\Traits\TransformerTrait;
use App\Services\Utils\DataCleaner;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DatatableRequest extends FormRequest
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
            'column' => [
                'required',
                'string',
                'max:255'
            ],
            'filters' => [
                'nullable',
                'array'
            ],
            'limit' => [
                'required',
                'integer',
                'in:25,50,100,250',
                'min:1'
            ],
            'page' => [
                'required',
                'integer',
                'min:1'
            ],
            'sort' => [
                'required',
                'string',
                'in:asc,desc,ASC,DESC'
            ],
            'search' => [
                'nullable',
                'string',
                'max:255'
            ],
//            'model' => [
//                'required',
//                'string'
//            ],
            'exportOption' => [
                'nullable',
                'array',
            ],
            'exportOption.type' => [
                'required_with:exportOption',
                'string',
                'max:255'
            ],
            'exportOption.columns' => [
                'required_with:exportOption',
                'array'
            ],
            'exportOption.fileName' => [
                'required_with:exportOption',
                'string',
                'max:255'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'column.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.column')]),
            'column.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.column')]),
            'column.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.column'),
                'max' => 255
            ]),

            'filters.array' => __('messages.validation.array', ['attribute' => __('messages.validation.attributes.filters')]),

            'limit.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.limit')]),
            'limit.integer' => __('messages.validation.integer', ['attribute' => __('messages.validation.attributes.limit')]),
            'limit.in' => __('messages.validation.in', ['attribute' => __('messages.validation.attributes.limit')]),
            'limit.min' => __('messages.validation.min.numeric', [
                'attribute' => __('messages.validation.attributes.limit'),
                'min' => 1
            ]),

            'page.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.page')]),
            'page.integer' => __('messages.validation.integer', ['attribute' => __('messages.validation.attributes.page')]),
            'page.min' => __('messages.validation.min.numeric', [
                'attribute' => __('messages.validation.attributes.page'),
                'min' => 1
            ]),

            'sort.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.sort')]),
            'sort.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.sort')]),
            'sort.in' => __('messages.validation.in', ['attribute' => __('messages.validation.attributes.sort')]),

            'search.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.search')]),
            'search.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.search'),
                'max' => 255
            ]),

            'model.required' => __('messages.validation.required', ['attribute' => __('messages.validation.attributes.model')]),
            'model.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.model')]),

            'exportOption.array' => __('messages.validation.array', ['attribute' => __('messages.validation.attributes.exportOption')]),

            'exportOption.type.required_with' => __('messages.validation.required_with', [
                'attribute' => __('messages.validation.attributes.exportOption.type'),
                'values' => __('messages.validation.attributes.exportOption')
            ]),
            'exportOption.type.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.exportOption.type')]),
            'exportOption.type.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.exportOption.type'),
                'max' => 255
            ]),

            'exportOption.columns.required_with' => __('messages.validation.required_with', [
                'attribute' => __('messages.validation.attributes.exportOption.columns'),
                'values' => __('messages.validation.attributes.exportOption')
            ]),
            'exportOption.columns.array' => __('messages.validation.array', ['attribute' => __('messages.validation.attributes.exportOption.columns')]),

            'exportOption.fileName.required_with' => __('messages.validation.required_with', [
                'attribute' => __('messages.validation.attributes.exportOption.fileName'),
                'values' => __('messages.validation.attributes.exportOption')
            ]),
            'exportOption.fileName.string' => __('messages.validation.string', ['attribute' => __('messages.validation.attributes.exportOption.fileName')]),
            'exportOption.fileName.max' => __('messages.validation.max.string', [
                'attribute' => __('messages.validation.attributes.exportOption.fileName'),
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


    public function buildDto(): DatatableRequestDto
    {
        return DatatableRequestDto::buildFromArray(DataCleaner::cleanData($this->validated()));
    }
}
