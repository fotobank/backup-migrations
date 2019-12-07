# backup-migrations
Repository to perform a database backup before migrations and seeds are run.

Require this package using
  ```composer require fotobank/backup-migrations```

Register the 
  ```Fotobank\BackupMigrations\BackupMigrationsServiceProvider::class,```
service provider in the applications providers array.

Run
  ```php artisan vendor:publish --tag="backup-migrations"	```
to publish the config file.

Run the commands


  ```php artisan migrate```
  
  
  ```php artisan db:seed```
  
 
as usual. In the background a backup dump of the database will be taken.

To restore the most recent backup run


  ```php artisan migrate:restore```
  
To specify file a backup use the


  ```--file=```
  
  
option.


