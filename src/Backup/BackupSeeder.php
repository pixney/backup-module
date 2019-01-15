<?php

namespace Pixney\BackupModule\Backup;

use League\Flysystem\MountManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\FilesModule\Disk\Command\LoadDisks;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Anomaly\FilesModule\Disk\Contract\DiskRepositoryInterface;
use Anomaly\FilesModule\Folder\Contract\FolderRepositoryInterface;
use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;

class BackupSeeder extends Seeder
{
    use DispatchesJobs;

    protected $disks;
    protected $folders;
    protected $manager;
    protected $configuration;

    public function __construct(
        DiskRepositoryInterface $disks,
        FolderRepositoryInterface $folders,
        MountManager $manager,
        ConfigurationRepositoryInterface $configuration
    ) {
        $this->disks         = $disks;
        $this->folders       = $folders;
        $this->manager       = $manager;
        $this->configuration = $configuration;
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        try {
            $existFolder =  $this->folders->findBySlug('backups');
            if (!is_null($existFolder)) {
                Storage::disk('backup')->deleteDirectory('backups');
                $existFolder->forceDelete();
            }

            $exist       =  $this->disks->findBySlug('backup');
            if (!is_null($exist)) {
                //     // }

                $exist->forceDelete();
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        // dd($existFolder);

        $disk = $this->disks->create([
            'en' => [
                'name'        => 'Backup',
                'description' => 'Disk used for backups',
            ],
            'slug'    => 'backup',
            'adapter' => 'anomaly.extension.local_storage_adapter',
        ]);

        $this->configuration->findByKeyAndScopeOrNew('anomaly.extension.local_storage_adapter::private', $disk->getSlug())->setValue(1)->save();

        $this->dispatch(new LoadDisks());

        $this->folders->create(
            [
                'en' => [
                    'name'        => 'Backups',
                    'description' => 'A folder for database backups.',
                ],
                'slug'          => 'backups',
                'disk'          => $disk,
                'allowed_types' => [
                    'sql',
                    'zip',
                ],
            ]
        );
    }
}
