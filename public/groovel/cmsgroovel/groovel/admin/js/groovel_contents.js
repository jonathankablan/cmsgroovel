
var generateFormTinyMCE=[];
var pleaseWaitDiv =$('#pleaseWaitDialog');
var timer=null;
function modifValues(){
  var bar = $('#progress-bar');
  var val = bar.width();
  var newVal = val+20;
  bar.css('width',newVal);
}

//open a modal window other another
$(document).ready(function (){
	$('#popupModal').on('show.bs.modal', function() {
	 	  	$('#modal').css('opacity', 0.2);
	 	  	$('#modal').css({zIndex: 1040})
	});
	
	$('#popupModal').on('hide.bs.modal', function() {
		 	$('#modal').css('opacity', 1);
	});
})


function validateContent(form){
var ajax=	$.ajax({
		  type: 'POST',
		  url:'/admin/content/validate',
		  data: form,
		  async:false,
		  success:function(data) {
			var parsed=JSON.parse(data);
			  if(parsed['success']==true){
				  $("#error").empty();
		    	  return true;
              }
               else if(parsed['success']==false){
                  $("#alertmsg").css("color","red");
                  $("#alertmsg").text(parsed['errors']['reason']);
                  $("#error").text(parsed['errors']['reason']);
                  $("#popupModal").modal({                   
                	    "backdrop"  : "static",
                	    "keyboard"  : true,
                	    "show"      : true                     
                	  });
                  return false;
              }
		  }

	  });
return false;
}


function postContent(form,action){
	$.post('/admin/content/'+action, form, function (data, textStatus) {
		urlimg={};
		if(textStatus=='success'){
			if(data!=null){
				  var parsed = JSON.parse(data);
			      if(parsed['success']){
			       	 $("#content_id").attr("value",parsed['datas']['id']);
				      $("#alertmsg").css("color","green");
					  $("#alertmsg").text('content has been added successfully');
					  $("#error").empty();
                   }
                    else if(parsed['success']==false){
                       $("#alertmsg").css("color","red");
  	                  $("#alertmsg").text(parsed['errors']['reason']);
  	                  $("#error").text(parsed['errors']['reason']);
	               }
			 
			}else{
				if(tinymce!=null){
		            	tinymce.remove();
				}
				alert('data problems');
			}
		}else{
			if(tinymce!=null){
	            	tinymce.remove();
			}
			alert('something mistake...problems');
		}
		
	     $("#popupModal").modal({                   
		        "backdrop"  : "static",
		        "keyboard"  : true,
		        "show"      : true                     
		      });
	 });
}

function postFiles(){
	 getFileOldList();
	 var status=true;
	 if($('#content_form #my-file').length){
		$('#content_form #my-file').val('');
		status=validateFiles(storedFiles,filesAlreadyStored);
	 }
	 if(status){
		 var ajaxData = new FormData();
		    for(i=0;i<storedFiles.length;i++){
			    var xhr = new XMLHttpRequest();
			    ajaxData.append("file", storedFiles[i]);
			    var token =  document.getElementById('token').value;
			    ajaxData.append("_token",token);
			    xhr.onreadystatechange = function () {
				  	response = this.responseText;
				  	if(response!=""){
		     	  	var url = JSON.parse(response);
	         		if(url['success']){
		    		  	urlimg[storedFiles[i]['name']]=url.datas[storedFiles[i]['name']];
		             }
		              else if(url['success']==false){
		            	 buildErrorMessage('Oops something wrong happen');
		            	 return false;
		             }
				  }
			  	}
		   
			    xhr.open("POST", "/admin/file/upload",false);
			    xhr.send(ajaxData);
		    }
		    
		    var urls=[];
			// if exist already clean it	
	        var rem= $('#content_form #myfiles');
	        if(rem.length){rem.remove();}
	
	        //create an input files hidden to send to server
	  		var input = document.createElement('input');
			input.type='hidden';
			input.name='myfiles';
	        input.id='myfiles';
			for(var filename in urlimg)
			{
	         urls.push(urlimg[filename]);
			}
			for(var i=0;i<filesAlreadyStored.length;i++)
			{     urls.push(filesAlreadyStored[i].value);
			}
	    	//add files
	        input.value=urls;
	        $('#content_form #list').append(input);
		    return true;
	}else return false;
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
                	 var parsed = JSON.parse(data);
                     if(parsed.datas[0].length!=0){
                		  generateContent(data,url);	
                	  }
                	  
                	
                },
                error: function(xhr, textStatus, thrownError) {
                    alert(thrownError);
                    alert('Something went to wrong.Please Try again later...');
                }
               
            });
  }




