# backup-module

This module is heavily under construction. 

It currently enables you to create backups of the database as well file backups of laravel helper paths. The backups are then uploaded to your digital ocean spaces (s3) for storage.


## Installation

### Composer
Run the following composer command

```
composer require pixney/backup-module
php artisan addon:install pixney.module.backup
```

### .env
```
S3_KEY=""
S3_SECRET=""
S3_CLIENT=""
S3_ENDPOINT=""
S3_REGION=""
```

Then within the admin you add your backup job with a cron schedule. See [Cronjob Guru for reference](https://crontab.guru/)


Add a cronjob :
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
