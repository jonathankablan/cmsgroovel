
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

$target_dir = "uploads/";
$target_dir = $target_dir . basename( $_FILES["uploadFile"]["name"]);
$uploadOk=1;

// Check if file already exists
if (file_exists($target_dir . $_FILES["uploadFile"]["name"])) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($uploadFile_size > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Only GIF files allowed
if (!($uploadFile_type == "image/gif")) {
    echo "Sorry, only GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
        echo "The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
