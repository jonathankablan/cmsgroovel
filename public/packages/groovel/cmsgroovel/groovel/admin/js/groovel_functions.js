  /** js for structure routes page**/
      $(function(){
          //Add, Save, Edit and Delete functions code
          $(".btnDeleteRoute").bind("click", DeleteRoute);
          $(".btnSaveRoute").bind("click", SaveRoute);
          $(".btnEditRoute").bind("click", EditRoute);
          $(".btnEditContent").bind("click", EditContent);
          $(".btnDeleteContent").bind("click",DeleteContent);
          $(".btnEditContentType").bind("click", EditContentType);
          $(".btnDeleteContentTypeElm").bind("click",DeleteContentTypeElm);
          $(".btnDeleteContentType").bind("click",DeleteContentType);
          $(".btnDeleteUser").bind("click", DeleteUser);
          $(".btnSaveUser").bind("click", SaveUser);
          $(".btnEditUser").bind("click", EditUser);
          $(".btnViewUser").bind("click",ViewUser);
          $(".btnEditUserPermission").bind("click", EditUserPermission);
          $(".btnDeleteUserPermission").bind("click",DeleteUserPermission);
          $(".btnDumpAutoloadPackage").bind("click",DumpAutoloadPackage);
          $(".btnUpdatePackage").bind("click",UpdatePackage);
          $(".btnInstallPackage").bind("click",InstallPackage);
          $(".btnArtisanCacheClear").bind("click",ArtisanCacheClear);
          $(".btnArtisanDumpAutoload").bind("click",ArtisanDumpAutoload);
          $(".btnEditUserProfile").bind("click",EditUserProfile);
          $(".btnActivateUser").bind("click",ActivateUser);
          $(".btnNotActivateUser").bind("click",NotActivateUser);
          $(".btnEditUserRole").bind("click",EditUserRole);
          $(".btnDeleteUserRole").bind("click",DeleteUserRole);
          $(".btnEditMessage").bind("click",EditMessage);
          $(".btnDeleteMessage").bind("click",DeleteMessage);
          $(".btnDeleteForum").bind("click",DeleteForum);
          $(".btnDeleteTopic").bind("click",DeleteTopic);
          $(".btnTranslateContent").bind("click",TranslateContent);
          
        });

/**encode url for json**/
function any2url(prefix, obj) {
      var args=new Array();
        if(typeof(obj) == 'object'){
            for(var i in obj)
                args[args.length]=any2url(prefix+'['+encodeURIComponent(i)+']', obj[i]);
        }
        else
            args[args.length]=prefix+'='+encodeURIComponent(obj);
        return args.join('&');
    }

String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g,"");
}

/**Table function utilities to add or remove rows in table**/
  function addRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[1].cells.length;
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[1].cells[i].innerHTML.trim().replace( new RegExp( "\>[\t]+\<" , "g" ) , "><" ); 
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                          
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
         }
 

  function deleteRow(tableID) {
      try {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++) {
          var row = table.rows[i];
          var chkbox = row.cells[0].childNodes[0];
          if(null != chkbox && true == chkbox.checked) {
        	  if(tableID!='table_user_permissions' && tableID!='table_user_system_permissions'){
	              if(rowCount <= 1) {
	                  alert("Cannot delete all the rows.");
	                  break;
	              }
        	  }else if(rowCount <= 2){
        		  break;
        	  }
              table.deleteRow(i);
              rowCount--;
              i--;
          }


      }
      }catch(e) {
          alert(e);
      }
  }
  
  
