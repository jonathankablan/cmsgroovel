

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
                	 var parsed = JSON.parse(data);
                	  if(parsed.datas[0].length!=0){
                		  setDataJSON(data,url);	
                	  }
                	  
                	
                },
                error: function(xhr, textStatus, thrownError) {
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
  var label3='<label for=\'tag\' class="required">tag</label>';
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
        	  $.ajax({
	                type: 'get',
	                data :"",
	                dateType:'json',
	                url: "file/upload/widget",
	                 success: function(data) {
	                	 form_group_label =document.createElement('div');
	                     form_group_label.className = "form-group";
	                     var label1='<label for=\'files\'>Files Attachements</label>';
	                     form_group_label.innerHTML=label1;
	                     my_form.appendChild(form_group_label);
	                	 
	                     form_group =document.createElement('div');
	                     form_group.className = "form-group form-inline";
	                     form_group.style='margin-left:250px';
	                     form_group.innerHTML=data.html;
	                     my_form.appendChild(form_group);   
	                     document.body.appendChild(my_form);
	                     document.getElementById('form-modal').appendChild(my_form);
	                     fileEvents();
	                     //add sidebar
	                     sidebar = document.createElement('div');
	                     sidebar.style = "margin-top:30px;margin-bottom:15px;width:100%;height:60px;background-color: #98FB98;";
	                     p=document.createElement('p');
	                     p.style.color='black';
	                     p.innerHTML='Optional settings';
	                     p.style='margin-left:300px';
	                     sidebar.appendChild(p);
	                     my_form.appendChild( sidebar);
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
	                     var label='<label for='+'weight' +' style="font-size: 20px">position of your content</label>';
	                     form_group.innerHTML=label;
	                     input=document.createElement('input');
	                     input.type='text';
	                     input.name='weight';
	                     input.value='';
	                     input.style='margin-left:130px';
	                     input.id='weight';
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
 
    if(sidebar==null){
	    sidebar = document.createElement('div');
	    sidebar.style = "margin-top:30px;margin-bottom:15px;width:100%;height:60px;background-color: #98FB98;";
	    p=document.createElement('p');
	    p.style.color='black';
	    p.innerHTML='Optional settings';
	    p.style='margin-left:300px';
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
        var label='<label for='+'weight' +' style="font-size: 20px">weight content</label>';
        form_group.innerHTML=label;
        input=document.createElement('input');
        input.type='text';
        input.name='weight';
        input.value='';
        input.style='margin-left:130px;margin-top:50px';
        input.id='weight';
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
	var selector=generateFormTinyMCE[i];
	var sel= document.getElementById(selector);
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
                      alert('field deleted successfully');
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
