<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class UpdateZoneInputValidator extends Validator
{
  /**
   * @return mixed[]
   */
  public function rules(): array
  {
    return [
      'name' => [
        'sometimes', 
        Rule::unique('zones', 'name')
          ->ignore($this->arg('id'), 'id')
          ->where('city_id', $this->arg('city_id'))
          ->where('type', $this->arg('type'))
      ],
    ];
  }

  /**
   * @return string[]
   */
  public function messages(): array
  {
    return [
      'name.unique' => __('lang.NotAvailableName'),
    ];
  }

}