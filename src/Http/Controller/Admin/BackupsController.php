<?php

namespace Pixney\BackupModule\Http\Controller\Admin;

use Pixney\BackupModule\Commands\CreateDbBackup;
use Pixney\BackupModule\Commands\UploadToSpaces;
use Pixney\BackupModule\Commands\CreateFilesBackup;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use Pixney\BackupModule\Backup\Form\BackupFormBuilder;
use Pixney\BackupModule\Backup\Table\BackupTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class BackupsController extends AdminController
{
    /**
     * Display an index of existing entries.
     *
     * @param BackupTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BackupTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param BackupFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(BackupFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param BackupFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(BackupFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    public function make(DigitalOceanManager $digitalocean)
    {
        $name ='mydbs.sql';
        $path = $tmppath = database_path() . '/' . $name;
        //$this->dispatch(new CreateDbBackup($path));
        //$this->dispatch(new UploadToSpaces($path));
        //$path = $this->dispatch(new CreateFilesBackup());
        //$this->dispatch(new UploadToSpaces($path, 'filerna'));
    }
}
