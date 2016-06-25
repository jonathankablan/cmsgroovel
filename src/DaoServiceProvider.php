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
use Groovel\Cmsgroovel\dao\RolePermissionsDao;
use Groovel\Cmsgroovel\dao\RolePermissionsDaoInterface;
use Groovel\Cmsgroovel\dao\RoleDao;
use Groovel\Cmsgroovel\dao\RoleDaoInterface;
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
use Groovel\Cmsgroovel\dao\LocationIPCitiesDao;
use Groovel\Cmsgroovel\dao\LocationGeoCitiesDao;
use Groovel\Cmsgroovel\dao\UserTrackingDao;
use Groovel\Cmsgroovel\dao\StatsUsersGeolocationDao;
use Groovel\Cmsgroovel\dao\LocationGeoCountriesDao;
use Groovel\Cmsgroovel\dao\MessageDao;
use Groovel\Cmsgroovel\dao\ElasticSearchDao;
use Groovel\Cmsgroovel\dao\ForumDao;
use Groovel\Cmsgroovel\dao\MenuDao;
use Groovel\Cmsgroovel\dao\MenuDaoInterface;
use Groovel\Cmsgroovel\handlers\DatabaseSearchHandler;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\config\ElasticSearchConnection;
use Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusiness;
use Groovel\Cmsgroovel\dao\ContentsTranslationDaoInterface;
use Groovel\Cmsgroovel\dao\ContentsTranslationDao;
use Groovel\Cmsgroovel\dao\LayoutDao;
use Groovel\Cmsgroovel\dao\LayoutDaoInterface;
use Groovel\Cmsgroovel\dao\CommentsDao;
use Groovel\Cmsgroovel\dao\CommentsDaoInterface;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelRolePermissionsBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelRolePermissionsBusinessInterface;
use Groovel\Cmsgroovel\dao\PermissionsDao;
use Groovel\Cmsgroovel\dao\PermissionsDaoInterface;


