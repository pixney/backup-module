<?php 

namespace Pixney\BackupModule\Commands\Backup;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Pixney\BackupModule\Commands\ResolvePath;

/**
 * Class CreateDbBackup
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class CreateBackup
{
    use DispatchesJobs;

    protected $backup;
    protected $type;

    public function __construct($backup)
    {
        $this->backup=$backup;
        $this->type  = $this->backup->type;
    }

    /**
     * Write database to a file
     *
     * @return string path of temporary file containing the database backup.
     */
    public function handle()
    {
        if (strtoupper($this->type) === 'FILES') {
            $path = $this->dispatch(new ResolvePath($this->backup->path));
            $this->dispatch(new CreateFilesBackup($path));
        } elseif (strtoupper($this->type) === 'DB') {
            $this->dispatch(new CreateDbBackup());
        }

        // Find out what type of backup
    }
}
