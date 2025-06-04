<?php

return [
    'attributes' => [
        'current_password' => 'contraseña actual',
        'new_password' => 'nueva contraseña',
        'new_password_confirmation' => 'confirmación de contraseña',
    ],
    'custom' => [
        'new_password' => [
            'mixed' => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
            'numbers' => 'La contraseña debe contener al menos un número.',
            'symbols' => 'La contraseña debe contener al menos un símbolo especial.',
        ],
    ],
]; 