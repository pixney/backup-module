<?php

namespace Pixney\BackupModule\Http\Controller\Admin;

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
}
