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
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentFomController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users\GroovelUserFormController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_permissions\GroovelUserPermissionFormController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_permissions\GroovelUsersPermissionsListController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_roles\GroovelUserRoleFormController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_roles\GroovelUsersRolesListController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRoutesFormController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\search\GroovelSearchEngineController;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\bundles\GroovelPackageManagerController;
use Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\auth\AuthController;
use Groovel\Cmsgroovel\handlers\ElasticSearchHandler;
use Groovel\Cmsgroovel\business\groovel\admin\monitoring\GroovelMonitoringBusiness;
use Groovel\Cmsgroovel\config\ElasticSearchConnection;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\stats\GroovelDashBoardController;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusinessInterface;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\templates\GroovelTemplateManagerController;
use Groovel\Cmsgroovel\business\groovel\admin\templates\GroovelTemplateManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\auth\RemindersController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contact\GroovelContactFormController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\forum\GroovelForumController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentsListController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users\GroovelUsersListController;
use Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\content_type\GroovelContentTypesListController;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\models\Subtype;
use Groovel\Cmsgroovel\dao\LocationIPCitiesDao;
use Groovel\Cmsgroovel\dao\ContentsDao;
use Groovel\Cmsgroovel\dao\RouteDao;
use Groovel\Cmsgroovel\dao\ContentTypeDao;
use Groovel\Cmsgroovel\dao\WidgetDao;
use Groovel\Cmsgroovel\dao\UserPermissionDao;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\UserRoleDao;
use Groovel\Cmsgroovel\dao\RepositoryIndexDao;
use Groovel\Cmsgroovel\dao\ConfigurationDao;
use Groovel\Cmsgroovel\dao\CountryDao;
use Groovel\Cmsgroovel\dao\LocationGeoCitiesDao;
use Groovel\Cmsgroovel\dao\UserTrackingDao;
use Groovel\Cmsgroovel\dao\StatsUsersGeolocationDao;
use Groovel\Cmsgroovel\dao\LocationGeoCountriesDao;
use Groovel\Cmsgroovel\dao\MessageDao;
use Groovel\Cmsgroovel\dao\ElasticSearchDao;
use Groovel\Cmsgroovel\dao\ForumDao;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusinessInterface;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\messages\GroovelMessageController;
use Groovel\Cmsgroovel\dao\ContentsTranslationDaoInterface;
use Groovel\Cmsgroovel\dao\ContentsTranslationDao;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness;
use Groovel\Cmsgroovel\dao\MenuDaoInterface;
use Groovel\Cmsgroovel\dao\MenuDao;
use Groovel\Cmsgroovel\dao\LayoutDaoInterface;
use Groovel\Cmsgroovel\dao\LayoutDao;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\menu\GroovelMenuController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\layout\GroovelLayoutController;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\page\GroovelPageController;
use Groovel\Cmsgroovel\dao\CommentsDao;
use Groovel\Cmsgroovel\dao\CommentsDaoInterface;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusinessInterface;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\comments\GroovelCommentController;

