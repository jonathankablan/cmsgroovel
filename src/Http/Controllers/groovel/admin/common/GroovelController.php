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
use Illuminate\Routing\Controller;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\antispam\GroovelAntiSpamController;


abstract class GroovelController extends GroovelAntiSpamController  {
	
	public function checkToken(){
		if (\Session::token() != \Input::get('_token')) {
			throw new \Illuminate\Session\TokenMismatchException;
		}
	}
	
	public function validateForm(){}

}
