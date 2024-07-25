<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CodeGenerator config overrides
    |--------------------------------------------------------------------------
    |
    | It is a good idea to separate your configuration form the code-generator's
    | own configuration. This way you won't lose any settings/preference
    | you have when upgrading to a new version of the package.
    |
    | Additionally, you will always know any the configuration difference between
    | the default config than your own.
    |
    | To override the setting that is found in the 'config/default.php' file, you'll
    | need to create identical key here with a different value
    |
    | IMPORTANT: When overriding an option that is an array, the configurations
    | are merged together using php's array_merge() function. This means that
    | any option that you list here will take presence during a conflict in keys.
    |
    | EXAMPLE: The following addition to this file, will add another entry in
    | the common_definitions collection
    |
    |   'common_definitions' =>
    |   [
    |       [
    |           'match' => '*_at',
    |           'set' => [
    |               'css-class' => 'datetime-picker',
    |           ],
    |       ],
    |   ],
    |
     */

    /*
    |--------------------------------------------------------------------------
    | The default path of where the uploaded files live.
    |--------------------------------------------------------------------------
    |
    | You can use Laravel Storage filesystem. By default, the code-generator
    | uses the default file system.
    | For more info about Laravel's file system visit
    | https://laravel.com/docs/5.5/filesystem
    |
     */

    'common_definitions' =>
    [
        [
            'match' => '*_at',
            'set' => [
                'css-class' => 'datetime-picker',
                'date-format' => 'j/n/Y G:i A',
            ],
        ],

        [
            'match' => ['*_date', 'date_*'],
            'set' => [
                'css-class' => 'datetime-picker',
                'data-type' => 'datetime',
                'date-format' => 'j/n/Y G:i A',
            ],
        ],

        [
            'match' => ['address', '*_address', '*address', 'address*', '*address*'],
            'set' => [
                'is-on-index' => false,
                'html-type' => 'textarea',
                'data-type' => 'text',
                'data-type-params' => [1000],
            ],
        ],


        [
            'match' => ['color', '*_color', 'color_*', '*color', 'color*', '*color*'],
            'set' => [
                'is-on-index' => false,
                'html-type' => 'color',
                'data-type' => 'text',
            ],
        ],


    ],



  /*
    |--------------------------------------------------------------------------
    | Should the code generator organize the new migrations?
    |--------------------------------------------------------------------------
    |
    | This option will allow the code generator to group the migration related
    | to the same table is a separate folder. The folder name will be the name
    | of the table.
    |
    | It is recommended to set this value to true, then use crest apps command
    | to migrate instead of the build in command.
    |
    | php artisan migrate-all
    | php artisan migrate:rollback-all
    | php artisan migrate:reset-all
    | php artisan migrate:refresh-all
    | php artisan migrate:status-all
    |
     */
    'organize_migrations' => true,




    'datetime_out_format' => 'j/n/Y G:i A',


    'files_upload_path' => 'uploads',



  /*
    |--------------------------------------------------------------------------
    | The default template to use.
    |--------------------------------------------------------------------------
    |
    | Here you change the stub templates to use when generating code.
    | You can duplicate the 'default' template folder and call it whatever
    | template name you like 'ex. skyblue'. Now, you can change the stubs to
    | have your own templates generated.
    |
    |
    | IMPORTANT: It is not recommended to modify the default template, rather
    | create a new template. If you modify the default template and then
    | executed 'php artisan vendor:publish' command, will override your changes!
    |
     */
    'template' => 'soft-ui',









];
