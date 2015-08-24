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
use dao\ContentsDao;
use dao\RouteDao;
use dao\ContentTypeDao;
use dao\WidgetDao;
use dao\UserPermissionDao;
use dao\UserDao;
use dao\UserRoleDao;
use dao\RepositoryIndexDao;
use dao\ConfigurationDao;
use dao\CountryDao;
use dao\LocationIPCitiesDao;
use dao\LocationGeoCitiesDao;
use dao\UserTrackingDao;
use dao\StatsUsersGeolocationDao;
use dao\LocationGeoCountriesDao;
use dao\MessageDao;
use dao\ElasticSearchDao;
use dao\ForumDao;
use handlers\DatabaseSearchHandler;
use business\groovel\admin\contents\GroovelContentManagerBusiness;
use business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use business\groovel\admin\permissions\GroovelPermissionManagerBusiness;
use business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use business\groovel\admin\users\GroovelUserManagerBusiness;
use business\groovel\admin\routes\GroovelRoutesBusiness;
use business\groovel\admin\search\GroovelSearchManagerBusiness;
use business\groovel\admin\configuration\GroovelConfigurationBusiness;
use business\groovel\admin\trackers\GroovelUserTrackingBusiness;
use business\groovel\admin\messages\GroovelUserMessageBusiness;
use config\ElasticSearchConnection;
use business\groovel\admin\forum\GroovelForumBusiness;



class DaoServiceProvider extends \Illuminate\View\ViewServiceProvider {

       
    public function register()
    {
    	\App::bind('dao\ContentsDaoInterface','dao\ContentsDao');
    	\App::bind('dao\RouteDaoInterface','dao\RouteDao');
    	\App::bind('dao\ContentTypeDaoInterface','dao\ContentTypeDao');
    	\App::bind('dao\WidgetDaoInterface','dao\WidgetDao');
    	\App::bind('dao\UserDaoInterface','dao\UserDao');
    	\App::bind('dao\UserPermissionDaoInterface','dao\UserPermissionDao');
    	\App::bind('dao\UserRoleDaoInterface','dao\UserRoleDao');
    	\App::bind('dao\RepositoryIndexDaoInterface','dao\RepositoryIndexDao');
    	\App::bind('dao\ConfigurationDaoInterface','dao\ConfigurationDao');
    	\App::bind('dao\CountryDaoInterface','dao\CountryDao');
    	\App::bind('dao\LocationIPCityDaoInterface','dao\LocationIPCityDao');
    	\App::bind('dao\LocationGeoCitiesDaoInterface','dao\LocationGeoCitiesDao');
    	\App::bind('dao\UserTrackingDaoInterface','dao\UserTrackingDao');
    	\App::bind('dao\StatsUsersGeolocationDaoInterface','dao\StatsUsersGeolocationDao');
    	\App::bind('dao\LocationGeoCountriesDaoInterface','dao\LocationGeoCountriesDao');
    	\App::bind('dao\MessageDaoInterface','dao\MessageDao');
    	\App::bind('dao\ElasticSearchDaoInterface','dao\ElasticSearchDao');
    	\App::bind('dao\ForumDaoInterface','dao\ForumDao');
    	 
    	 
    	
    	\App::bind('business\groovel\admin\contents\GroovelContentManagerBusiness',function(){
    	 return new GroovelContentManagerBusiness(new ContentsDao,new RouteDao,new ContentTypeDao);
    	 });
    	
    	\App::bind('business\groovel\admin\contents\GroovelContentTypeManagerBusiness',function(){
    			return new GroovelContentTypeManagerBusiness(new ContentsDao,new ContentTypeDao,new WidgetDao);
    	});
    	

    	\App::bind('business\groovel\admin\permissions\GroovelPermissionManagerBusiness',function(){
    			return new GroovelPermissionManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao);
    	});
    	
    	\App::bind('business\groovel\admin\roles\GroovelUserRoleManagerBusiness',function(){
    			return new GroovelUserRoleManagerBusiness(new UserDao,new UserRoleDao);
    	});
    	
    	\App::bind('business\groovel\admin\users\GroovelUserManagerBusiness',function(){
    			return new GroovelUserManagerBusiness(new UserDao,new ContentTypeDao,new UserPermissionDao,new UserRoleDao);
    	});
    	
    	\App::bind('business\groovel\admin\routes\GroovelRoutesBusiness',function(){
    			return new GroovelRoutesBusiness(new RouteDao, new ContentTypeDao);
    	});
    	
    	\App::bind('handlers\DatabaseSearchHandler',function(){
    			return new DatabaseSearchHandler(new RepositoryIndexDao);
    	});
    	
    	\App::bind('business\groovel\admin\search\GroovelSearchManagerBusiness',function(){
    			return new GroovelSearchManagerBusiness(new RepositoryIndexDao, new ElasticSearchDao(new ElasticSearchConnection()));
    	});
    	
    	\App::bind('business\groovel\admin\configuration\GroovelConfigurationBusiness',function(){
    			return new GroovelConfigurationBusiness(new ConfigurationDao, new StatsUsersGeolocationDao);
    		});
        
        
        \App::bind('business\groovel\admin\trackers\GroovelUserTrackingBusiness',function(){
        	return new GroovelUserTrackingBusiness(new LocationIPCitiesDao ,new LocationGeoCitiesDao,new UserTrackingDao, 
        			new StatsUsersGeolocationDao,new CountryDao, new LocationGeoCountriesDao,new UserDao, new MessageDao);
        });
        
        
        \App::bind('business\groovel\admin\messages\GroovelUserMessageBusiness',function(){
        		return new GroovelUserMessageBusiness(new MessageDao,new UserDao, new ConfigurationDao);
        });
        
       
       \App::bind('business\groovel\admin\forum\GroovelForumBusiness',function(){
        		return new GroovelForumBusiness(new ForumDao,new UserDao,new ConfigurationDao);
        	});
        
        }
    
   

}