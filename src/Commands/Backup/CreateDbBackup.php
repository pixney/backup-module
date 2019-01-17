<?php 

namespace Pixney\BackupModule\Commands\Backup;

use Ifsnop\Mysqldump as IMysqldump;
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
class CreateDbBackup
{
    use DispatchesJobs;
    /**
     * Where to store the database backup
     *
     * @var string
     */
    protected $path;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $host;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $dbName;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $dbUsername;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $dbPassword;

    public function __construct($tmpFilePath=null)
    {
        Log::info('Creating a db backup');

        $this->path       = $tmpFilePath;
        $this->host       = env('DB_HOST');
        $this->dbName     = env('DB_DATABASE');
        $this->dbUsername = env('DB_USERNAME');
        $this->dbPassword = env('DB_PASSWORD');
    }

    /**
     * Write database to a file
     *
     * @return string path of temporary file containing the database backup.
     */
    public function handle()
    {
        try {
            $dump = new IMysqldump\Mysqldump("mysql:host={$this->host};dbname={$this->dbName}", $this->dbUsername, $this->dbPassword);

            $dump->start($this->path);
        } catch (\Exception $e) {
            Log::error('mysqldump-php error: ' . $e->getMessage());
            echo 'mysqldump-php error: ' . $e->getMessage();
        }

        try {
            $this->dispatch(new UploadToSpaces($this->path));
        } catch (\Throwable $th) {
            Log::error('Upload to spaces error: ' . $e->getMessage());
            echo 'Upload to spaces error: ' . $th->getMessage();
        }
    }
}
