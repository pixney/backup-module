<?php

namespace Pixney\BackupModule\Backup\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface BackupRepositoryInterface extends EntryRepositoryInterface
{
    public function getAll();
}
