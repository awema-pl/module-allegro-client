<?php

namespace AwemaPL\AllegroClient\Admin\Sections\Settings\Http\Requests;

use AwemaPL\AllegroClient\Sections\Options\Models\Option;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSetting extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:65535',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'key' => _p('allegro-client::requests.admin.setting.attributes.key', 'Key'),
            'value' => _p('allegro-client::requests.admin.setting.attributes.value', 'Value'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
