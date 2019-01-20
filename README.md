# LRM "laravel remote manager"
![alt text](https://github.com/faryar76/lrm/raw/master/commands.png "preview in artisan list")

#### by using this package , you can easily manage your project remotely (__without ssh__).
For example :

0. You can run the database migrations files even in server __without__ __"ssh"__
1. You can move migration files from your system to the server and then run database migration command __without ssh__. 
2. You can __upload__ your edited files into the server without entering your own management panel (cpanel or directadmin ...). or upload a new file (or folders) __without ssh__ .


 ### Installation

```

# composer require faryar76/lrm

# php artisan vendor:publish --provider="Faryar76\LRM\LRMServiceProvider"

```
### how to config for use?
##### The first thing you have to do complete the config file __lrm.php__ in :

```
your_project_path\config\lrm.php
```
fill the  __host_path__  in __lrm.php__ with your uploaded project path for **example** :
```
"host_path" => "http://your-website-domain.com/",
```
or in some __sharing hosts__
```
"host_path" => "http://your-website-domain.com/public/",
```
##### also you can set a password for make it more secure in __lrm.php__ : 
```
"password"  => hash('sha512',"type-your-password-here")
```
## how to use?
### upload file
##### for upload single file : 
```
php artisan lrm:upload "path_to_file"

php artisan lrm:upload "app\Http\User.php"
```

##### for upload folder files : 
```
php artisan lrm:upload "path_to_folder"

php artisan lrm:upload "app\Http"
```
##### for upload folder with sub folders : 
```
php artisan lrm:upload "path_to_folder" --sub

php artisan lrm:upload "app\Http" --sub
```
### run migrate files

#### just run Available files on server
```
php artisan lrm:migrate 			// php artisan migrate
php artisan lrm:migrate refresh 	// php artisan migrate:refresh
php artisan lrm:migrate rollback 	// php artisan migrate:rollback
```
#### upload local migrate files to server and run them
```
php artisan lrm:sync_migrate			// php artisan migrate
php artisan lrm:sync_migrate refresh 	// php artisan migrate:refresh
php artisan lrm:sync_migrate rollback 	// php artisan migrate:rollback
```
# 

```
Notice: old files will backup and move to "old_files" folder on your server 
```


