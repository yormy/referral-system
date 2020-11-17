<?php

return [
    'cookie_lifetime_in_minutes' => 60*24*7,
    'cookie_name' => 'referral_cookie',

    'datetime_format' => 'Y-m-d H:i:s',

    'models' => [

        /*
         * When using the "Referrable" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your user.
         */

        'referring_user_model' => App\User::class,

        /*
         * The to reference the referrer we need a column name in the users model to reference.
         * This is is publishable, so this should *NOT* be the primary auto increment
         */
        'referrable_ip' => 'id'
    ],

];
