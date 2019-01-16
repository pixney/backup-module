<?php 

namespace Pixney\BackupModule\Commands\Backup;

use File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreateDbBackup
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class CreatePath
{
    use DispatchesJobs;

    /**
     * Backup type
     *
     * Options:
     *  DB
     *  FILES
     * @var string
     */
    protected $type;
    /**
     * Date to put into filename
     *
     * @var string
     */
    protected $time;

    /**
     * File extension
     * sql or tar.gz
     * @var [type]
     */
    protected $extension;

    public function __construct($type=null)
    {
        Log::info('Creating Path');

        if ($type === null) {
            Log::error('Type of backup not specified');
            throw new \Exception('Type of backup not specified');
        }
        $this->type  = strtolower($type);
        $this->time  = strftime('%G-%m-%d-%H%M%S');

        if ($this->type === 'db') {
            $this->extension='.sql';
        } elseif ($this->type === 'files') {
            $this->extension='.tar.gz';
        }
    }

    /**
     * Create filename and path
     *
     * @return string path and filename of temporary file
     */
    public function handle()
    {
        // $a = Storage::getAdapter()->getPathPrefix();
        // dd(storage_path('tempdir'));
        // echo $a;
        // dd('hmm');

        $tmpBackupStoragePath          = storage_path('backup-module');
        if (!File::exists($tmpBackupStoragePath)) {
            File::makeDirectory($tmpBackupStoragePath, 0775, true, true);
        }

        $appName    = env('APPLICATION_NAME', 'nan');
        $appEnv     = env('APP_ENV', 'nan');

        // TODO: Allow specifying a path string in the .env file
        $path       = "{$tmpBackupStoragePath}/tmp_{$appName}_{$appEnv}_{$this->type}_{$this->time}{$this->extension}";

        return $path;
    }
}
