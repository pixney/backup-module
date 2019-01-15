<?php

namespace Pixney\BackupModule;

use Pixney\BackupModule\Backup\BackupSeeder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\FilesModule\Disk\Command\LoadDisks;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;

/**
 * Class FilesModuleSeeder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class BackupModuleSeeder extends Seeder
{
    use DispatchesJobs;

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->call(BackupSeeder::class);

        $this->dispatch(new LoadDisks());

        // $this->call(FolderSeeder::class);
    }
}
