<?php

namespace App\Http\Requests;

use App\Models\Inventory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreInventoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('inventory_create');
    }

    public function rules()
    {
        return [
            'vehicle' => [
                'string',
                'required',
            ],
            'engine_type' => [
                'string',
                'required',
            ],
            'transmission' => [
                'string',
                'required',
            ],
            'interior_color' => [
                'string',
                'nullable',
            ],
            'exterior_color' => [
                'string',
                'nullable',
            ],
            'pictures' => [
                'array',
                'required',
            ],
            'pictures.*' => [
                'required',
            ],
        ];
    }
}
