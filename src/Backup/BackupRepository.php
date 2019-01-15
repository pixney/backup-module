<?php

namespace Pixney\BackupModule\Backup;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Pixney\BackupModule\Backup\Contract\BackupRepositoryInterface;

class BackupRepository extends EntryRepository implements BackupRepositoryInterface
{
    use DispatchesJobs;
    /**
     * The entry model.
     *
     * @var BackupModel
     */
    protected $model;

    /**
     * Create a new BackupRepository instance.
     *
     * @param BackupModel $model
     */
    public function __construct(BackupModel $model)
    {
        $this->model = $model;
    }
}
