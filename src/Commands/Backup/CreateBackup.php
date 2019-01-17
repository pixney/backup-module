<?php 

namespace Pixney\BackupModule\Commands\Backup;

use Pixney\BackupModule\Backup\BackupModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pixney\BackupModule\Commands\ResolvePathToBackup;

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
    protected $pathToBackup;
    protected $type;

    public function __construct(BackupModel $backup)
    {
        $this->backup = $backup;

        if (!isset($this->backup->type) || empty($this->backup->type)) {
            throw new \Exception('Backup type not specified');
        }

        if (!in_array($this->backup->type, ['DB', 'FILES'])) {
            throw new \Exception('Backup type not specified');
        }
        if ($this->backup->type === 'FILES' && (!isset($this->backup->path) || empty($this->backup->path))) {
            throw new \Exception('Path to backup not specified');
        }

        $this->pathToBackup = $this->backup->path;
        $this->type         = $this->backup->type;
    }

    /**
     * Write database to a file
     *
     * @return string path of temporary file containing the database backup.
     */
    public function handle()
    {
        $tmpFilePath        = $this->dispatch(new CreateTmpPath($this->type, $this->backup->name));

        if (strtoupper($this->type) === 'FILES') {
            $pathToBackup = $this->dispatch(new ResolvePathToBackup($this->pathToBackup));
            $this->dispatch(new CreateFilesBackup($tmpFilePath, $pathToBackup));
        } elseif (strtoupper($this->type) === 'DB') {
            $this->dispatch(new CreateDbBackup($tmpFilePath));
        }
    }
}
