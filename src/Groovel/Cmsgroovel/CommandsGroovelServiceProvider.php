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




class CommandsGroovelServiceProvider extends \Illuminate\View\ViewServiceProvider {

public function register()
{
    $this->registerCommands();
}

public function registerCommands()
{
    $this->registerMigrateCommand();
    $this->registerConfigureCommand();
    $this->registerAssetsCommand();
    $this->registerInstallCommand();

    $this->commands(
        'laravel-faq::commands.migrate',
        'laravel-faq::commands.config',
        'laravel-faq::commands.assets',
        'laravel-faq::commands.install'
    );
}

public function registerMigrateCommand()
{
    $this->app['laravel-faq::commands.migrate'] = $this->app->share(function($app)
    {
        return new Console\MigrateCommand;
    });
}

public function registerConfigureCommand()
{
    $this->app['laravel-faq::commands.config'] = $this->app->share(function($app)
    {
        return new Console\ConfigureCommand;
    });
}

public function registerAssetsCommand()
{
    $this->app['laravel-faq::commands.assets'] = $this->app->share(function($app)
    {
        return new Console\AssetsCommand;
    });
}

public function registerInstallCommand()
{
    $this->app['laravel-faq::commands.install'] = $this->app->share(function($app)
    {
        return new Console\InstallCommand;
    });
}
}