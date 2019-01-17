<?php 

namespace Pixney\BackupModule\Commands\Backup;

use Illuminate\Support\Facades\Log;
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

    public function __construct($tmpFilePath=null, $pathToBackup=null)
    {
        if ($pathToBackup === null || $tmpFilePath === null) {
            throw new \Exception('Missing path to backup or temp file path');
        }
        if (!file_exists($pathToBackup)) {
            throw new \Exception("Directory doesnt exist ({$pathToBackup})");
        }

        $this->path            = $tmpFilePath;
        $this->backupDirectory = $pathToBackup;
    }

    public function handle()
    {
        try {
            //exec('tar -zcvf ' . $this->tmppath . ' ' . $this->backupDirectory);
            exec('tar -zcf ' . $this->path . ' ' . $this->backupDirectory);
            $this->dispatch(new UploadToSpaces($this->path));
        } catch (\Throwable $th) {
            Log::error('Upload to spaces error: ' . $e->getMessage());
            throw $th;
        }
    }
}
