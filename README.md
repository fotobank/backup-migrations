# backup-migrations
Repository to perform a database backup before migrations and seeds are run.

Require this package using
  ```composer require pangolinkeys/backup-migrations```

Register the 
  ```BackupMigrationsServiceProvider:class```
service provider in the applications providers array.

Run
  ```php artisan vendor:publish --class=BackupMigrationsServiceProvider```
to publish the config file.

Run the commands


  ```php artisan migrate```
  
  
  ```php artisan db:seed```
  
 
as usual. In the background a backup dump of the database will be taken.

To restore the most recent backup run


  ```php artisan migrate:restore```
  
To specify a backup use the


  ```--file=```
  
  
option.


