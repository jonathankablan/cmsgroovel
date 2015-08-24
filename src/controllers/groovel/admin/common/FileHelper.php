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

namespace controllers\groovel\admin\common;



class FileHelper {

	/*public static function uploadFile2($_FILES){
		$uploaddir = './images/';
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		\Log::info($uploadfile);
		$upload_success=move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
		return $upload_success;
	}*/
   public static function generateUrlFile(){
   	
   	
   }
	
	public static function uploadFile($files){	
		if (!isset($files["files"]))
			die ("Error: no files uploaded!");
		$file_count = count($files["files"]['name']);
		echo $file_count . " file(s) sent... <BR><BR>";
		if(count($files["files"]['name'])>0) { //check if any file uploaded
			for($j=0; $j < count($files["files"]['name']); $j++) { //loop the uploaded file array
				$filen = $files["files"]['name'][$j];
		
				// ingore empty input fields
				if ($filen!="")
				{
					// destination path - you can choose any file name here (e.g. random)
					$path = "./images/" . $filen;
					if(move_uploaded_file($files["files"]['tmp_name']["$j"],$path)) {
						echo "File# ".($j+1)." ($filen) uploaded successfully!<br>";
					} else
					{
					echo  "Errors occoured during file upload!";
					}
					}
				}
			}
	}
}