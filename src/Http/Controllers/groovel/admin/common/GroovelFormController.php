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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\antispam\GroovelAntiSpamController;


abstract class GroovelFormController extends GroovelAntiSpamController  {

	public function validateForm($params){
		\Log::info('validate');
		if (!isset($_POST['leave_blank']) || $_POST['leave_blank']!="") {
			sleep(rand(2, 5)); // delay spammers a bit
			header("HTTP/1.0 403 Forbidden");
			exit;
		}
	}
	public abstract function processForm();
	
	public function checkToken(){
		if (\Session::token() != \Input::get('_token')) {
			throw new \Illuminate\Session\TokenMismatchException;
		}
	}
	
}
