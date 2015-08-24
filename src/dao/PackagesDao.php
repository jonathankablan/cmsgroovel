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
class PackagesDao{
	
	public function listFiles(){
		//path to directory to scan
		$directory = "index_files/";
		
		//get all files in specified directory
		$files = glob($directory . "*");
		
		//print each file name
		foreach($files as $file)
		{
			//check to see if the file is a folder/directory
			if(is_dir($file))
			{
				echo $file;
			}
		}
	}
	
	public function listFolders()
	{
		// get the base directory
		$base_dir = dir(BASE_UPLOAD_DIR) or die("Failed opening the directory for reading");
	
		$base_dir = '"'.BASE_UPLOAD_DIR.'"';
		if (is_dir($base_dir))
		{
			while (($dir = readdir($base_dir)) !== FALSE)
			{
				if (is_dir($dir) /* && check if the folder contains "date_" */)
				{
					$dirs[] = array (
							'name' => ""
					);
				}
			}
			closedir($base_dir);
		}
		return $dirs;
	}
}