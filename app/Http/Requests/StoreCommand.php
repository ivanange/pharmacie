<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Command;

class StoreCommand extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {

        if ($this->deliveryDate ?? false) {
            $this->merge([
                'deliveryDate' =>  date("Y-m-d H:i:s", strtotime($this->deliveryDate))
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:500',
            //'issueDate' => 'sometimes|nullable|date',
            'deliveryDate' => 'sometimes|nullable|date',
            'status' => 'sometimes|in:' . Command::ENCOURS . ',' . Command::LIVRER . ',' . Command::ANNULER, // use reflection
            'articles.*.qte' => 'integer'

        ];
    }
}
