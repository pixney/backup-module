<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PixneyModuleBackupCreateBackupsStream extends Migration
{
    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'          => 'backups',
        'title_column'  => 'name',
        'translatable'  => false,
        'versionable'   => false,
        'trashable'     => true,
        'searchable'    => true,
        'sortable'      => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'translatable' => false,
            'required'     => true,
        ],
        'cron' => [
            'translatable' => false,
            'required'     => true,
        ],
        'type' => [
            'translatable' => false,
            'required'     => true,
        ],
        'path' => [
            'translatable' => false,
            'required'     => false,
        ],
        'storage' => [
            'translatable' => false,
            'required'     => true,
        ]
    ];
}
