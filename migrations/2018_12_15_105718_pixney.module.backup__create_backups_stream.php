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
         'title_column' => 'name',
         'translatable' => true,
         'versionable'  => false,
         'trashable'    => true,
         'searchable'   => true,
         'sortable'     => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'translatable' => true,
            'required'     => true,
        ]
    ];
}
