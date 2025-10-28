<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVenueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //VALIDACIONES DE ROLES Y PERMISOS DE USUARIOS
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'venue_name' => ['required', 'string', 'max:255'],
            //SI EL VALOR SE ENVIA POR PETICION SE REVISA SU TIPO Y COMO MINIMO 1
            'venue_max_capacity' => ['integer', 'min:1'],
            'venue_address' => ['string', 'max:255'],
            'venue_status' => ['string', 'max:20'],
        ];
    }
}
