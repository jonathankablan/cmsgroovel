<?php

/**********************************************************************/
/*This file is part of Groovel.                                       */
/*Groovel is free software: you can redistribute it and/or modify     */
/*it under the terms of the GNU General Public License as published by*/
/*the Free Software Foundation, either version 2 of the License, or   */
/*(at your option) any later version.                                 */
/*Groovel is distributed in the hope that it will be useful,          */
/*but WITHOUT ANY WARRANTY; without even the implied warranty of      */
/*MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       */
/*GNU General Public License for more details.                        */
/*You should have received a copy of the GNU General Public License   */
/*along with Groovel.  If not, see <http://www.gnu.org/licenses/>.    */
/**********************************************************************/
namespace Groovel\Cmsgroovel;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use business\groovel\admin\routes\GroovelRoutesBusiness;
use controllers\groovel\admin\routes\GroovelRouteController;
use controllers\groovel\admin\contents\GroovelContentFomController;
use controllers\groovel\admin\users\GroovelUserFormController;
use controllers\groovel\admin\users_permissions\GroovelUserPermissionFormController;
use controllers\groovel\admin\users_permissions\GroovelUsersPermissionsListController;
use controllers\groovel\admin\users_roles\GroovelUserRoleFormController;
use controllers\groovel\admin\users_roles\GroovelUsersRolesListController;
use controllers\groovel\admin\routes\GroovelRoutesFormController;
use controllers\groovel\admin\search\GroovelSearchEngineController;
use business\groovel\admin\users\GroovelUserManagerBusiness;
use controllers\groovel\admin\packages_management\GroovelPackageManagerController;
use business\groovel\admin\bundles\GroovelPackageManagerBusiness;
use controllers\groovel\admin\auth\AuthController;
use handlers\ElasticSearchHandler;
use business\groovel\admin\monitoring\GroovelMonitoringBusiness;
use config\ElasticSearchConnection;
use business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use business\groovel\admin\search\GroovelSearchManagerBusiness;
use business\groovel\admin\configuration\GroovelConfigurationBusiness;
use controllers\groovel\admin\configuration\GroovelSystemConfigurationController;
use controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI;
use business\groovel\admin\trackers\GroovelUserTrackingBusiness;
use controllers\groovel\admin\stats\GroovelDashBoardController;
use business\groovel\admin\messages\GroovelUserMessageBusiness;
use business\groovel\admin\messages\GroovelUserMessageBusinessInterface;
use dao\ConfigurationDao;
use dao\StatsUsersGeolocationDao;
use controllers\groovel\admin\templates\GroovelTemplateManagerController;
use business\groovel\admin\templates\GroovelTemplateManagerBusiness;
use business\groovel\admin\permissions\GroovelPermissionManagerBusiness;
use controllers\groovel\admin\auth\RemindersController;
use controllers\groovel\admin\contact\GroovelContactFormController;
use controllers\groovel\admin\forum\GroovelForumController;
use business\groovel\admin\forum\GroovelForumBusiness;