class BusinessServiceProvider extends \Illuminate\View\ViewServiceProvider {
	public function register() {
		
		// routes binding
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\templates\GroovelTemplateManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\templates\GroovelTemplateManagerBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\comments\GroovelCommentController', function () {
			return new GroovelCommentController ( new GroovelCommentBusiness (new CommentsDao()));
		} );
		
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\layout\GroovelLayoutController', function () {
			return new GroovelPageController ( new GroovelRoutesBusiness() ,new GroovelLayoutBusiness ());
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\layout\GroovelLayoutController', function () {
			return new GroovelLayoutController ( new GroovelLayoutBusiness (new LayoutDao(),new CountryDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\menu\GroovelMenuController', function () {
			return new GroovelMenuController ( new GroovelMenuBusiness (new MenuDao(),new CountryDao()),new GroovelLayoutBusiness (new LayoutDao(),new CountryDao()));
		} );
		
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController', function () {
			return new GroovelRouteController ( new GroovelRoutesBusiness (new RouteDao(),new ContentTypeDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRoutesFormController', function () {
			return new GroovelRoutesFormController ( new GroovelRoutesBusiness (new RouteDao(),new ContentTypeDao()),new GroovelLayoutBusiness (new LayoutDao(),new CountryDao()));
		} );
		
		// contents binding
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness' );
		
		// content type binding
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness' );
		
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentFomController', function () {
			return new GroovelContentFomController ( new GroovelContentManagerBusiness (new ContentsDao(),new RouteDao(),new ContentTypeDao(), new CountryDao(),new ContentsTranslationDao(), new CommentsDao()), new GroovelContentTypeManagerBusiness (new ContentsDao(),new ContentTypeDao(),new WidgetDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\content_type\GroovelContentTypeFomController', function () {
			return new GroovelContentTypeFomController ( new GroovelContentTypeManagerBusiness (new ContentsDao(),new ContentTypeDao(),new WidgetDao()),new GroovelLayoutBusiness (new LayoutDao(),new CountryDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentsListController', function () {
			return new GroovelContentsListController ( new GroovelContentManagerBusiness (new ContentsDao(),new RouteDao(),new ContentTypeDao(),new CountryDao(),new ContentsTranslationDao(), new CommentsDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\content_type\GroovelContentTypesListController', function () {
			return new GroovelContentTypesListController ( new GroovelContentTypeManagerBusiness (new ContentsDao(),new ContentTypeDao(),new WidgetDao()) );
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users\GroovelUserFormController', function () {
			return new GroovelUserFormController ( new GroovelUserManagerBusiness (new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()) );
		} );

		\App::bind('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\auth\AuthController',function(){
				return new AuthController(new GroovelUserManagerBusiness(new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()), new GroovelPermissionManagerBusiness(new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()), new GroovelConfigurationBusiness(new ConfigurationDao(),new StatsUsersGeolocationDao()),
						new GroovelUserMessageBusiness(new MessageDao(),new UserDao(),new ConfigurationDao()));
		});
		
		\App::bind('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\auth\RemindersController',function(){
				return new RemindersController( new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao));
			});
				 
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users\GroovelUsersListController', function () {
			return new GroovelUsersListController ( new GroovelUserManagerBusiness (new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()));
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_permissions\GroovelUsersPermissionsListController', function () {
			return new GroovelUsersPermissionsListController ( new GroovelPermissionManagerBusiness (new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao) );
		} );
		
		\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusiness' );
		
		\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_roles\GroovelUsersRolesListController', function () {
			return new GroovelUsersRolesListController ( new GroovelUserRoleManagerBusiness (new UserDao,new UserRoleDao) );
		} );	
    	
    	\App::bind('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_permissions\GroovelUserPermissionFormController',function(){
    			return new GroovelUserPermissionFormController(new GroovelUserManagerBusiness(new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()),new GroovelContentTypeManagerBusiness(new ContentsDao(),new ContentTypeDao(),new WidgetDao()),new GroovelPermissionManagerBusiness(new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()));
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_roles\GroovelUserRoleFormController',function(){
    			return new GroovelUserRoleFormController(new GroovelUserRoleManagerBusiness(new UserDao,new UserRoleDao),new GroovelUserManagerBusiness(new UserDao(),new ContentTypeDao(),new UserPermissionDao(),new UserRoleDao()));
    	});
    	
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusinessInterface','Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusiness');
    		 
    	\App::bind('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\bundles\GroovelPackageManagerController',function(){
    			return new GroovelPackageManagerController(new GroovelPackageManagerBusiness);
    	});
    	
    	\App::bind ( 'Groovel\Cmsgroovel\business\groovel\admin\monitoring\GroovelMonitoringBusinessInterface', 'Groovel\Cmsgroovel\business\groovel\admin\monitoring\GroovelMonitoringBusiness' );
    	
       \App::bind('Groovel\Cmsgroovel\handlers\ElasticSearchHandler',function(){
    			return new ElasticSearchHandler(new ElasticSearchConnection,new GroovelMonitoringBusiness(new ElasticSearchConnection()), new GroovelConfigurationBusiness(new ConfigurationDao(),new StatsUsersGeolocationDao()));
    	});

    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\monitoring\GroovelMonitoringBusiness',function(){
    		return new GroovelMonitoringBusiness(new ElasticSearchConnection());
    	});
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\user_rules\GroovelUserRulesController', function () {
    		return new GroovelUserRulesController ( new GroovelPermissionManagerBusiness (new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao),new GroovelContentTypeManagerBusiness(new ContentsDao,new ContentTypeDao,new WidgetDao),new GroovelUserRoleManagerBusiness(new UserDao,new UserRoleDao));
    	} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\search\GroovelSearchEngineController', function () {
    			return new GroovelSearchEngineController ( new GroovelSearchManagerBusiness (new RepositoryIndexDao, new ElasticSearchDao(new ElasticSearchConnection())),new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao));
    	} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController', function () {
    			return new GroovelSystemConfigurationController ( new GroovelConfigurationBusiness (new ConfigurationDao, new StatsUsersGeolocationDao));
    		} );
    		
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI', function () {
    			return new GroovelTrackingUserAPI (new GroovelUserTrackingBusiness(new LocationIPCitiesDao ,new LocationGeoCitiesDao,new UserTrackingDao, 
        			new StatsUsersGeolocationDao,new CountryDao, new LocationGeoCountriesDao,new UserDao, new MessageDao));
    	} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\stats\GroovelDashBoardController', function () {
    			return new GroovelDashBoardController ( new GroovelUserTrackingBusiness (new LocationIPCitiesDao ,new LocationGeoCitiesDao,new UserTrackingDao, 
        			new StatsUsersGeolocationDao,new CountryDao, new LocationGeoCountriesDao,new UserDao, new MessageDao));
    		} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\messages\GroovelMessageController', function () {
    		return new GroovelMessageController ( new GroovelUserMessageBusiness (new MessageDao,new UserDao, new ConfigurationDao), new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao));
    	} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\templates\GroovelTemplateManagerController', function () {
    			return new GroovelTemplateManagerController (new GroovelPackageManagerBusiness(),new GroovelTemplateManagerBusiness(),new GroovelRoutesBusiness(new RouteDao, new ContentTypeDao));
    		} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contact\GroovelContactFormController', function () {
    			return new GroovelContactFormController (new GroovelUserManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao), new GroovelUserMessageBusiness (new MessageDao,new UserDao, new ConfigurationDao), new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao));
    		} );
    	
    	\App::bind ( 'Groovel\Cmsgroovel\Http\Controllers\groovel\admin\forum\GroovelForumController', function () {
    			return new GroovelForumController (new GroovelForumBusiness(new ForumDao,new UserDao,new ConfigurationDao),new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao),new GroovelUserManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao));
    		} );

    }
    
   

}