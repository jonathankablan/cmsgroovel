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

namespace controllers\groovel\admin\antispam;
use Illuminate\Database\Eloquent\Model;
use controllers\groovel\admin\common\BaseController;


abstract class GroovelAntiSpamController extends BaseController  {

	
	public function checkRefererStatus($uriReferer){
		if ($_SERVER['HTTP_REFERER'] != $uriReferer){
		return false;
		}else return true;
	}
	
	public function checkTagsRulesStatus($string){
		// Pas de code de la forme <tag attr=XXX>texte</tag>
		$testHTML = preg_match("/<[^>]+>/", $string);
	
		// Pas de code de la forme [tag attr=XXX]
		$testTag= preg_match("/[[^>]+]/", $string);
	
		// pas de lien commençant par http://…
		$testURL = strstr($string, "http://");
	
		if(($testHTML || $testTag) || $testURL ){
			return false;
		}else return true;
	}
	
	public function checkPOSTStatus(){
		if(\Input::get('ctrl1')==\Input::get('ctrl1')&& $_POST['leave_blank']==""){
			return true;
		}
		else return false;
	}
	

}