class BusinessServiceProvider extends \Illuminate\View\ViewServiceProvider {
	public function register() {
		
		// routes binding
		\App::bind ( 'GroovelRoutesBusinessInterface', 'business\groovel\admin\routes\GroovelRoutesBusiness' );
		
		\App::bind ( 'GroovelSearchManagerBusinessInterface', 'business\groovel\admin\search\GroovelSearchManagerBusiness' );
		
		\App::bind ( 'GroovelConfigurationBusinessInterface', 'business\groovel\admin\configuration\GroovelConfigurationBusiness' );
		
		\App::bind ( 'GroovelUserTrackingBusinessInterface', 'business\groovel\admin\trackers\GroovelUserTrackingBusiness' );
		
		\App::bind ( 'GroovelUserMessageBusinessInterface', 'business\groovel\admin\messages\GroovelUserMessageBusiness' );
		
		\App::bind ( 'GroovelTemplateManagerBusinessInterface', 'business\groovel\admin\templates\GroovelTemplateManagerBusiness' );
		
		\App::bind ( 'GroovelForumBusinessInterface', 'business\groovel\admin\forum\GroovelForumBusiness' );
		
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\routes\GroovelRouteController', function () {
			return new GroovelRouteController ( new GroovelRoutesBusiness () );
		} );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\routes\GroovelRoutesFormController', function () {
			return new GroovelRoutesFormController ( new GroovelRoutesBusiness () );
		} );
		
		// contents binding
		\App::bind ( 'GroovelContentManagerBusinessInterface', 'business\groovel\admin\contents\GroovelContentManagerBusiness' );
		
		// content type binding
		\App::bind ( 'GroovelContentTypeManagerBusinessInterface', 'business\groovel\admin\contents\GroovelContentTypeManagerBusiness' );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\contents\GroovelContentFomController', function () {
			return new GroovelContentFomController ( new GroovelContentManagerBusiness (), new GroovelContentTypeManagerBusiness () );
		} );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\content_type\GroovelContentTypeFomController', function () {
			return new GroovelContentTypeFomController ( new GroovelContentTypeManagerBusiness () );
		} );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\contents\GroovelContentsListController', function () {
			return new GroovelContentsListController ( new GroovelContentManagerBusiness () );
		} );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\content_type\GroovelContentTypesListController', function () {
			return new GroovelContentTypesListController ( new GroovelContentTypeManagerBusiness () );
		} );
		
		\App::bind ( 'GroovelUserManagerBusinessInterface', 'business\groovel\admin\users\GroovelUserManagerBusiness' );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\users\GroovelUserFormController', function () {
			return new GroovelUserFormController ( new GroovelUserManagerBusiness () );
		} );
		

		\App::bind('groovel\admin\controllers\groovel\admin\auth\AuthController',function(){
				return new AuthController(new GroovelUserManagerBusiness(), new GroovelPermissionManagerBusiness(), new GroovelConfigurationBusiness(),new GroovelUserManagerBusiness());
		});
		
		\App::bind('groovel\admin\controllers\groovel\admin\auth\RemindersController',function(){
				return new RemindersController( new GroovelConfigurationBusiness());
			});
				 
		\App::bind ( 'groovel\admin\controllers\groovel\admin\users\GroovelUsersListController', function () {
			return new GroovelUsersListController ( new GroovelUserManagerBusiness () );
		} );
		
		\App::bind ( 'GroovelPermissionManagerBusinessInterface', 'business\groovel\admin\permissions\GroovelPermissionManagerBusiness' );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\users_permissions\GroovelUsersPermissionsListController', function () {
			return new GroovelUsersPermissionsListController ( new GroovelPermissionManagerBusiness () );
		} );
		
		\App::bind ( 'GroovelUserRoleManagerBusinessInterface', 'business\groovel\admin\roles\GroovelUserRoleManagerBusiness' );
		
		\App::bind ( 'groovel\admin\controllers\groovel\admin\users_roles\GroovelUsersRolesListController', function () {
			return new GroovelUsersRolesListController ( new GroovelUserRoleManagerBusiness () );
		} );	
    	
    	\App::bind('groovel\admin\controllers\groovel\admin\users_permissions\GroovelUserPermissionFormController',function(){
    			return new GroovelUserPermissionFormController(new GroovelUserManagerBusiness,new GroovelContentTypeManagerBusiness,new GroovelPermissionManagerBusiness);
    	});
    	
    	\App::bind('groovel\admin\controllers\groovel\admin\users_roles\GroovelUserRoleFormController',function(){
    			return new GroovelUserRoleFormController(new GroovelUserRoleManagerBusiness,new GroovelUserManagerBusiness);
    	});
    	
    	
    	\App::bind('GroovelPackageManagerBusinessInterface','business\groovel\admin\bundles\GroovelPackageManagerBusiness');
    		 
    	\App::bind('groovel\admin\controllers\groovel\admin\bundles\GroovelPackageManagerController',function(){
    			return new GroovelPackageManagerController(new GroovelPackageManagerBusiness);
    	});
    	
    	\App::bind ( 'GroovelMonitoringBusinessInterface', 'business\groovel\admin\monitoring\GroovelMonitoringBusiness' );
    	
       \App::bind('handlers\ElasticSearchHandler',function(){
    			return new ElasticSearchHandler(new ElasticSearchConnection,new GroovelMonitoringBusiness(new ElasticSearchConnection()), new GroovelConfigurationBusiness(new ConfigurationDao(),new StatsUsersGeolocationDao()));
    	});

    	
    	\App::bind('business\groovel\admin\monitoring\GroovelMonitoringBusiness',function(){
    		return new GroovelMonitoringBusiness(new ElasticSearchConnection());
    	});
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\user_rules\GroovelUserRulesController', function () {
    		return new GroovelUserRulesController ( new GroovelPermissionManagerBusiness (),new GroovelContentTypeManagerBusiness(),new GroovelUserRoleManagerBusiness());
    	} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\search\GroovelSearchEngineController', function () {
    			return new GroovelSearchEngineController ( new GroovelSearchManagerBusiness (),new GroovelConfigurationBusiness());
    	} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\configuration\GroovelSystemConfigurationController', function () {
    			return new GroovelSystemConfigurationController ( new GroovelConfigurationBusiness ());
    		} );
    		
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI', function () {
    			return new GroovelTrackingUserAPI ( new GroovelUserTrackingBusiness());
    	} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\stats\GroovelDashBoardController', function () {
    			return new GroovelDashBoardController ( new GroovelUserTrackingBusiness ());
    		} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\messages\GroovelMessageController', function () {
    		return new GroovelMessageController ( new GroovelUserMessageBusiness (), new GroovelConfigurationBusiness());
    	} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\templates\GroovelTemplateManagerController', function () {
    			return new GroovelTemplateManagerController (new GroovelPackageManagerBusiness(),new GroovelTemplateManagerBusiness(),new GroovelRoutesBusiness());
    		} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\contact\GroovelContactFormController', function () {
    			return new GroovelContactFormController (new GroovelUserManagerBusiness(), new GroovelUserMessageBusiness (), new GroovelConfigurationBusiness());
    		} );
    	
    	\App::bind ( 'groovel\admin\controllers\groovel\admin\forum\GroovelForumController', function () {
    			return new GroovelForumController (new GroovelForumBusiness(),new GroovelConfigurationBusiness(),new GroovelUserManagerBusiness());
    		} );

    }
    
   

}