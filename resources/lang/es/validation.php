<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL valida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser posterior o igual a :date.',
    'alpha' => 'El campo :attribute solo puede contener letras.',
    'alpha_dash' => 'El campo :attribute solo puede contener letras, numeros, guiones o guiones bajos.',
    'alpha_num' => 'El campo :attribute solo puede contener letras o numeros.',
    'array' => 'El campo :attribute debe ser un array.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El campo :attribute debe ser entre :min y :max.',
        'file' => 'El campo :attribute debe pesar entre :min y :max kilobytes.',
        'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
        'array' => 'El campo :attribute debe tener entre :min y :max items.',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'El campo :attribute no coincide con el campo de confirmacion.',
    'date' => 'El campo :attribute no es una fecha valida.',
    'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El campo :attribute debe ser de la forma: :format.',
    'different' => 'El campo :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe tener :digits digitos.',
    'digits_between' => 'El campo :attribute debe tener entre :min y :max digitos.',
    'dimensions' => 'El campo :attribute es una imagen con dimensiones no validas.',
    'distinct' => 'El campo :attribute ya existe en la base de datos.',
    'email' => 'El campo :attribute debe ser una direccion de email valida.',
    'ends_with' => 'El campo :attribute debe terminar con alguno de los siguientes valores: :values.',
    'exists' => 'El campo :attribute ya existe en la base de datos.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener algun valor.',
    'gt' => [
        'numeric' => 'El campo :attribute debe ser mayor de :value.',
        'file' => 'El campo :attribute debe pesar mas de :value kilobytes.',
        'string' => 'El campo :attribute debe contener mas de :value caracteres.',
        'array' => 'El campo :attribute debe contener mas de :value items.',
    ],
    'gte' => [
        'numeric' => 'El campo :attribute debe ser mayor o igual de :value.',
        'file' => 'El campo :attribute debe pesar mas o lo mismo que :value kilobytes.',
        'string' => 'El campo :attribute debe contener :value o mas caracteres.',
        'array' => 'El campo :attribute debe contener :value o mas item.',
    ],
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo :attribute es invalido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El campo :attribute debe ser un integer.',
    'ip' => 'El campo :attribute debe ser IP valida.',
    'ipv4' => 'El campo :attribute deber ser una direccion IPv4 valida.',
    'ipv6' => 'El campo :attribute deber ser una direccion IPv6 valida.',
    'json' => 'El campo :attribute deber ser una cadena JSON valida.',
    'lt' => [
        'numeric' => 'El campo :attribute debe ser menor que :value.',
        'file' => 'El campo :attribute debe pesar menos que :value kilobytes.',
        'string' => 'El campo :attribute debe tener menos de :value caracteres.',
        'array' => 'El campo :attribute debe tener menos de :value items.',
    ],
    'lte' => [
        'numeric' => 'El campo :attribute deber ser menor o igual que :value.',
        'file' => 'El campo :attribute debe pesar :value kilobytes o menos.',
        'string' => 'El campo :attribute debe contener :value caracteres o menos.',
        'array' => 'El campo :attribute debe contener :value items o menos.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no puede ser mayor que :max.',
        'file' => 'El campo :attribute no puede pesar mas que :max kilobytes.',
        'string' => 'El campo :attribute no debe contener mas de :max caracteres.',
        'array' => 'El campo :attribute no debe contener mas de :max items.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser mayor que :min.',
        'file' => 'El campo :attribute debe pesar al menos :min kilobytes.',
        'string' => 'El campo :attribute debe contener al menos :min caracteres.',
        'array' => 'El campo :attribute debe contener al menos :min items.',
    ],
    'not_in' => 'El campo :attribute es invalido.',
    'not_regex' => 'El formato del campo :attribute es invalido.',
    'numeric' => 'El campo :attribute debe ser un numero.',
    'password' => 'El campo password es incorrecto.',
    'present' => 'El campo :attribute debe estar presente.',
    'regex' => 'El formato del campo :attribute es invalido.',
    'required' => 'El campo :attribute es requerido.',
    'required_if' => 'El campo :attribute es requerido cuando :other es :value.',
    'required_unless' => 'El campo :attribute es requerido unless :other esta en :values.',
    'required_with' => 'El campo :attribute es requerido cuando :values esta presente.',
    'required_with_all' => 'El campo :attribute es requerido cuando :values estan presentes.',
    'required_without' => 'El campo :attribute es requerido cuando :values no esta presente.',
    'required_without_all' => 'El campo :attribute es requerido cuando ninguno de :values estan presentes.',
    'same' => 'El campo :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El campo :attribute debe ser de :size.',
        'file' => 'El campo :attribute debe ser de :size kilobytes.',
        'string' => 'El campo :attribute debe ser de :size caracteres.',
        'array' => 'El campo :attribute debe contener :size items.',
    ],
    'starts_with' => 'El campo :attribute debe comenzar con alguno de los siguientes valores: :values.',
    'string' => 'El campo :attribute debe ser una cadena.',
    'timezone' => 'El campo :attribute debe ser una zona valida.',
    'unique' => 'El campo :attribute ya esta tomado.',
    'uploaded' => 'El campo :attribute fallo al ser subido.',
    'url' => 'El  formato del campo :attribute es invalido.',
    'uuid' => 'El campo :attribute debe ser un UUID valido.',
    'current_password' => 'La contraseña actual no coincide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];