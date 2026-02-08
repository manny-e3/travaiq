<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change to 'false' if you want to restrict access
    }

    public function rules()
    {
        return [
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric',
            'property_desc'     => 'nullable|string',
            'property_type'     => 'required|string',
            'property_cat'      => 'required|string',
            'property_bed'      => 'required|integer|min:0',
            'property_location' => 'required|string',
            'property_picture'  => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }
}
