## Groovel cms  version2 ##
 
### Installation ###
First install laravel:
composer create-project laravel/laravel=5.1.0 <your project name> --prefer-dist


Add cmsgroovel to your composer.json file to require cmsgroovel :
```
    require : {
        "laravel/framework": "5.1.*",
        "groovel/cmsgroovel": "dev-master"
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
		'Form'=> 'Illuminate\Html\FormFacade::class',
		'HTML'=> 'Illuminate\Html\HtmlFacade::class',
    	
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
    php artisan vendor:publish
```
 
Congratulations, you have successfully installed groovel !after report to http://www.groovelcms.com for sql install