<?php 

namespace Pixney\BackupModule\Commands\Backup;

use Illuminate\Support\Facades\Log;
use Pixney\BackupModule\Commands\CreatePath;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pixney\BackupModule\Commands\Spaces\UploadToSpaces;

/**
 * Class CreateDbBackup
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class CreateFilesBackup
{
    use DispatchesJobs;
    /**
     * Where to store the database backup
     *
     * @var string
     */
    protected $path;
    protected $time;
    protected $filename;
    protected $tmppath;
    /**
     * Path to backup
     *
     * @var string
     */
    protected $backupDirectory;

    public function __construct($backupDirectory=null)
    {
        Log::info('Creating a files backup');

        if ($backupDirectory === null) {
            throw new \Exception('Missing directory to backup');
        }
        if (!file_exists($backupDirectory)) {
            throw new \Exception("Directory doesnt exist ({$backupDirectory})");
        }

        $this->path            = $this->dispatch(new CreatePath('FILES'));
        $this->backupDirectory = $backupDirectory;
    }

    public function handle()
    {
        try {
            //exec('tar -zcvf ' . $this->tmppath . ' ' . $this->backupDirectory);
            exec('tar -zcf ' . $this->path . ' ' . $this->backupDirectory);
            $this->dispatch(new UploadToSpaces($this->path));
        } catch (\Throwable $th) {
            Log::error('Upload to spaces error: ' . $e->getMessage());
            echo 'Upload to spaces error: ' . $th->getMessage();
        }
    }
}
