<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class PixneyModuleBackupCreateBackupFields extends Migration
{
    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'cron' => 'anomaly.field_type.text',
        'type' => [
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'options'       => ['DB'=>'Database', 'FILES'=>'Files'],
                'mode'          => 'dropdown',
            ]
        ],
        'path'        => [
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'options'       => [
                    'public'      => 'public',
                    'storage'     => 'storage',
                    'resource'    => 'resource',
                    'database'    => 'database',
                    'config'      => 'config',
                    'base'        => 'base',
                    'app'         => 'app',
                ],
                'mode'          => 'dropdown',
            ]
        ],
        'storage'        => [
            'type'   => 'anomaly.field_type.select',
            'config' => [
                'options'       => [
                    's3'      => 'S3',
                ],
                'mode'          => 'dropdown',
                'default_value' => 's3'
            ]
        ],
    ];
}
