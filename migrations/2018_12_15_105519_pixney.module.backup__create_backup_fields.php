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
        'name' => 'anomaly.field_type.text'
    ];
}
