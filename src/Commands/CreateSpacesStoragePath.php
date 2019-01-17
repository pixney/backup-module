<?php 

namespace Pixney\BackupModule\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreateSpacesStoragePath
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class CreateSpacesStoragePath
{
    use DispatchesJobs;

    protected $fileName;
    protected $rootDir;
    protected $appName;
    protected $date;
    protected $month;
    protected $year;
    protected $day;

    public function __construct($fileName)
    {
        $this->fileName=$fileName;
        $this->rootDir = 'web_backups';
        $this->appName = env('APPLICATION_NAME');
        $this->date    = strftime('%G_%b_%d');

        $this->month    = strftime('%b');
        $this->year     = strftime('%G');
        $this->day      = strftime('%d');
    }

    /**
     * Create filename and path
     *
     * @return string path and filename of temporary file
     */
    public function handle()
    {
        //echo sprintf($format, $num, $location);
        //dd($test);
        // backups/year_month_day/appname/filename
        return "{$this->rootDir}/{$this->appName}/{$this->year}/{$this->month}/{$this->day}/{$this->fileName}";

        // backups/pixney/filename
       // return "{$this->rootDir}/{$this->appName}/{$this->fileName}";
    }
}
