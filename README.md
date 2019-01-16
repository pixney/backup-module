# backup-module

## Installation

Run the following composer command

```
composer require pixney/backup-module
php artisan addon:install pixney.module.backup
php artisan db:seed --addon=pixney.module.backup
```

Then within the admin you add your backup job with a cron schedule. See [Cronjob Guru for reference](https://crontab.guru/)


Add a cronjob :
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
