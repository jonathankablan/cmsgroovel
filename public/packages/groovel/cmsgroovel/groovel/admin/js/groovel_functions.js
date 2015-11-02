  /** js for structure routes page**/
var generateFormTinyMCE=[];
      $(function(){
          //Add, Save, Edit and Delete functions code
        //  $(".btnEdit").bind("click", Edit);
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

   
var langages=new Array();
langages['FR']='France';
langages['GB']='United Kingdom';
langages['US']='United States';

  function DeleteRoute(){
    var thArray = $("#table_routes thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_route');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                   //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_route').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
   //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/admin/routes/delete",
                 success: function(data) {
                    // alert(data);
                    alert('route deleted successfull');
                    ////console.log(data.status);
                    ////console.log(data.errors);
                },
                error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
       var par = $(this).parent().parent(); //tr
       par.remove();
 }; 


  function SaveRoute(){
  var thArray = $("#table_routes thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_route');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    // //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_route').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
    //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/admin/routes/update",
                 success: function(data) {
                    // alert(data);
                    alert('route saved successfull');
                   // //console.log(data.status);
                   // //console.log(data.errors);
                },
                error: function(xhr, textStatus, thrownError) {
                    alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
  }

  
  function EditRoute(){
	  var thArray = $("#table_routes thead tr").map(function(index,elem) {
	                var ret = [];
	                var x = $(this);
	                var cells = x.find('th#col_route');
	                $(cells, this).each(function () {
	                    var d = $(this).val()||$(this).text();
	                    // //console.log(d);
	                    ret.push(d);
	                });
	                return ret;
	              });

	    var tdArray=new Array();
	    var parent=$(this).parent().parent();
	        $(parent).children('td#row_route').each(function(i,td) {
	            tdArray.push($(this).text());
	        });

	    var inputData = new Array();
	    for (i = 0; i < thArray.length; i++){ 
	         inputData[thArray[i]]=tdArray[i];
	    }
	    //console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "/admin/routes/edit",
	                 success: function(data) {
	                	 //console.log(data);
	                     var parsed = JSON.parse(data);
	                     //console.log(parsed.datas.uri);
	                     window.location.href = parsed.datas.uri;
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
	  }

  
  
  
  
  
/**encode url for json**/
function any2url(prefix, obj) {
      var args=new Array();
        if(typeof(obj) == 'object'){
            for(var i in obj)
                args[args.length]=any2url(prefix+'['+encodeURIComponent(i)+']', obj[i]);
        }
        else
            args[args.length]=prefix+'='+encodeURIComponent(obj);
        //   //console.log(args);
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
              //console.log(rowCount);
              table.deleteRow(i);
              rowCount--;
              i--;
          }


      }
      }catch(e) {
          alert(e);
      }
  }
  
  
  


var pleaseWaitDiv =$('#pleaseWaitDialog');
var timer=null;
function modifValues(){
  var bar = $('#progress-bar');
  var val = bar.width();
  var newVal = val+20;
  bar.css('width',newVal);
}

function showContentType(str,url){
	
	var pleaseWaitDiv = $('#pleaseWaitDialog');
	var bar = $('#progress-bar');
	bar.css('width',0);
	if(str!='NULL'){
		pleaseWaitDiv.modal('show'); 
		timer=setInterval(function(){ modifValues(); },1000);
	}
	
    $.ajax({
                type: 'get',
                data : any2url('q',str),
                dateType:'json',
                url: url,
                 success: function(data) {
                   //   $('#test').empty();
                	 var parsed = JSON.parse(data);
                	  if(parsed.datas[0].length!=0){
                		  setDataJSON(data,url);	
                	  }
                	  
                	
                },
                error: function(xhr, textStatus, thrownError) {
                   //console.log(thrownError);
                    alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
  }

fileEvents = function() {
	var fileInput  = document.querySelector( ".input-file" ),    
    button     = document.querySelector( ".input-file-trigger" ),  
    the_return = document.querySelector(".file-return");  
	if(button!=null){
		button.addEventListener( "keydown", function( event ) {  
			    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
			        fileInput.focus();  
			    }  
			});
		   
		// action lorsque le label est cliqué  
		button.addEventListener( "click", function( event ) {  
		   fileInput.focus();  
		   return false;  
		});  
	}
	if(fileInput!=null){
		// affiche un retour visuel dès que input:file change  
		fileInput.addEventListener( "change", function( event ) {    
		   // the_return.innerHTML = this.value;    
			   fileSelect('my-file');
			   
		});  
	}
}


function setDataJSON(req,url)
{

  var parsed = JSON.parse(req);
  var my_form= document.getElementById('content_form');
  document.getElementById('content_form').innerHTML='';
  my_form.name='myForm';
  my_form.method='POST';
  my_form.action=url.replace('form/view_update','add');
  
  sidebarHead = document.createElement('div');
  sidebarHead.style = "margin-top:30px;margin-bottom:15px;width:100%;height:60px;background-color: #98FB98;";
  p=document.createElement('p');
  p.style.color='black';
  p.innerHTML='General settings';
  p.style='margin-left:350px';
//  form_group.appendChild(p);
  sidebarHead.appendChild(p);
  my_form.appendChild( sidebarHead);

  form_group1 = document.createElement('div');
  form_group1.className = "form-group form-inline";
  form_group1.style="margin-top:50px";
  var label1='<label for=\'title\' class="required">Title</label>';
  form_group1.innerHTML=label1;

  input1=document.createElement('input');
  input1.type='text';
  input1.name='title';
  input1.style='margin-left:115px;margin-bottom:0px;width:350px;height:30px';
  input1.className="form-control";
  form_group1.appendChild(input1); 
  my_form.appendChild(form_group1); 
  
  form_group2 = document.createElement('div');
  form_group2.className = "form-group form-inline";  
  form_group2.style="margin-top:50px"
  var label2='<label for=\'url\' class="required">url</label>';
  form_group2.innerHTML=label2;
  input2=document.createElement('input');
  input2.type='text';
  input2.name='url';
  input2.style='margin-left:125px;margin-bottom:0px;width:350px;height:30px';
  input2.className="form-control form-inline";
  form_group2.appendChild(input2); 
  my_form.appendChild(form_group2); 

  form_group3 = document.createElement('div');
  form_group3.className = "form-group form-inline";
  form_group3.style="margin-top:50px";
  var label3='<label for=\'groovelDescription\' class="required">groovelDescription</label>';
  form_group3.innerHTML=label3;

  input3=document.createElement('input');
  input3.type='text';
  input3.name='groovelDescription';
  input3.style='margin-left:25px;margin-bottom:0px;width:350px;height:30px';
  input3.className="form-control";
  form_group3.appendChild(input3); 
  my_form.appendChild(form_group3); 
  
  form_group4 = document.createElement('div');
  form_group4.className = "form-group form-inline";
  form_group4.style="margin-top:50px";
  var label4='<label for=\'langage\' class="required">langage</label>';
  form_group4.innerHTML=label4;

   
  var input4 = document.createElement("select");
  input4.id = "langage";
  input4.name= "langage";
  input4.style='margin-left:95px;margin-bottom:0px;width:350px;height:30px';
  input4.className="form-control";
  
  //Create and append the options
  for(var key in langages){
      var option = document.createElement("option");
      option.value = key;
      option.text = langages[key];
      input4.appendChild(option);
  }
  form_group4.appendChild(input4); 
  my_form.appendChild(form_group4); 
 
  
  
  
  sidebarIntro = document.createElement('div');
  sidebarIntro.style = "margin-top:40px;margin-bottom:40px;width:100%;height:60px;background-color: #98FB98;";
  p=document.createElement('p');
  p.style.color='black';
  p.innerHTML='Content';
  p.style='margin-left:350px';
//  form_group.appendChild(p);
  sidebarIntro.appendChild(p);
  my_form.appendChild( sidebarIntro);
  
  input=document.createElement('input');
  input.type='hidden';
  input.name='ContentType';
  input.value=parsed.datas[0][0]['tableName']
  input.id=parsed.datas[0][0]['tableName'];
  my_form.appendChild(input);
 
  var fiedTinyMCE = new Array();
  var numberFieldTinyMCE=0;
  var required='required';
  var lastInputid=null;
  var sidebar=null;
  for (var i=0;i<parsed.datas.length;i++)
    {
      for( var j=0;j<parsed.datas[i].length;j++){
         if(parsed.datas[i][j]['type']=='string'){
        
          form_group = document.createElement('div');
          form_group.className = "form-group form-inline";
	      if (parsed.datas[i][j]['widget']=='11'){
	          form_group.style='margin-left:150px'
	      	}
          form_group.id=parsed.datas[i][j]['name'];
          var label=null;
      
	      if(parsed.datas[i][j]['required']=='0'){
	          label='<label for='+parsed.datas[i][j]['name'] +' style="width:100px"'+'>'+parsed.datas[i][j]['name']+'</label>';
	         }else{
	          label='<label for='+parsed.datas[i][j]['name'] +' class='+required +' style="width:150px"'+'>'+parsed.datas[i][j]['name']+'</label>';
	      }
	      
	     if (parsed.datas[i][j]['widget']!='11'){ 
	          form_group.innerHTML=label;
         }else{
        	 form_group_label = document.createElement('div');
        	 form_group_label.className = "form-group form-inline";
        	 form_group_label.innerHTML=label;
        	 my_form.appendChild(form_group_label);   
         }
	     
	      input=document.createElement('textarea');
          input.name=parsed.datas[i][j]['name'];
          input.className = "form-control form-inline";
          input.id=parsed.datas[i][j]['name'];
          
          	if (parsed.datas[i][j]['widget']=='11'){//editor html tinyMCE
	      		fiedTinyMCE[numberFieldTinyMCE]=parsed.datas[i][j]['name'];
          	    numberFieldTinyMCE++;
 	        }else{
	        	 input=document.createElement('textarea');
	             input.type='text';
	             if(parsed.datas[i][j]['required']=='0'){
	             input.style='width:350px;margin-left:50px';
	             }else{
	            	 input.style='width:350px';
	             }
	             input.name=parsed.datas[i][j]['name'];
	             input.value='';
	             input.className = "form-control form-inline";

	        }
          	 form_group.appendChild(input);
          	 my_form.appendChild(form_group);        
	          document.body.appendChild(my_form);
	          document.getElementById('form-modal').appendChild(my_form);
	          lastInputid=input.id;
        }
        else if (parsed.datas[i][j]['type']=='double' || parsed.datas[i][j]['type']=='integer'){
          form_group = document.createElement('div');
          form_group.className = "form-group form-inline";
          form_group.style='width:550px;margin-top:50px';
          var label=null;
          if(parsed.datas[i][j]['required']=='0'){
              label='<label for='+parsed.datas[i][j]['name'] +' style="width:150px"'+'>'+parsed.datas[i][j]['name']+'</label>';
             }else{
              label='<label for='+parsed.datas[i][j]['name'] +' class='+required +' style="width:150px"'+'>'+parsed.datas[i][j]['name']+'</label>';
          }
          form_group.innerHTML=label;

          input=document.createElement('input');
          input.type='double';
          input.name=parsed.datas[i][j]['name'];
          input.value='';
          input.className = "form-control";
          input.style='margin-left:115px';
          input.id=parsed.datas[i][j]['name'];

          form_group.appendChild(input);

          my_form.appendChild(form_group);        
          document.body.appendChild(my_form);
          document.getElementById('form-modal').appendChild(my_form);
          lastInputid=input.id;

        }else if (parsed.datas[i][j]['widget']=='12'){//send files
        	sidebar='not null';
        	//$("#content_form").load("file/upload/widget");
        	  $.ajax({
	                type: 'get',
	                data :"",
	                dateType:'json',
	                url: "file/upload/widget",
	                 success: function(data) {
	                     //var parsed = JSON.parse(data);
	                    // //console.log(data.html);form_group =document.createElement('div');
	                	 form_group_label =document.createElement('div');
	                     form_group_label.className = "form-group";
	                     var label1='<label for=\'files\'>Files Attachements</label>';
	                     form_group_label.innerHTML=label1;
	                     my_form.appendChild(form_group_label);
	                	 
	                     form_group =document.createElement('div');
	                     form_group.className = "form-group form-inline";
	                     form_group.style='margin-left:250px';
	                     form_group.innerHTML=data.html;
	                     //form_group.innerHTML=label1;
	                     my_form.appendChild(form_group);   
	                     document.body.appendChild(my_form);
	                     document.getElementById('form-modal').appendChild(my_form);
	                     fileEvents();
	             		//$("#loading").hide();
	                     //add sidebar
	                     sidebar = document.createElement('div');
	                     sidebar.style = "margin-top:30px;margin-bottom:15px;width:100%;height:60px;background-color: #98FB98;";
	                     p=document.createElement('p');
	                     p.style.color='black';
	                     p.innerHTML='Optional settings';
	                     p.style='margin-left:300px';
	                   //  form_group.appendChild(p);
	                     sidebar.appendChild(p);
	                     my_form.appendChild( sidebar);
	                     //select publish, ontop
	                     form_group = document.createElement('div');
	                     form_group.className = "form-group";
	                     form_group.style='margin-left:50px;margin-top:70px;margin-bottom:75px';
	                     var label='<label for='+'isPublish' +' style="font-size: 20px">Publish</label>';
	                     form_group.innerHTML=label;
	                     input=document.createElement('input');
	                     input.type='checkbox';
	                     input.name='isPublish';
	                     input.value='';
	                     input.style='margin-left:175px';
	                     input.id='isPublish';
	                     form_group.appendChild(input);
	                     my_form.appendChild(form_group);
	                     
	                     form_group = document.createElement('div');
	                     form_group.className = "form-group";
	                     form_group.style='margin-left:50px';
	                     var label='<label for='+'isTopPublish' +' style="font-size: 20px">First position</label>';
	                     form_group.innerHTML=label;
	                     input=document.createElement('input');
	                     input.type='checkbox';
	                     input.name='isTopPublish';
	                     input.value='';
	                     input.style='margin-left:130px';
	                     input.id='isTopPublish';
	                     form_group.appendChild(input);
	                     
	                     my_form.appendChild(form_group);
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            }); 
         }
      }
    }
    
    for(var i=0;i<numberFieldTinyMCE;i++){
    	generateFormTinyMCE.push(fiedTinyMCE[i]);
    }
     //$('#modal').modal('show');
    if(sidebar==null){
	    sidebar = document.createElement('div');
	    sidebar.style = "margin-top:30px;margin-bottom:15px;width:100%;height:60px;background-color: #98FB98;";
	    p=document.createElement('p');
	    p.style.color='black';
	    p.innerHTML='Optional settings';
	    p.style='margin-left:300px';
	  //  form_group.appendChild(p);
	    sidebar.appendChild(p);
	    my_form.appendChild( sidebar);
	    
	    //select publish, ontop
	    form_group = document.createElement('div');
	    form_group.className = "form-group";
	    form_group.style='margin-left:50px;margin-top:70px;margin-bottom:75px';
	    var label='<label for='+'isPublish' +' style="font-size: 20px">Publish</label>';
	    form_group.innerHTML=label;
	    input=document.createElement('input');
	    input.type='checkbox';
	    input.name='isPublish';
	    input.value='';
	    input.style='margin-left:175px';
	    input.id='isPublish';
	    form_group.appendChild(input);
	    my_form.appendChild(form_group);
	    
	    form_group = document.createElement('div');
	    form_group.className = "form-group";
	    form_group.style='margin-left:50px';
	    var label='<label for='+'isTopPublish' +' style="font-size: 20px">First position</label>';
	    form_group.innerHTML=label;
	    input=document.createElement('input');
	    input.type='checkbox';
	    input.name='isTopPublish';
	    input.value='';
	    input.style='margin-left:130px';
	    input.id='isTopPublish';
	    form_group.appendChild(input);
	    
	    my_form.appendChild(form_group);
    }
   
    
    setTimeout(function() {
    	clearInterval(timer);
    	$('#pleaseWaitDialog').modal('hide');
    	$('#modal').modal('show');
    	var bar = $('#progress-bar');
      	bar.css('width',0);
      }, 5000); // milliseconds
    
}



$(document).on('hide.bs.modal', function () {
    tinyMCE.editors=[];
    });

$(document).on('shown.bs.modal', function(e) {
for(var i=0;i<generateFormTinyMCE.length;i++){
	//console.log('ici');
	var selector=generateFormTinyMCE[i];
	var sel= document.getElementById(selector);
	////console.log(sel);
    //var sel2=$('textarea#'+selector);
    ////console.log(sel2);
	if(sel!=null){
	 sel.focus();
	eval (tinymce.init({
	    selector: "textarea#"+generateFormTinyMCE[i],
		    theme: "modern",
		    width: 600,
		    height: 300,
		    entity_encoding : "raw",
		    mode : "exact",
		    file_browser_callback : function GroovelFileBrowser (field_name, url, type, win) {
         var cmsURL = window.location.toString()+'/file/browser';    // script URL - use an absolute path!
         tinyMCE.activeEditor.windowManager.open({
		            file : cmsURL,
		            title : 'Groovel File Browser',
		            width : 420,  // Your dimensions may differ - toy around with them!
		            height : 400,
		            resizable : "yes",
		            inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
		            close_previous : "no"
		        }, {
		            window : win,
		            input : field_name
		        });
		         return false;
		      },
		        
		    plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
		         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		         "save contextmenu directionality emoticons template paste textcolor"
		   ],
		   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
		   style_formats: [
		        {title: 'Bold text', inline: 'b'},
		        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		        {title: 'Example 1', inline: 'span', classes: 'example1'},
		        {title: 'Example 2', inline: 'span', classes: 'example2'},
		        {title: 'Table styles'},
		        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		    ]
		 })
	 )
	}
}	

////console.log(newVal);
//clearInterval(timer);
//incjauge=5;
//doc=document.getElementById('progress');
//doc.innerHTML="";
//var pleaseWaitDiv = $('Processing');
////console.log(pleaseWaitDiv);
//pleaseWaitDiv.modal('hide'); 
; 
});





/**function edit content **/

  function EditContent(){
  var thArray = $("#table_contents thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_content');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                   // //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_content').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
    //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                dateType:'json',
                url: "content/edit",
                 success: function(data) {
                    // alert(data);
                   // alert('edit saved successfull');
                    //console.log(data);
                     var parsed = JSON.parse(data);
                     //console.log(parsed.datas.uri);
                     window.location.href = parsed.datas.uri;
                },
                error: function(xhr, textStatus, thrownError) {
                    alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
  }

  /**function delete content **/

  function DeleteContent(){
    var thArray = $("#table_contents thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_content');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    // //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_content').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
    //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "content/delete",
                 success: function(data) {
                    // alert(data);
                    alert('content deleted successfull');
                 },
                error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
       var par = $(this).parent().parent(); //tr
       par.remove();
 }; 

 
 
 
 
 /**function edit contentType **/

 function EditContentType(){
 var thArray = $("#table_contents thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_content');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                  // //console.log(d);
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_content').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               dateType:'json',
               url: "content_type/edit",
                success: function(data) {
                  var parsed = JSON.parse(data);
                  window.location.href = parsed.datas.uri;
               },
               error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
 }

 /**function delete contentType fields or contenttype element**/

 function DeleteContentTypeElm(){
   var thArray = $("#table_content_types thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_content');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
   $(parent).children('td#row_content').children('input').each(function(i,td) {
           tdArray.push($(this).val());
   });

   var inputData = null;
   for (i = 0; i < thArray.length; i++){
	   if(thArray[i]='FieldName'){
        inputData=tdArray[i];
        break;
	   }
	  
   }
   
   //console.log(any2url('q',inputData));
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "content_type/fields/delete",
                success: function(data) {
                   // alert(data);
                   alert('field deleted successfully');
                   ////console.log(data.status);
                   ////console.log(data.errors);
               },
               error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
      var par = $(this).parent().parent(); //tr
      par.remove();
}; 

function deleteRowContentType(tableID) {
    try {
    	var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
        //console.log(rowCount);   
		    for(var i=0; i<rowCount; i++) {
		        var row = table.rows[i];
		        var chkbox = row.cells[0].firstElementChild;
		        if(null != chkbox && true == chkbox.checked) {
		            if(rowCount <= 1) {
		                alert("Cannot delete all the rows.");
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

function DeleteContentType(){
    var thArray = $("#table_contents thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_content');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    // //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_content').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
    //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "content_type/delete",
                 success: function(data) {
                   //console.log(data);
                   var parsed = JSON.parse(data);
                   if(parsed['success']){
                       alert('content type deleted successfull');
                    }
                    else if(parsed['success']==false){
                	   alert(parsed['errors']['reason']);
                   }
                },
                error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
       var par = $(this).parent().parent(); //tr
       par.remove();
 }; 


 function DeleteUser(){
   var thArray = $("#table_users thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   // //console.log(d);
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   //console.log(any2url('q',inputData));
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "user/delete",
                success: function(data) {
                   // alert(data);
                   alert('user deleted successfull');
                   //console.log(data.status);
                   //console.log(data.errors);
               },
               error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
      var par = $(this).parent().parent(); //tr
      par.remove();
}; 


 function SaveUser(){
 var thArray = $("#table_users thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   // //console.log(d);
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   //console.log(any2url('q',inputData));
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "user/update",
                success: function(data) {
                   alert('user saved successfull');
               },
               error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
 }

 
 function EditUser(){
	  var thArray = $("#table_users thead tr").map(function(index,elem) {
	                var ret = [];
	                var x = $(this);
	                var cells = x.find('th#col_user');
	                $(cells, this).each(function () {
	                    var d = $(this).val()||$(this).text();
	                    // //console.log(d);
	                    ret.push(d);
	                });
	                return ret;
	              });

	    var tdArray=new Array();
	    var parent=$(this).parent().parent();
	        $(parent).children('td#row_user').each(function(i,td) {
	            tdArray.push($(this).text());
	        });

	    var inputData = new Array();
	    for (i = 0; i < thArray.length; i++){ 
	         inputData[thArray[i]]=tdArray[i];
	    }
	    
	    //console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "user/edit",
	                 success: function(data) {
	                	 //console.log(data);
	                     var parsed = JSON.parse(data);
	                     //console.log(parsed.datas.uri);
	                     window.location.href = parsed.datas.uri;
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
	  }

 
 

 function DeleteUserPermission(){
   var thArray = $("#table_users_permissions thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_user');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                   // //console.log(d);
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_user').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   //console.log(any2url('q',inputData));
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               url: "delete/permission",
                success: function(data) {
                   // alert(data);
                   alert('permission deleted successfull');
                   //console.log(data.status);
                   //console.log(data.errors);
               },
               error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
      var par = $(this).parent().parent(); //tr
      par.remove();
}; 
 



function EditUserPermission(){
	  var thArray = $("#table_users_permissions thead tr").map(function(index,elem) {
	                var ret = [];
	                var x = $(this);
	                var cells = x.find('th#col_user');
	                $(cells, this).each(function () {
	                    var d = $(this).val()||$(this).text();
	                    // //console.log(d);
	                    ret.push(d);
	                });
	                return ret;
	              });

	    var tdArray=new Array();
	    var parent=$(this).parent().parent();
	        $(parent).children('td#row_user').each(function(i,td) {
	            tdArray.push($(this).text());
	        });

	    var inputData = new Array();
	    for (i = 0; i < thArray.length; i++){ 
	         inputData[thArray[i]]=tdArray[i];
	    }
	    //console.log('ici edit user perm');
		
	    //console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "permission/edit",
	                 success: function(data) {
	                	 //console.log(data);
	                     var parsed = JSON.parse(data);
	                     //console.log(parsed.datas.uri);
	                     window.location.href = parsed.datas.uri;
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
	  }



function UpdatePackage(){
	//console.log('updatePackage');
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			////console.log(d);
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'update';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			// alert(data);
			alert('package has been updated');
			// //console.log(data.status);
			// //console.log(data.errors);
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}

function DumpAutoloadPackage() {
	//console.log('dumpAutoloadPackage');
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			////console.log(d);
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'dump-autoload';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			// alert(data);
			alert('package has been refresh');
			// //console.log(data.status);
			// //console.log(data.errors);
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});

}
function removePackage(){
	
	
	
}

function InstallPackage(){
	//console.log('InstallPackage');
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			////console.log(d);
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'install';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			// alert(data);
			alert('package has been installed');
			// //console.log(data.status);
			// //console.log(data.errors);
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}



function ArtisanCacheClear(){
	//console.log('ArtisanCacheClear');
	
	var inputData = new Array();
	inputData['function'] = 'artisan-cache-clear';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			// alert(data);
			alert('cache has been cleared');
			// //console.log(data.status);
			// //console.log(data.errors);
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
}


function ArtisanDumpAutoload(){
	//console.log('ArtisanDumpAutoload');
	var inputData = new Array();
	inputData['function'] = 'artisan-dump-autoload';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			// alert(data);
			alert('artisan dump autoload done');
			// //console.log(data.status);
			// //console.log(data.errors);
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}


function ViewUser(){
	//console.log('View user');
	  var thArray = $("#table_users thead tr").map(function(index,elem) {
          var ret = [];
          var x = $(this);
          var cells = x.find('th#col_user');
          $(cells, this).each(function () {
              var d = $(this).val()||$(this).text();
              // //console.log(d);
              ret.push(d);
          });
          return ret;
        });

var tdArray=new Array();
var parent=$(this).parent().parent();
  $(parent).children('td#row_user').each(function(i,td) {
      tdArray.push($(this).text());
  });

var inputData = new Array();
for (i = 0; i < thArray.length; i++){ 
   inputData[thArray[i]]=tdArray[i];
}
//console.log(any2url('q',inputData));
$.ajax({
          type: 'get',
          data : any2url('q',inputData),
          url: "user/view",
           success: function(data) {
          //	 //console.log(data);
               var parsed = JSON.parse(data);
               //console.log(parsed.datas.uri);
               window.location.href = parsed.datas.uri;
          },
          error: function(xhr, textStatus, thrownError) {
              alert(thrownError);
              alert('Something went to wrong.Please Try again later...');
          }
         
      });
	
}



function EditUserProfile(){
//	//console.log('user profile');
//	//console.log( document.getElementById('user'));
	id=document.getElementById('user').value;
	var inputData = new Array();
	inputData['id']=id;
	//inputData['user']='test';
	//console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "profile/edit",
	                 success: function(data) {
	                	 //console.log(data);
	                    var parsed = JSON.parse(data);
	                     //console.log(parsed.datas.uri);
	                     window.location.href = parsed.datas.uri;
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
}


function ActivateUser(){
	 var thArray = $("#table_users thead tr").map(function(index,elem) {
         var ret = [];
         var x = $(this);
         var cells = x.find('th#col_user');
         $(cells, this).each(function () {
             var d = $(this).val()||$(this).text();
             // //console.log(d);
             ret.push(d);
         });
         return ret;
       });

		var tdArray=new Array();
		var parent=$(this).parent().parent();
		 $(parent).children('td#row_user').each(function(i,td) {
		     tdArray.push($(this).text());
		 });
		
		var inputData = new Array();
		for (i = 0; i < thArray.length; i++){ 
		  inputData[thArray[i]]=tdArray[i];
		}
	//console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "user/activate",
	                 success: function(data) {
	                	alert('done');
	                    var parsed = JSON.parse(data);
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
}

function NotActivateUser(){
	 var thArray = $("#table_users thead tr").map(function(index,elem) {
         var ret = [];
         var x = $(this);
         var cells = x.find('th#col_user');
         $(cells, this).each(function () {
             var d = $(this).val()||$(this).text();
             // //console.log(d);
             ret.push(d);
         });
         return ret;
       });

		var tdArray=new Array();
		var parent=$(this).parent().parent();
		 $(parent).children('td#row_user').each(function(i,td) {
		     tdArray.push($(this).text());
		 });
		
		var inputData = new Array();
		for (i = 0; i < thArray.length; i++){ 
		  inputData[thArray[i]]=tdArray[i];
		}
	//console.log(any2url('q',inputData));
	    $.ajax({
	                type: 'get',
	                data : any2url('q',inputData),
	                url: "user/notactivate",
	                 success: function(data) {
	                	 alert('done');
	                    var parsed = JSON.parse(data);
	                },
	                error: function(xhr, textStatus, thrownError) {
	                    alert(thrownError);
	                    alert('Something went to wrong.Please Try again later...');
	                }
	               
	            });
}



function EditUserRole(){
var thArray = $("#table_users thead tr").map(function(index,elem) {
              var ret = [];
              var x = $(this);
              var cells = x.find('th#col_user');
              $(cells, this).each(function () {
                  var d = $(this).val()||$(this).text();
                 // //console.log(d);
                  ret.push(d);
              });
              return ret;
            });

  var tdArray=new Array();
  var parent=$(this).parent().parent();
      $(parent).children('td#row_user').each(function(i,td) {
          tdArray.push($(this).text());
      });

  var inputData = new Array();
  for (i = 0; i < thArray.length; i++){ 
       inputData[thArray[i]]=tdArray[i];
  }
  
  //console.log(any2url('q',inputData));
  $.ajax({
              type: 'get',
              data : any2url('q',inputData),
              dateType:'json',
              url: "role/edit",
               success: function(data) {
                   var parsed = JSON.parse(data);
                   //console.log(parsed.datas.uri);
                   window.location.href = parsed.datas.uri;
              },
              error: function(xhr, textStatus, thrownError) {
                  alert(thrownError);
                  alert('Something went to wrong.Please Try again later...');
              }
             
          });
}


function DeleteUserRole(){
	var thArray = $("#table_users thead tr").map(function(index,elem) {
	              var ret = [];
	              var x = $(this);
	              var cells = x.find('th#col_user');
	              $(cells, this).each(function () {
	                  var d = $(this).val()||$(this).text();
	                 // //console.log(d);
	                  ret.push(d);
	              });
	              return ret;
	            });

	  var tdArray=new Array();
	  var parent=$(this).parent().parent();
	      $(parent).children('td#row_user').each(function(i,td) {
	          tdArray.push($(this).text());
	      });

	  var inputData = new Array();
	  for (i = 0; i < thArray.length; i++){ 
	       inputData[thArray[i]]=tdArray[i];
	  }
	  
	  //console.log(any2url('q',inputData));
	  $.ajax({
	              type: 'get',
	              data : any2url('q',inputData),
	              dateType:'json',
	              url: "user/role/edit",
	               success: function(data) {
	                  // alert(data);
	                 // alert('edit saved successfull');
	                  //console.log(data);
	                   var parsed = JSON.parse(data);
	                   //console.log(parsed.datas.uri);
	                   window.location.href = parsed.datas.uri;
	              },
	              error: function(xhr, textStatus, thrownError) {
	                  alert(thrownError);
	                  alert('Something went to wrong.Please Try again later...');
	              }
	             
	          });
	}

function DeleteMessage(){
    var thArray = $("#table_messages thead tr").map(function(index,elem) {
                var ret = [];
                var x = $(this);
                var cells = x.find('th#col_message');
                $(cells, this).each(function () {
                    var d = $(this).val()||$(this).text();
                    // //console.log(d);
                    ret.push(d);
                });
                return ret;
              });

    var tdArray=new Array();
    var parent=$(this).parent().parent();
        $(parent).children('td#row_message').each(function(i,td) {
            tdArray.push($(this).text());
        });

    var inputData = new Array();
    for (i = 0; i < thArray.length; i++){ 
         inputData[thArray[i]]=tdArray[i];
    }
    
    //console.log(any2url('q',inputData));
    $.ajax({
                type: 'get',
                data : any2url('q',inputData),
                url: "/messages/delete",
                 success: function(data) {
                    // alert(data);
                    alert('message deleted successfull');
                    //console.log(data.status);
                    //console.log(data.errors);
                },
                error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
       var par = $(this).parent().parent(); //tr
       par.remove();
 }; 
 
 

 function EditMessage(){
 var thArray = $("#table_messages thead tr").map(function(index,elem) {
               var ret = [];
               var x = $(this);
               var cells = x.find('th#col_message');
               $(cells, this).each(function () {
                   var d = $(this).val()||$(this).text();
                  // //console.log(d);
                   ret.push(d);
               });
               return ret;
             });

   var tdArray=new Array();
   var parent=$(this).parent().parent();
       $(parent).children('td#row_message').each(function(i,td) {
           tdArray.push($(this).text());
       });

   var inputData = new Array();
   for (i = 0; i < thArray.length; i++){ 
        inputData[thArray[i]]=tdArray[i];
   }
   
   //console.log(any2url('q',inputData));
   $.ajax({
               type: 'get',
               data : any2url('q',inputData),
               dateType:'json',
               url: "/messages/edit",
                success: function(data) {
                    var parsed = JSON.parse(data);
                    //console.log(parsed.datas.uri);
                    window.location.href = parsed.datas.uri;
               },
               error: function(xhr, textStatus, thrownError) {
                   alert(thrownError);
                   alert('Something went to wrong.Please Try again later...');
               }
              
           });
 }

 function DeleteForum(){
	   var thArray = $("#table_forums thead tr").map(function(index,elem) {
	               var ret = [];
	               var x = $(this);
	               var cells = x.find('th#col_forum');
	               $(cells, this).each(function () {
	                   var d = $(this).val()||$(this).text();
	                   // //console.log(d);
	                   ret.push(d);
	               });
	               return ret;
	             });

	   var tdArray=new Array();
	   var parent=$(this).parent().parent();
	       $(parent).children('td#row_forum').each(function(i,td) {
	           tdArray.push($(this).text());
	       });

	   var inputData = new Array();
	   for (i = 0; i < thArray.length; i++){ 
	        inputData[thArray[i]]=tdArray[i];
	   }
	   
	   //console.log(any2url('q',inputData));
	   $.ajax({
	               type: 'get',
	               data : any2url('q',inputData),
	               url: "/forum/delete",
	                success: function(data) {
	                   // alert(data);
	                 
	                   var parsed = JSON.parse(data);
	                   if(parsed['success']==false){
	                	   alert(parsed['errors']['reason']);
	                   }else{
	                	   alert('forum has been deleted');
	                   }
	                
	               },
	               error: function(xhr, textStatus, thrownError) {
	                  alert(thrownError);
	                   alert('Something went to wrong.Please Try again later...');
	               }
	              
	           });
	      var par = $(this).parent().parent(); //tr
	      par.remove();
	}; 

	
	function DeleteTopic(){
		   var thArray = $("#table_topics thead tr").map(function(index,elem) {
		               var ret = [];
		               var x = $(this);
		               var cells = x.find('th#col_topic');
		               $(cells, this).each(function () {
		                   var d = $(this).val()||$(this).text();
		                   // //console.log(d);
		                   ret.push(d);
		               });
		               return ret;
		             });

		   var tdArray=new Array();
		   var parent=$(this).parent().parent();
		       $(parent).children('td#row_topic').each(function(i,td) {
		           tdArray.push($(this).text());
		       });

		   var inputData = new Array();
		   for (i = 0; i < thArray.length; i++){ 
		        inputData[thArray[i]]=tdArray[i];
		   }
		   
		   //console.log(any2url('q',inputData));
		   $.ajax({
		               type: 'get',
		               data : any2url('q',inputData),
		               url: "/forum/topic/delete",
		                success: function(data) {
		                   // alert(data);
		                 
		                   var parsed = JSON.parse(data);
		                   if(parsed['success']==false){
		                	   alert(parsed['errors']['reason']);
		                   }else{
		                	   alert('topic has been deleted');
		                   }
		                
		               },
		               error: function(xhr, textStatus, thrownError) {
		                  alert(thrownError);
		                   alert('Something went to wrong.Please Try again later...');
		               }
		              
		           });
		      var par = $(this).parent().parent(); //tr
		      par.remove();
		}; 


		
		/**function translate content in a new langage **/

		  function TranslateContent(){
		  var thArray = $("#table_contents thead tr").map(function(index,elem) {
		                var ret = [];
		                var x = $(this);
		                var cells = x.find('th#col_content');
		                $(cells, this).each(function () {
		                    var d = $(this).val()||$(this).text();
		                   // //console.log(d);
		                    ret.push(d);
		                });
		                return ret;
		              });

		    var tdArray=new Array();
		    var parent=$(this).parent().parent();
		        $(parent).children('td#row_content').each(function(i,td) {
		            tdArray.push($(this).text());
		        });

		    var inputData = new Array();
		    for (i = 0; i < thArray.length; i++){ 
		         inputData[thArray[i]]=tdArray[i];
		    }
		    
		    //console.log(any2url('q',inputData));
		    $.ajax({
		                type: 'get',
		                data : any2url('q',inputData),
		                dateType:'json',
		                url: "content/translate",
		                 success: function(data) {
		                    // alert(data);
		                   // alert('edit saved successfull');
		                    //console.log(data);
		                     var parsed = JSON.parse(data);
		                     //console.log(parsed.datas.uri);
		                     window.location.href = parsed.datas.uri;
		                },
		                error: function(xhr, textStatus, thrownError) {
		                    alert(thrownError);
		                    alert('Something went to wrong.Please Try again later...');
		                }
		               
		            });
		  }