function generateContent(req,url){
	 var fiedTinyMCE = new Array();
	 generateFormTinyMCE=[];
	 var parsed = JSON.parse(req);
	 $contentForm=$("#content_form");
	//clear all
	 document.getElementById('content_form').innerHTML='';
	 
	 var divHead=document.createElement('div');
	 divHead.className='row';
	 divHead.style='background-color:#FAFAFA';
	 divHead.id='head';
	 $contentForm.append(divHead);
	 
	 var div=document.createElement('div');
	 div.style='margin-top:50px;margin-left:15px';
	 div.className='row';
	 var title=$("#form-fields #title").clone(true,true);
	 div.innerHTML= title.html();
	 $contentForm.find('#head').append(div);
	 
	 var div=document.createElement('div');
	 div.style='margin-top:50px;margin-left:15px';
	 div.className='row';
	 var template=null;
	 for(var i=0;i<parsed['datas'].length;i++){
		 if(parsed['datas'][i]['template']!=undefined){
			 template=parsed['datas'][i]['template'];
		 }
	 }
		 
	 $('#inputlayout').val(template);
	 $('#inputlayout').attr('defaultvalue', template);
	 $('#inputlayout').attr('value', template);

	 var layout=$("#form-fields #layout").clone(true,true);
	 div.innerHTML= layout.html();
	 $contentForm.find('#head').append(div);
	 
	 
	 var langage=$("#form-fields #langage #langage");
	 var output = [];
	 for(var key in langages){
		output.push('<option value="'+ key +'">'+ langages[key] +'</option>');
	  }
	 
	 langage.html(output.join(''));
	 
	 var div=document.createElement('div');
     div.className='row';
     div.style='margin-top:50px;margin-left:15px';
     div.innerHTML= $("#form-fields #langage").clone(true,true).html();
     $contentForm.find('#head').append(div);
	  
	 var div=document.createElement('div');
	 div.className='row';
	 div.style='margin-top:50px;margin-left:15px';
	 var weight=$("#form-fields #weight").clone(true,true);
	 div.innerHTML= weight.html();
	 $contentForm.find('#head').append(div);
	 
	 var div=document.createElement('div');
	 div.className='row';
	 div.style='margin-top:50px;margin-left:15px';
	 var tag=$("#form-fields #tag").clone(true,true);
	 div.innerHTML= tag.html();
	 $contentForm.find('#head').append(div);
	 
	 var div=document.createElement('div');
	 div.className='row';
	 div.style='margin-top:50px;margin-left:15px';
	 var url=$("#form-fields #description").clone(true,true);
	 div.innerHTML= url.html();
	 $contentForm.find('#head').append(div);
	 
	 var div=document.createElement('div');
	 div.className='row';
	 div.style='margin-top:50px;margin-left:15px';
	 var publish=$("#form-fields #uri").clone(true,true);
	 div.innerHTML= publish.html();
	 $contentForm.find('#head').append(div);
	 
	 var div=document.createElement('div');
	 div.className='row';
	 div.style='margin-top:50px;margin-left:15px';
	 var publish=$("#form-fields #publish").clone(true,true);
	 div.innerHTML= publish.html();
	 $contentForm.find('#head').append(div);
	 

	 
	 //start fields template
	 for(var i=0;i<parsed['datas'].length;i++){
		 for(var j=0;j<parsed['datas'][i].length;j++){
			 var field=null;
			 var newField=null;
		
			 if(parsed['datas'][i][j]['fieldtype']=='date'){
				 field=$("#form-fields #date");
				 newField=field.clone(true,true);
				 var id=newField.find("input");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
				
			 }
			 else if(parsed['datas'][i][j]['fieldtype']=='checkbox'){
		    	 field=$("#form-fields #checkbox");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("input");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
		     }
			 else  if(parsed['datas'][i][j]['fieldtype']=='radio'){
		    	 field=$("#form-fields #radio");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("input");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
		     }
		     if(parsed['datas'][i][j]['fieldtype']=='textarea'){
		    	 field=$("#form-fields #textarea");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("textarea");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
				 if (parsed.datas[i][j]['fieldwidget']=='11'){//editor html tinyMCE
			       	    generateFormTinyMCE.push(parsed['datas'][i][j]['fieldname']);
		 	     }
		     }
		     else if(parsed['datas'][i][j]['fieldtype']=='select'){
		    	 field=$("#form-fields #select");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("select");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
		     }
		     else if(parsed['datas'][i][j]['fieldtype']=='text'){
		    	 field=$("#form-fields #text");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("input");
				 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
		     }
		     else if(parsed['datas'][i][j]['fieldtype']=='file'){
		    	 field=$("#form-fields #uploadfile");
		    	 newField=field.clone(true,true);
		    	 var id=newField.find("div[id='name']");
		    	 id.attr("id", parsed['datas'][i][j]['fieldname']);
				 id.attr("name", parsed['datas'][i][j]['fieldname']);
				 waitForElementToDisplay(parsed['datas'][i][j]['fieldname'],5000);
		     }
		     if(newField!=null){
			     var name=newField.find("label[for='name']");
			     name.html(parsed['datas'][i][j]['fieldname']);
			     newField.appendTo('#content_form');
			     if(parsed.datas[i][j]['fieldrequired']=='1'){
		            //do nothing is by default required
		          }else{
		            	 spanrequired=newField.find("span[class='required']");
		            	 spanrequired.remove();
		          }
		     }
		 }
	 }
	 
	 //in case of a field has same title name need to put here and prevent from loosing event on loading files system
	 input=document.createElement('input');
	 input.type='hidden';
	 input.name='ContentType';
	 input.value=parsed.datas[0][0]['title']
	 input.id=parsed.datas[0][0]['title'];
	 $contentForm.append(input);
	 
     setTimeout(function() {
       	clearInterval(timer);
      	$('#pleaseWaitDialog').modal('hide');
     	$('#modal').modal('show');
     	var bar = $('#progress-bar');
       	bar.css('width',0);
       }, 5000); // milliseconds
	
}


