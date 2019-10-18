<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Líneas de Lenguaje de Validación
    |--------------------------------------------------------------------------
    |
    | Las líneas de lenguaje a continuación contienen los mensajes de error predeterminados 
    | usados por la clase de validación. Algunas de estas reglas poseen varias versiones
    | tales como las reglas de tamaño. Es libre de cambiar los mensajes.
    |
    */

    'accepted' => ':attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => ':attribute tiene que ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute tiene que ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute sólo puede contener letras.',
    'alpha_dash' => ':attribute sólo puede contener letras, numeros y guiones.',
    'alpha_num' => ':attribute sólo puede contener letras y números.',
    'array' => ':attribute debe ser un arreglo.',
    'before' => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute debe ser una fecha anterior o igual a:date.',
    'between' => [
        'numeric' => 'El valor de :attribute debe estar entre :min y :max.',
        'file' => 'El archivo :attribute debe tener entre :min y :max kilobytes.',
        'string' => ':attribute debe tener entre :min y :max caracteres.',
        'array' => 'El arreglo :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo :attribute debe ser falso o verdadero.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => ':attribute no es una fecha válida.',
    'date_equals' => ':attribute debe ser una fecha igual a :date.',
    'date_format' => 'La fecha en :attribute no coincide con el formato de :format.',
    'different' => 'Los campos :attribute y :other deben ser diferentes.',
    'digits' => 'El valor de :attribute deben ser :digits digitos.',
    'digits_between' => 'El valor de :attribute debe tener entre :min y :max digitos.',
    'dimensions' => 'La imagen en :attribute posee dimensiones no válidas.',
    'distinct' => 'El campo :attribute posee valor duplicado.',
    'email' => ':attribute tiene que ser una dirección de email válida.',
    'exists' => 'El :attribute seleccionado es inválido.',
    'file' => ':attribute tiene que ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor.',
    'gt' => [
        'numeric' => ':attribute debe ser mayor que :value.',
        'file' => 'El archivo :attribute debe ser mayor de :value kilobytes.',
        'string' => ':attribute debe tener más de :value caracteres.',
        'array' => ':attribute debe tener mas de :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute debe ser mayor o igual que :value.',
        'file' => 'El archivo en :attribute debe ser mayor o igual a :value kilobytes.',
        'string' => ':attribute debe ser mayor o igual a :value caracteres.',
        'array' => ':attribute debe tener :value o más elementos.',
    ],
    'image' => ':attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'The :attribute must be an integer.:attribute tiene que ser un entero.',
    'ip' => ':attribute tiene que ser una dirección IP válida.',
    'ipv4' => ':attribute tiene que ser una dirección IPv4 válida.',
    'ipv6' => ':attribute tiene que ser una dirección IPv6 válida.',
    'json' => ':attribute tiene que ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El valor de :attribute tiene que ser menor que :value.',
        'file' => ':attribute debe ser de menos de :value kilobytes.',
        'string' => ':attribute debe contener menos de :value caracteres.',
        'array' => ':attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'El valor de :attribute debe ser menor o igual que :value.',
        'file' => 'El archivo en :attribute debe ser de :value kilobytes o menos.',
        'string' => ':attribute debe tener :value caracteres o menos.',
        'array' => ':attribute no puede tener mas de :value elementos.',
    ],
    'max' => [
        'numeric' => 'El valor de :attribute no puede ser mayor que :max.',
        'file' => 'El archivo :attribute no puede ser más grande que :max kilobytes.',
        'string' => ':attribute no puede tener más de :max caracteres.',
        'array' => ':attribute no puede tener más que :max elementos.',
    ],
    'mimes' => 'El archivo :attribute debe ser de tipo :values.',
    'mimetypes' => ':attribute debe ser un archivo de tipo :values.',
    'min' => [
        'numeric' => ':attribute debe valer, al menos, :min.',
        'file' => 'El archivo :attribute debe tener al menos :min kilobytes.',
        'string' => ':attribute debe tener, al menos, :min caracteres.',
        'array' => ':attribute debe tener, al menos, :min caracteres.',
    ],
    'not_in' => 'El :attribute seleccionado no es válido.',
    'not_regex' => 'El formáto de :attribute no es válido.',
    'numeric' => ':attribute debe ser un número.',
    'present' => 'El campo :attribute debe ser presente.',
    'regex' => 'El formáto de :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio, a menos que :other esté entre :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando están presentes los valores :values.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ningún valor de :values está presente.',
    'same' => ':attribute y :other deben ser iguales.',
    'size' => [
        'numeric' => 'El valor de :attribute debe ser de :size en tamaño.',
        'file' => ':attribute debe ser de :size kilobytes.',
        'string' => ':attribute debe tener :size caracteres.',
        'array' => ':attribute debe contener :size elementos.',
    ],
    'starts_with' => ':attribute debe iniciar con uno de los siguientes: :values',
    'string' => ':attribute debe ser un string.',
    'timezone' => ':attribute debe ser una zona válida.',
    'unique' => ':attribute ya ha sido tomado.',
    'uploaded' => 'Falló al cargar :attribute.',
    'url' => 'El formato de :attribute no es válido.',
    'uuid' => ':attribute tiene que ser una UUID válida.',

    /*
    |--------------------------------------------------------------------------
    | Líneas de Lenguaje de Validación Personalizadas.
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
    | Atributos de Validación Personalizados
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
