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

    'accepted' => '꼭 받아들여야 합니다.',
    'active_url' => '유효한 URL이 아닙니다.',
    'after' => '다음 날짜 이후의 날짜여야 합니다. :date',
    'after_or_equal' => '다음 날짜 이후 또는 다음 날짜여야 합니다. :date',
    'alpha' => '문자 만 포함 할 수 있습니다.',
    'alpha_dash' => '문자, 숫자, 띄어쓰기 및 밑줄 만 포함 할 수 있습니다.',
    'alpha_num' => '문자와 숫자 만 포함 할 수 있습니다.',
    'array' => '배열이어야 합니다.',
    'before' => '다음 날짜 이전의 날짜여야 합니다. :date',
    'before_or_equal' => '다음 날짜 이전 또는 다음 날짜여야 합니다. :date',
    'between' => [
        'numeric' => '최소값과 최대값 사이여야 합니다. :min - :max',
        'file' => '최소 - 최대 킬로바이트 사이여야 합니다. :min - :max kilobytes',
        'string' => '최소 문자에서 최대 문자 사이여야 합니다. :min - :max',
        'array' => '최소 항목과 최대 항목 사이에 있어야 합니다. :min - :max',
    ],
    'boolean' => '필드는 참 또는 거짓이어야 합니다.',
    'confirmed' => '확인이 일치하지 않습니다.',
    'date' => '유효한 날짜가 아닙니다.',
    'date_equals' => '날짜는 다음 날짜여야 합니다. :date',
    'date_format' => '포맷 형식과 일치하지 않습니다. :format',
    'different' => '다른 것과 달라야 합니다. :other',
    'digits' => '숫자여야 합니다 :digits',
    'digits_between' => '최소 및 최대 숫자 사이여야 합니다. :min - :max',
    'dimensions' => '이미지 크기가 잘못되었습니다.',
    'distinct' => '필드에 중복된 값이 있습니다.',
    'email' => '올바른 이메일 주소여야 합니다.',
    'ends_with' => '다음 값 중 하나로 끝나야 합니다. :values',
    'exists' => '선택한 특성이 잘못되었습니다.',
    'file' => '파일이어야 합니다.',
    'filled' => '필드에는 값이 있어야 합니다.',
    'gt' => [
        'numeric' => '값보다 커야 합니다. :value',
        'file' => '값 킬로바이트보다 커야 합니다 :value kilobytes',
        'string' => '값 문자보다 커야 합니다. :value',
        'array' => '값 항목을 초과해야 합니다. :value',
    ],
    'gte' => [
        'numeric' => '값 이상이어야 합니다. :value',
        'file' => '킬로바이트 이상이어야 합니다. :value',
        'string' => '값 문자 이상이어야 합니다. :value',
        'array' => '값 항목 이상이 있어야 합니다. :value',
    ],
    'image' => '이미지여야 합니다.',
    'in' => '유효하지 않습니다.',
    'in_array' => '필드가 다른 필드에 없습니다. :other',
    'integer' => '정수여야 합니다.',
    'ip' => '올바른 IP 주소여야 합니다.',
    'ipv4' => '올바른 IPv4 주소여야 합니다.',
    'ipv6' => '올바른 IPv6 주소여야 합니다.',
    'json' => '올바른 JSON 문자열이어야 합니다.',
    'lt' => [
        'numeric' => '값보다 작아야 합니다. :value',
        'file' => '값 킬로바이트보다 작아야 합니다. :value',
        'string' => '값 문자보다 작아야 합니다. :value',
        'array' => '값 항목보다 작아야 합니다. :value',
    ],
    'lte' => [
        'numeric' => '값 이하여야 합니다. :value',
        'file' => '킬로바이트 이하여야 합니다. :value',
        'string' => '값 문자 이하여야 합니다. :value',
        'array' => '값 항목을 초과해서는 안 됩니다. :value',
    ],
    'max' => [
        'numeric' => '최대값보다 클 수 없습니다. :max',
        'file' => '최대 킬로바이트보다 클 수 없습니다. :max',
        'string' => '최대 문자보다 클 수 없습니다. :max',
        'array' => '최대 항목을 초과할 수 없습니다. :max',
    ],
    'mimes' => '형식 값의 파일이어야 합니다. :values',
    'mimetypes' => '형식 값의 파일이어야 합니다. :values',
    'min' => [
        'numeric' => '최소값이어야 합니다 :min',
        'file' => '최소 킬로바이트여야 합니다. :min',
        'string' => '최소 문자여야 합니다. :min',
        'array' => '최소 항목이어야 합니다. :min',
    ],
    'not_in' => '유효하지 않습니다.',
    'not_regex' => '형식이 잘못되었습니다.',
    'numeric' => '숫자여야 합니다.',
    'password' => '비밀번호가 맞지 않습니다.',
    'present' => '필드가 있어야 합니다.',
    'regex' => '형식이 잘못되었습니다.',
    'required' => '필드가 요구됩니다.',
    'required_if' => '값이 다른 필드인 경우 필드가 요구됩니다.',
    'required_unless' => '값이 다른 필드가 아닌 경우 필드가 요구됩니다.',
    'required_with' => '값이 있는 경우 필드가 요구됩니다. :values',
    'required_with_all' => '값이 있는 경우 필드가 요구됩니다. :values',
    'required_without' => '값이 없는 경우 필드가 요구됩니다. :values',
    'required_without_all' => '값이 없는 경우 필드가 요구됩니다. :values',
    'same' => '다른 것과 일치해야 합니다.',
    'size' => [
        'numeric' => '사이즈여야 합니다. :size',
        'file' => '사이즈 킬로바이트여야 합니다. :size',
        'string' => '사이즈 문자여야 합니다. :size',
        'array' => '사이즈 항목이어야 합니다. :size',
    ],
    'starts_with' => '다음 값 중 하나로 시작해야 합니다. :values',
    'string' => '문자열이어야 합니다.',
    'timezone' => '유효한 영역이어야 합니다.',
    'unique' => '이미 선택되었습니다.',
    'uploaded' => '업로드하지 못했습니다.',
    'url' => '유효한 형식이 아닙니다.',
    'uuid' => '올바른 UUID여야 합니다.',

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