function waitForElementToDisplay(selector, time) {
   if($('#'+selector).length) {
    	bindFileEvents(selector);
        return;
    }
    else {
        setTimeout(function() {
            waitForElementToDisplay(selector, time);
        }, time);
    }
}




$(document).on('hide.bs.modal', function () {
   //tinyMCE.editors=[];
 });

$(document).on('shown.bs.modal', function(e) {
for(var i=0;i<generateFormTinyMCE.length;i++){
	var selector=generateFormTinyMCE[i];
	var sel= document.getElementById(selector);
	if(sel!=null){
	sel.focus();
	eval (tinymce.init({
		protect: [
		           /\<\/?(if|endif)\>/g, // Protect <if> & </endif>
		           /\<xsl\:[^>]+\>/g, // Protect <xsl:...>
		           /<\?php.*?\?>/g // Protect php code
		       ],
	    selector: "textarea#"+generateFormTinyMCE[i],
		    theme: "modern",
		    height: 300,
		    entity_encoding : "raw",
		    mode : "exact",
		    elements : 'abshosturls',
		    relative_urls : false,
		    remove_script_host : false,
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
}; 
});






/**function translate content in a new langage **/

  function TranslateContent(){
  var thArray = $("#table_contents thead tr").map(function(index,elem) {
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
                url: "content/translate",
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
  
  
  /**function edit content **/

    function EditContent(){
    var thArray = $("#table_contents thead tr").map(function(index,elem) {
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
                  url: "content/edit",
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

    /**function delete content **/

    function DeleteContent(){
      var thArray = $("#table_contents thead tr").map(function(index,elem) {
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
                  url: "content/delete",
                   success: function(data) {
                      $("#alertmsg").css("color","green");
					  $("#alertmsg").text('content deleted successfully');
					  $("#error").empty();
					  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
					        "backdrop"  : "static",
					        "keyboard"  : true,
					        "show"      : true                     // ensure the modal is shown immediately
					      });
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
     $.ajax({
                 type: 'get',
                 data : any2url('q',inputData),
                 url: "content_type/fields/delete",
                  success: function(data) {
                      $("#alertmsg").css("color","green");
					  $("#alertmsg").text('field deleted successfully');
					  $("#error").empty();
					  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
					        "backdrop"  : "static",
					        "keyboard"  : true,
					        "show"      : true                     // ensure the modal is shown immediately
					      });
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
    	    for(var i=0; i<rowCount; i++) {
  		        var row = table.rows[i];
  		        var chkbox = row.cells[0].firstElementChild;
  		        if(null != chkbox && true == chkbox.checked) {
  		            if(rowCount <= 1) {
  		                alert("Cannot delete all the rows.");
  		              $("#alertmsg").css("color","red");
  	                  $("#alertmsg").text('Cannot delete all the rows');
  	                  $("#error").text('Cannot delete all the rows');
	  	                $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
	  	                  "backdrop"  : "static",
	  	                  "keyboard"  : true,
	  	                  "show"      : true                     // ensure the modal is shown immediately
	  	                });
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
                  url: "content_type/delete",
                   success: function(data) {
                     var parsed = JSON.parse(data);
                     if(parsed['success']){
                         $("#alertmsg").css("color","green");
	   					 $("#alertmsg").text('content type deleted  successfully');
	   					 $("#error").empty();
		   				  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
		   			          "backdrop"  : "static",
		   			          "keyboard"  : true,
		   			          "show"      : true                     // ensure the modal is shown immediately
		   			        });

                      }
                      else if(parsed['success']==false){
                    	  $("#alertmsg").css("color","red");
    	                  $("#alertmsg").text(parsed['errors']['reason']);
    	                  $("#error").text(parsed['errors']['reason']);
    	                  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
    	                      "backdrop"  : "static",
    	                      "keyboard"  : true,
    	                      "show"      : true                     // ensure the modal is shown immediately
    	                    });

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
   
  function TranslateContent(){
	  var thArray = $("#table_contents thead tr").map(function(index,elem) {
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
	                url: "content/translate",
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

