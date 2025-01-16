<?php
    return [

    /*
    * The API key of a MailChimp account. You can find yours at
    * https://mailchimp.com/
    */
    'apiKey' => env('MAILCHIMP_APIKEY'),

    /*
    * Here you can define properties of the lists you want to manage.
    *
    * For each list you can define the following properties:
    * - id: The list id. You'll find this value in your MailChimp dashboard.
    */
    'lists' => [

        'subscribers' => [
            'id' => env('MAILCHIMP_LIST_ID'),
        ],

    ],

    ];
