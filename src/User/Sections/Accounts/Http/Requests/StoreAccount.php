<?php

namespace AwemaPL\AllegroClient\User\Sections\Accounts\Http\Requests;

use AwemaPL\AllegroClient\Sections\Options\Models\Option;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccount extends FormRequest
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
            'own_application' => 'required|boolean',
            'application_id' => 'required_unless:own_application,0|integer',
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
            'application_id' => _p('allegro-client::requests.user.account.attributes.application', 'application'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'application_id.required_unless' =>  _p('allegro-client::requests.user.account.messages.application_required', 'Select application'),
        ];
    }
}
