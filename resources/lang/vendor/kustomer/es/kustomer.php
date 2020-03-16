<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tooltip Message
    |--------------------------------------------------------------------------
    |
    | Text that appears in the tooltip when the cursor hover the bubble, before
    | the popup opens.
    |
    */

    'tooltip' => 'Danos feedback',

    /*
    |--------------------------------------------------------------------------
    | Popup Title
    |--------------------------------------------------------------------------
    |
    | This is the text that will appear below the logo in the feedback popup
    |
    */

    'title' => 'Ayudanos a mejorar',

    /*
    |--------------------------------------------------------------------------
    | Success Message
    |--------------------------------------------------------------------------
    |
    | This message will be displayed if the feedback message is correctly sent.
    |
    */

    'success' => 'Muchas gracias por tu comentario!',

    /*
    |--------------------------------------------------------------------------
    | Placeholder
    |--------------------------------------------------------------------------
    |
    | This text will appear as the placeholder of the textarea in which the
    | the user will type his feedback.
    |
    */

    'placeholder' => 'Escribe tu propuesta aquí...',

    /*
    |--------------------------------------------------------------------------
    | Button Label
    |--------------------------------------------------------------------------
    |
    | Text of the confirmation button to send the feedback.
    |
    */

    'button' => 'Enviar comentario',

    /*
    |--------------------------------------------------------------------------
    | Feedback Texts
    |--------------------------------------------------------------------------
    |
    | Must match the feedbacks array from the config file
    |
    */
    'feedbacks' => [
        'like' => [
            'title' => 'Me gusta algo',
            'label' => '¿Qué te gusta?',
        ],
        'dislike' => [
            'title' => 'Hay algo que no me gusta',
            'label' => '¿Qué no te gusta?',
        ],
        'suggestion' => [
            'title' => 'Tengo una sugerencia',
            'label' => '¿Cuál es tu sugerencia?',
        ],
        'bug' => [
            'title' => 'He encontrado un fallo',
            'label' => 'Por favor explicanos qué ha sucedido',
        ],
    ],
];
