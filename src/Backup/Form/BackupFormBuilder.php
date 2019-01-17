<?php

namespace Pixney\BackupModule\Backup\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class BackupFormBuilder extends FormBuilder
{
    /**
     * The form fields.
     *
     * @var array|string
     */
    protected $fields = [
        '*',
        'name' => [
            'label'        => 'Name',
            'instructions' => 'Currently only used for your referene in the table',
        ],
        'cron' => [
            'label'        => 'Cron expression',
            'instructions' => 'Example: * * * * *',
        ],
        'type' => [
            'label'        => 'Type of backup',
            'instructions' => 'Do you want to backup the database or a file path?',
        ],
        'path' => [
            'label'       => 'Select path to backup',
            'instructions'=> 'Only used if you have selected files backup above',
            'rules'       => ['required_if:type,FILES']
        ],
        'storage' => [
            'label' => 'Select storage',
        ]
    ];

    /**
     * Additional validation rules.
     *
     * @var array|string
     */
    protected $rules = [
     //   'path' => ['required_if:type,FILES']
    ];

    /**
     * Fields to skip.
     *
     * @var array|string
     */
    protected $skips = [];

    /**
     * The form actions.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The form buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'cancel',
    ];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [];
}
