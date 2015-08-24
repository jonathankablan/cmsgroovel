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
namespace commmands;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
 
class WorkbenchCommand extends Command {
 
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'workbenchplus';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package workbench.';
 
    /**
     * The file system instance.
     *
     * @var string
     */
    protected $files;
 
    /**
     * Set configuration item
     *
     * @param  string $contents
     * @param  string $key
     * @param  string $value
     * @return void
     */
    private function setItem(&$contents, $key, $value)
    {
        $pattern = "#('$key' => ').*'#";
        $replacement = "$1$value'";
        $contents = preg_replace($pattern, $replacement, $contents);
    }
    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }
 
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // Name
        $name = $this->ask("What is the name ?");
        // Email
        $email = $this->ask("What is the email ?");
        // Workbench config file content
        $contents = $this->files->get($path = $this->laravel['path'].'/config/workbench.php');    
        // Set name
        $this->setItem($contents, 'name', $name);
        // Set email
        $this->setItem($contents, 'email', $email);
        // Save config file
        $this->files->put($path, $contents);
        // Call workbench command
        $this->call('workbench', array(
            'package' => $this->argument('package'), 
            '--resources' => $this->option('resources') 
        ));
    }
 
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('package', InputArgument::REQUIRED, 'The name (vendor/name) of the package.'),
        );
    }
 
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('resources', null, InputOption::VALUE_OPTIONAL, 'Create Laravel specific directories.', null),
        );
    }
 
}