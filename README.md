
# report managment system

Laravel project for admin to create users to manage reports.

## getting started

1. clone or download the repo.
2. cd into the project
3. install composer Dependencies
```bash
composer install
``` 
4. install NPM Dependencies
```bash
npm install
``` 
5. fill database information in the .env file
6. Generate an app encryption key
```bash
php artisan key:generate
``` 
7. Migrate the database
```bash
php artisan migrate
``` 
8. Seed the database to generate the admin
email: admin@hotmail.com
password: 12345678

9. connect public folder to storage folder by using
```bash
php artisan storage:link
``` 
10. to open the project use 
```bash
 php artisan serve 
```