class DaoServiceProvider extends \Illuminate\View\ViewServiceProvider {

       
    public function register()
    {
    	\App::bind('Groovel\Cmsgroovel\dao\ContentsDaoInterface','Groovel\Cmsgroovel\dao\ContentsDao');
    	\App::bind('Groovel\Cmsgroovel\dao\RouteDaoInterface','Groovel\Cmsgroovel\dao\RouteDao');
    	\App::bind('Groovel\Cmsgroovel\dao\ContentTypeDaoInterface','Groovel\Cmsgroovel\dao\ContentTypeDao');
    	\App::bind('Groovel\Cmsgroovel\dao\WidgetDaoInterface','Groovel\Cmsgroovel\dao\WidgetDao');
    	\App::bind('Groovel\Cmsgroovel\dao\UserDaoInterface','Groovel\Cmsgroovel\dao\UserDao');
    	\App::bind('Groovel\Cmsgroovel\dao\UserPermissionDaoInterface','Groovel\Cmsgroovel\dao\UserPermissionDao');
    	\App::bind('Groovel\Cmsgroovel\dao\UserRoleDaoInterface','Groovel\Cmsgroovel\dao\UserRoleDao');
    	\App::bind('Groovel\Cmsgroovel\dao\RepositoryIndexDaoInterface','Groovel\Cmsgroovel\dao\RepositoryIndexDao');
    	\App::bind('Groovel\Cmsgroovel\dao\ConfigurationDaoInterface','Groovel\Cmsgroovel\dao\ConfigurationDao');
    	\App::bind('Groovel\Cmsgroovel\dao\CountryDaoInterface','Groovel\Cmsgroovel\dao\CountryDao');
    	\App::bind('Groovel\Cmsgroovel\dao\LocationIPCitiesDaoInterface','Groovel\Cmsgroovel\dao\LocationIPCitiesDao');
    	\App::bind('Groovel\Cmsgroovel\dao\LocationGeoCitiesDaoInterface','Groovel\Cmsgroovel\dao\LocationGeoCitiesDao');
    	\App::bind('Groovel\Cmsgroovel\dao\UserTrackingDaoInterface','Groovel\Cmsgroovel\dao\UserTrackingDao');
    	\App::bind('Groovel\Cmsgroovel\dao\StatsUsersGeolocationDaoInterface','Groovel\Cmsgroovel\dao\StatsUsersGeolocationDao');
    	\App::bind('Groovel\Cmsgroovel\dao\LocationGeoCountriesDaoInterface','Groovel\Cmsgroovel\dao\LocationGeoCountriesDao');
    	\App::bind('Groovel\Cmsgroovel\dao\MessageDaoInterface','Groovel\Cmsgroovel\dao\MessageDao');
    	\App::bind('Groovel\Cmsgroovel\dao\ElasticSearchDaoInterface','Groovel\Cmsgroovel\dao\ElasticSearchDao');
    	\App::bind('Groovel\Cmsgroovel\dao\ForumDaoInterface','Groovel\Cmsgroovel\dao\ForumDao');
    	\App::bind('Groovel\Cmsgroovel\dao\ContentsTranslationDaoInterface','Groovel\Cmsgroovel\dao\ContentsTranslationDao');
    	\App::bind('Groovel\Cmsgroovel\dao\MenuDaoInterface','Groovel\Cmsgroovel\dao\MenuDao');
    	\App::bind('Groovel\Cmsgroovel\dao\LayoutDaoInterface','Groovel\Cmsgroovel\dao\LayoutDao');
    	\App::bind('Groovel\Cmsgroovel\dao\CommentsDaoInterface','Groovel\Cmsgroovel\dao\CommentsDao');
    	\App::bind('Groovel\Cmsgroovel\dao\RoleDaoInterface','Groovel\Cmsgroovel\dao\RoleDao');
    	\App::bind('Groovel\Cmsgroovel\dao\RolePermissionsDaoInterface','Groovel\Cmsgroovel\dao\RolePermissionsDao');
    	\App::bind('Groovel\Cmsgroovel\dao\PermissionsDaoInterface','Groovel\Cmsgroovel\dao\PermissionsDao');
    	
    	 
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelRolePermissionsBusiness',function(){
    		return new GroovelRolePermissionsBusiness(new RolePermissionsDao,new RoleDao,new PermissionsDao);
    	});
    		 
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusiness',function(){
    		return new GroovelCommentBusiness(new CommentsDao);
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness',function(){
    	 return new GroovelContentManagerBusiness(new ContentsDao,new RouteDao,new ContentTypeDao,new CountryDao,new ContentsTranslationDao,new CommentsDao);
    	 });
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness',function(){
    			return new GroovelContentTypeManagerBusiness(new ContentsDao,new ContentTypeDao,new WidgetDao);
    	});
    	

    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness',function(){
    			return new GroovelPermissionManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao,new RoleDao);
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusiness',function(){
    			return new GroovelUserRoleManagerBusiness(new UserDao,new UserRoleDao);
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness',function(){
    			return new GroovelUserManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao);
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness',function(){
    			return new GroovelRoutesBusiness(new RouteDao, new ContentTypeDao);
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler',function(){
    			return new DatabaseSearchHandler(new RepositoryIndexDao());
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusiness',function(){
    			return new GroovelSearchManagerBusiness(new RepositoryIndexDao, new ElasticSearchDao(new ElasticSearchConnection()));
    	});
    	
    	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness',function(){
    			return new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao);
    		});
        
        
        \App::bind('Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusiness',function(){
        	return new GroovelUserTrackingBusiness(new LocationIPCitiesDao ,new LocationGeoCitiesDao,new UserTrackingDao, 
        			new StatsUsersGeolocationDao,new CountryDao, new LocationGeoCountriesDao,new UserDao, new MessageDao);
        });
        
        
        \App::bind('Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness',function(){
        		return new GroovelUserMessageBusiness(new MessageDao,new UserDao, new ConfigurationDao);
        });
        
       
       \App::bind('Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusiness',function(){
        		return new GroovelForumBusiness(new ForumDao,new UserDao,new ConfigurationDao);
        	});
       

       	\App::bind('Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness',function(){
       		return new GroovelMenuBusiness(new MenuDao,new CountryDao);
       	});
       	
       	
       		\App::bind('Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness',function(){
       			return new GroovelLayoutBusiness(new LayoutDao,new CountryDao);
       		});
       
        
        }
    
   

}