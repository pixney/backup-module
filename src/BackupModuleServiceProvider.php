<?php

namespace Pixney\BackupModule;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Pixney\BackupModule\Backup\BackupModel;
use Pixney\BackupModule\Backup\BackupRepository;
use Pixney\BackupModule\Commands\Backup\CreateBackup;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupsEntryModel;
use Pixney\BackupModule\Backup\Contract\BackupRepositoryInterface;

class BackupModuleServiceProvider extends AddonServiceProvider
{
    /**
     * Additional addon plugins.
     *
     * @type array|null
     */
    protected $plugins = [];

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [];

    /**
     * The addon's scheduled commands.
     *
     * @type array|null
     */
    protected $schedules = [];

    /**
     * The addon API routes.
     *
     * @type array|null
     */
    protected $api = [];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [
        'admin/backup'             => 'Pixney\BackupModule\Http\Controller\Admin\BackupsController@index',
        'admin/backup/create'      => 'Pixney\BackupModule\Http\Controller\Admin\BackupsController@create',
        'admin/backup/edit/{id}'   => 'Pixney\BackupModule\Http\Controller\Admin\BackupsController@edit',
    ];

    /**
     * The addon middleware.
     *
     * @type array|null
     */
    protected $middleware = [
        //Pixney\BackupModule\Http\Middleware\ExampleMiddleware::class
    ];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    protected $groupMiddleware = [
        //'web' => [
        //    Pixney\BackupModule\Http\Middleware\ExampleMiddleware::class,
        //],
    ];

    /**
     * Addon route middleware.
     *
     * @type array|null
     */
    protected $routeMiddleware = [];

    /**
     * The addon event listeners.
     *
     * @type array|null
     */
    protected $listeners = [
        //Pixney\BackupModule\Event\ExampleEvent::class => [
        //    Pixney\BackupModule\Listener\ExampleListener::class,
        //],
    ];

    /**
     * The addon alias bindings.
     *
     * @type array|null
     */
    protected $aliases = [
        //'Example' => Pixney\BackupModule\Example::class
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [
        BackupBackupsEntryModel::class => BackupModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        BackupRepositoryInterface::class => BackupRepository::class,
    ];

    /**
     * Additional service providers.
     *
     * @type array|null
     */
    protected $providers = [
        //\ExamplePackage\Provider\ExampleProvider::class
    ];

    /**
     * The addon view overrides.
     *
     * @type array|null
     */
    protected $overrides = [
        //'streams::errors/404' => 'module::errors/404',
        //'streams::errors/500' => 'module::errors/500',
    ];

    /**
     * The addon mobile-only view overrides.
     *
     * @type array|null
     */
    protected $mobile = [
        //'streams::errors/404' => 'module::mobile/errors/404',
        //'streams::errors/500' => 'module::mobile/errors/500',
    ];

    /**
     * Register the addon.
     */
    public function register(
    ) {
    }

    /**
     * Boot the addon.
     */
    public function boot(Schedule $schedule, BackupRepositoryInterface $backup)
    {
        $backups = $backup->getAll();

        if (!is_null($backups)) {
            foreach ($backups as $backup) {
                $schedule->call(function () use ($backup) {
                    try {
                        $this->dispatch(new CreateBackup($backup));
                        $executionTime    = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
                        $seconds          = $executionTime;
                        echo "This script took {$seconds} to execute.";
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                        Log::error($th->getMessage());
                    }
                })->cron(trim($backup->cron));
            }
        }

        // Run extra post-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Map additional addon routes.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Register dynamic routes here for example.
        // Use method injection or commands to bring in services.
    }
}
