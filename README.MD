## Groovel cms  version2 ##
 
### Installation ###
 
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
 
The next required step is to add the service provider to config/app.php :
```
    'Illuminate\Html\HtmlServiceProvider',
    'Groovel\Cmsgroovel\CmsgroovelServiceProvider',
	'Groovel\Cmsgroovel\DaoServiceProvider',
	'Groovel\Cmsgroovel\PermissionServiceProvider',
	'Groovel\Cmsgroovel\BusinessServiceProvider',
	'Groovel\Cmsgroovel\RouteServiceProvider',
	'Groovel\Cmsgroovel\ElasticSearchConnectionServiceProvider',
```
 
### Publish ###
 
The last required step is to publish views and assets in your application with :
```
    php artisan vendor:publish
```
 
Congratulations, you have successfully installed groovel !after report to http://www.groovelcms.com for sql install