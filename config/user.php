<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Activation Mode
    |--------------------------------------------------------------------------
    |
    | - 'auto': сразу активирует пользователя
    | - 'manual': требует подтверждение по email
    | - 'none': не требует активации вообще
    |
    */

    'activate_mode' => 'auto',

    /*
    |--------------------------------------------------------------------------
    | Allow user registration
    |--------------------------------------------------------------------------
    |
    | If this is disabled users can only be created by administrators.
    |
    */

    'allow_registration' => true,

    /*
    |--------------------------------------------------------------------------
    | Login attribute
    |--------------------------------------------------------------------------
    |
    | Select what primary user detail should be used for signing in.
    |
    | email       Authenticate users by email.
    | username    Authenticate users by username.
    |
    */

    'login_attribute' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Password Policy
    |--------------------------------------------------------------------------
    |
    | Specify the password policy for backend administrators.
    |
    | min_length            - Password minimum length between 4 - 128 chars
    | require_mixed_case    - Require at least one uppercase and lowercase letter
    | require_uncompromised - Require a password not found in a leaked password database
    | require_number        - Require at least one number
    | require_symbol        - Require at least one non-alphanumeric character
    |
    */

    'password_policy' => [
        'min_length' => 8,
        'require_mixed_case' => false,
        'require_uncompromised' => false,
        'require_number' => true,
        'require_symbol' => false,
    ],


    // Остальные опции можешь скопировать при необходимости
];
