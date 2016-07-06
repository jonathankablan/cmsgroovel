## Groovel Platform ##
 
### Installation manual way otherwise use the installer###
First install laravel:
composer create-project laravel/laravel=5.2.31 <your project name> --prefer-dist


Add cmsgroovel to your composer.json file to require cmsgroovel :
```
    require : {
         "groovel/cmsgroovel": "3.0.1-beta"
    }
```
 
Update Composer :
```
    composer update
```
 
The next required step is to add the service provider and alias to config/app.php :
```
		Groovel\Cmsgroovel\CmsgroovelServiceProvider::class,
    	Groovel\Cmsgroovel\DaoServiceProvider::class,
    	Groovel\Cmsgroovel\PermissionServiceProvider::class,
    	Groovel\Cmsgroovel\BusinessServiceProvider::class,
    	Groovel\Cmsgroovel\RouteServiceProvider::class,
    	Groovel\Cmsgroovel\ElasticSearchConnectionServiceProvider::class,
    	
```    	
   Then add Alias to config/app.php :
    	
```    	
	'Input' => Illuminate\Support\Facades\Input::class,
   
    	
```
###Config the authentification in config/auth.php#####
```
 'model' => App\User::class,
 'table' => 'users',
 'password' => [
        'email' => 'cmsgroovel.pages.login_reminders',
        'table' => 'password_reminders',
        'expire' => 60,
    ],


```
###Config the database#####
add in file database.php
``` 
'mysql' => array(
    				'driver'    => 'mysql',
    				'host'      => 'host',
    				'port'      => 'port',
    				'database'  => 'groovel',
    				'username'  => '',
    				'password'  => '',
    				'charset'   => 'utf8',
    				'collation' => 'utf8_unicode_ci',
    				'prefix'    => '',
    		),
``` 

###play sql script to create database####
``` 
Download on http://groovelcms.com/download
``` 

 
### Publish ###
 
The last required step is to publish views and assets in your application with :
```
   php artisan vendor:publish —provider="Groovel\Cmsgroovel\CmsgroovelServiceProvider"
```
 
Congratulations, you have successfully installed groovel !after report to http://www.groovelcms.com for sql install
