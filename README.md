```
php artisan migrate
php artisan db:seed
```


## Import Users
1. `.env` file: 
```
IMPORT_DB_DATABASE=import_db
IMPORT_DB_USERNAME=root
IMPORT_DB_PASSWORD=root
```
2. `php artisan import:users`

## Import Files
1. Path to old files: `storage/import/mp3/*`
2. `php artisan import:files`
