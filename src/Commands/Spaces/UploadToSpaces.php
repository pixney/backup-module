<?php 

namespace Pixney\BackupModule\Commands\Spaces;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pixney\BackupModule\Commands\CreateSpacesStoragePath;

/**
 * Class UploadToSpaces
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *
 *  @link https://pixney.com
 */
class UploadToSpaces
{
    use DispatchesJobs;
    /**
     * File to upload
     *
     * @var string
     */
    protected $tmpFile;
    protected $fileBaseName;
    /**
     * Path on spaces to store the backups
     *
     * @var [type]
     */
    protected $spacesStoragePath;

    public function __construct($tmpFile)
    {
        if (!file_exists($tmpFile)) {
            throw new \Exception('The file you would like to upload, does not exist');
        }
        $this->tmpFile           = $tmpFile;

        $this->fileBaseName      =str_replace('tmp_', '', pathinfo($this->tmpFile, PATHINFO_BASENAME));
        $this->spacesStoragePath =$this->dispatch(new CreateSpacesStoragePath($this->fileBaseName));
    }

    public function handle()
    {
        $client = S3Client::factory([
            'credentials' => [
                'key'    => env('S3_KEY'),
                'secret' => env('S3_SECRET'),
                'http'   => [
                    'connect_timeout' => 5
                ]
            ],
            'region'   => env('S3_REGION'), // Region you selected on time of space creation
            'endpoint' => env('S3_ENDPOINT'),
            'version'  => 'latest'
        ]);

        $adapter    = new AwsS3Adapter($client, env('S3_CLIENT'));
        $filesystem = new Filesystem($adapter);

        $stream = fopen($this->tmpFile, 'r+');

        $filesystem->writeStream($this->spacesStoragePath, $stream, ['visibility' => 'private']);

        if (is_resource($stream)) {
            // if (file_exists($this->tmpFile)) {
            //     Storage::disk('backup')->put("backups/{$this->fileBaseName}", $stream);
            // }
            fclose($stream);
        }

        if (file_exists($this->tmpFile)) {
            unlink($this->tmpFile);
        }
    }
}
