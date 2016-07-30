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
namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\files;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\log\LogConsole;



class GroovelFileController extends GroovelController {
	
	/*base_dir: string, holds the base directory which is the root directory for users, and they are not allowed to navigate to an upper level directory.
p: string, the folder path we want to browse.
f: string, a comma separated file types to filter the result (user folder if you want to show folders).
allowed_depth: number, the maximum depth level of child directories the user can access.

Declare an empty array (contents) to hold files and folders found as a result of the function call.
Trim all textual arguments.
Set default base_dir to the current if passed as an empty string.
Remove all ./ and ../ sequence from requested folder path which may allow users to navigate to levels upper than base_dir's , and this is what you don't want.
Combine passed folder path with the (base_dir) so user doesn't need to know what is the base directory and use only relative paths.

Check if the new path is a directory and get the directory from the path if it's not.
Make sure the path ends with a slash (/) for later use.

Check if the directory depth is within allowed depth otherwise slice allowed path.
Explode passed filter (f) to an array (filter) of file types (extensions).

*now it's time to process the scan result array (files) using (for) loop.
We get the path to the file by combining the path to the directory with the file name from the (files) array.

The file path may represent a folder too, so we check for this case, cause we'll treat folders differently.

Declare a new Boolean variable (add), this variable we'll be set to true when the file type matches the filter (in some other cases too).
Declare a file type variable (fType).

If the file path represents a file : (not directory)
Take the file extension and apply it to the filter.
Set the variable (add) to true if there is a match.

If the file path represents a directory:
Ignore when file name is (.) which represents the current directory.
Set the variable (add) to true, so all folder we'll be displayed.
Don't (add) the folder if there is a filter and this filter doesn't contain the folder file type (folder).

Get the parent directory path if the file name represents the parent directory (..).
We shouldn't display a link to the parent directory if it refers to directories beyond the base_dir (its path length is less than the base_dir path length), we must stick to the base_dir directory.

Remove the base_dir from file paths and added to the (contents) array if it passes the filter (add==true).*/
	
	
	public function validateExtension($ext){
		if($ext=='image/jpeg'|| $ext=='image/png' || $ext=='image/gif' ||  $ext=='application/pdf' || $ext=''){
			return true;
		}else return false;
	}
	
	public function validateForm(){
		if(array_key_exists('file', $_FILES)){
			if( $_FILES['file']!=null){
				if ($_FILES['file']['size']>(1024*1024*2)){
					return $this->jsonResponse('files is too big limited to max 2M',false,true,true);
				}
				if(!($this->validateExtension($_FILES['file']['type']))){
					return $this->jsonResponse('files type not autorized',false,true,true);
				} 
				
				
				if(strpos($_FILES['file']['name'], ' ') > 0){
					return $this->jsonResponse('file name not valid',false,true,true);
				}
			}
		}

		return $this->uploadFile();
	}
	
	public function getWidget(){
		$content=\View::make('cmsgroovel.sections.uploadfile',['content'=>array()])->render();
		return  \Response::json(array('html' => $content));
	}
	
	public function explorerDir(){
	//	\Log::info('explore');
	//	\Log::info($_POST);
		$p=isset($_POST["path"])?$_POST["path"]:"";
		$f=isset($_POST["filter"])?$_POST["filter"]:"";
		return json_encode($this->searchDir("./",$p,$f,-1));
	}
	
	function searchDir($base_dir="./",$p="",$f="",$allowed_depth=-1){
		$contents=array();
	
		$base_dir=trim($base_dir);
		$p=trim($p);
		$f=trim($f);
	
		if($base_dir=="")$base_dir="./";
		if(substr($base_dir,-1)!="/")$base_dir.="/";
		$p=str_replace(array("../","./"),"",trim($p,"./"));
		$p=$base_dir.$p;
	
		if(!is_dir($p))$p=dirname($p);
		if(substr($p,-1)!="/")$p.="/";
	
		if($allowed_depth>-1){
			$allowed_depth=count(explode("/",$base_dir))+ $allowed_depth-1;
			$p=implode("/",array_slice(explode("/",$p),0,$allowed_depth));
			if(substr($p,-1)!="/")$p.="/";
		}
	
		$filter=($f=="")?array():explode(",",strtolower($f));
	
		$files=@scandir($p);
		if(!$files)return array("contents"=>array(),"currentPath"=>$p);
	
		for ($i=0;$i<count($files);$i++){
			$fName=$files[$i];
			$fPath=$p.$fName;
	
			$isDir=is_dir($fPath);
			$add=false;
			$fType="folder";
	
			if(!$isDir){
				$ft=strtolower(substr($files[$i],strrpos($files[$i],".")+1));
				$fType=$ft;
				if($f!=""){
					if(in_array($ft,$filter))$add=true;
				}else{
					$add=true;
				}
			}else{
				if($fName==".")continue;
				$add=true;
					
				if($f!=""){
					if(!in_array($fType,$filter))$add=false;
				}
	
				if($fName==".."){
					if($p==$base_dir){
						$add=false;
					}else $add=true;
	
					$tempar=explode("/",$fPath);
					array_splice($tempar,-2);
					$fPath=implode("/",$tempar);
					if(strlen($fPath)<= strlen($base_dir))$fPath="";
				}
			}
	
			if($fPath!="")$fPath=substr($fPath,strlen($base_dir));
			if($add)$contents[]=array("fPath"=>$fPath,"fName"=>$fName,"fType"=>$fType);
		}
	
		$p=(strlen($p)<= strlen($base_dir))?$p="":substr($p,strlen($base_dir));
		return array("contents"=>$contents,"currentPath"=>$p);
	}
		
	
	public function browserFile(){
		//\Log::info('browser');
		return \View::make('cmsgroovel.pages.file_browser');
	}
	
	public function generateUrlFile($files){
		 $array_url=array();
		 $path=url('/images/').'/';
		 foreach($files as $file){
		 	$array_url[$file['name']]=$path.$file['name'];
		 }
		// \Log::info($array_url);
		 return $array_url;
	}
	
	public function uploadFile(){
	    $uploaddir = './images/';
	   //\Log::info($_FILES);
		$urls=$this->generateUrlFile($_FILES);
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
	 	$upload_success=move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
		if ($upload_success) {
		   LogConsole::debug($urls);
		   return $this->jsonResponse($urls,false,true,false);
		} else {
			echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :\n";
			return \Response::json('error', 400);
		}
	}
	

	public function jsonResponse($param, $print = false, $header = true) {
		if (is_array($param)) {
			$out = array(
					'success' => true
			);
			if (array_key_exists('datas',$param) && is_array($param['datas']) ) {
				$out['datas'] = $param['datas'];
				unset($param['datas']);
				$out = array_merge($out, $param);
			} else {
				//\Log::info($param);
				$out['datas'] = $param;
			}
		}else if (is_bool($param)) {
			$out = array(
					'success' => $param
			);
		} else {
			$out = array(
					'success' => false,
					'errors' => array(
							'reason' => $param
					)
			);
		}
		$out = json_encode($out);
		if ($print) {
			if ($header) header('Content-type: application/json');
			echo $out;
			return;
		}
		return $out;
	}
}