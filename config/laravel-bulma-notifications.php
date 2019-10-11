<?php

return [

    /**
     * Bulma column size classes
     * https://bulma.io/documentation/columns/sizes
     * is-full is-full-mobile is-full-tablet, or other bulma classes
     */

    'notification_container' => 'is-one-third is-full-touch is-one-quarter-widescreen',


    /**
     * Cookie related classes
     */
    'cookie' => [

        //Enable/Disable cookie box on the application
        'enabled' => true,

        // In case of translations just add translatable string
        'body' => 'Using cookies enables us to optimally design and continually improve our website. If you continue using the website, you automatically give your consent to receive cookies from it.',

        // In case of translations just add translatable string
        'button' => 'Okay',

        // Options[is-success, is-warning, is-danger, is-primary, is-dark, is-white, ..]
        'background-class' => 'is-dark',

        // Options[is-success, is-warning, is-danger, is-primary, is-dark, is-white, ..]
        'button-class' => 'is-white',
    ]
];
