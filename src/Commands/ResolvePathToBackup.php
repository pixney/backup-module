<?php 

namespace Pixney\BackupModule\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreateDbBackup
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class ResolvePathToBackup
{
    use DispatchesJobs;

    protected $path;

    public function __construct($path = null)
    {
        $this->path = $path;
    }

    /**
     * Create filename and path
     *
     * @return string path and filename of temporary file
     */
    public function handle()
    {
        switch ($this->path) {
            case 'public':
                return public_path();
                break;
            case 'storage':
                return storage_path();
                break;
            case 'resource':
                return resource_path();
                break;
            case 'database':
                return database_path();
                break;
            case 'config':
                return config_path();
                break;
            case 'base':
                return base_path();
                break;
            case 'app':
                return app_path();
                break;

            default:
                throw new \Exception('Backup path not correctly specified');
                break;
        }
    }
}
