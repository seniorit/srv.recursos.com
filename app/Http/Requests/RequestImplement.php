<?php

namespace App\Http\Requests;

use App\Http\HttpHandler\StatusHttp;
use App\Http\HttpHandler\ResponseHttp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class RequestImplement extends FormRequest
{
  protected $stopOnFirstFailure = true;

  public function messages()
  {
    return [
      'required' => 'El Campo :attribute es Requerido',
      'required_with' => 'El Campo :attribute es Requerido',
      'required_unless' => 'El Campo :attribute es Requerido',
      'max' => 'El Campo :attribute Excede la Cantidad de Caracteres permitidos: :max',
      'boolean' => 'El Valor de entrada del Campo :attribute es Invalido',
      'regex' => 'El Valor de entrada Invalido.',
      'in' => 'El Valor de entrada Invalido. Los Valores Permitidos son: :values',
      'enum' => 'El Valor de entrada Invalido. Los Valores Permitidos son: :values',
      'numeric' => 'El Valor de entrada del Campo :attribute es Invalido',
      'string' => 'El Valor del Campo :attribute es Invalido',
      'date_format' => 'El Valor del Campo :attribute es Invalido',
      'exists' => 'El Valor de Relacion :attribute es Invalido',
      'date' => 'Debe indicar un Parametro de Fecha Valido',
      'file' => 'El Valor Esperado debe ser un archivo',
      'mimes' => 'El Formato de Archivo es Invalido',
      'password.min' => 'La Clave de acceso debe terner al menos 6 Caracteres',
      'phone1.unique' => 'El Numero de Telefono Indicado :attribute ya se encuentra Registrado',
      'email.unique' => 'El Email Indicado :attribute  ya se encuentra Registrado',
      'unique' => 'El Valor Indicado :attribute ya se encuentra Registrado',
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    $errors = (new ValidationException($validator))->errors();
    $errResponse = collect($errors);

    throw new HttpResponseException(
      ResponseHttp::statusError(
        statusCode: StatusHttp::HTTP_BAD_REQUEST,
        msg: 'Parametros Invalidos! <br> ' . $errResponse->flatten()->first(),
        error: $errors,
      )
    );
  }
}
