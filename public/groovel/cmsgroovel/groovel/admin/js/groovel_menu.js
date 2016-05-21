function buildErrorMessage($error){
	    window.scrollTo(0,0);
	    document.getElementById('light').innerHTML=null;
        document.getElementById('light').style.display='block';
        document.getElementById('light').className='alert alert-danger fade in';
        document.getElementById('fade').style.display='block';  
        
        div=document.createElement('div');
        div.className='row';
        div.style='margin-left:99%'
        a=document.createElement('a');
 		a.className='closer';
		a.href='#';
		a.innerHTML='x';
		a.onclick = function(e) {  
			document.getElementById('light').style.display='none';
			document.getElementById('fade').style.display='none';
		    return false;
		};
		div.appendChild(a);
		document.getElementById('light').appendChild(div);
		
		 div=document.createElement('div');
	     div.className='row';
	     div.innerHTML = $error;
	     document.getElementById('light').appendChild(div);
		
		
		button=document.createElement('button');
			button.innerHTML='OK';
			//button.style='margin-left:90px;margin-top:100px;width:100px;height:40px';
			button.onclick = function(e) {  
				document.getElementById('light').style.display='none';
				document.getElementById('fade').style.display='none';
			    return false;
			};
			div=document.createElement('div');
			div.className='row';
			div.style='margin-left:50%';
			div.id='mess';
			document.getElementById('light').appendChild(div);
			document.getElementById('mess').appendChild(button);
}

function buildSucessMessage($message){
	   window.scrollTo(0,0);
	   document.getElementById('light').innerHTML=null;
       document.getElementById('light').style.display='block';
       document.getElementById('light').className='alert alert-success fade in';
       document.getElementById('fade').style.display='block';  
       
       div=document.createElement('div');
       div.className='row';
       div.style='margin-left:99%'
       a=document.createElement('a');
		a.className='closer';
		a.href='#';
		a.innerHTML='x';
		a.onclick = function(e) {  
			document.getElementById('light').style.display='none';
			document.getElementById('fade').style.display='none';
		    return false;
		};
		div.appendChild(a);
		document.getElementById('light').appendChild(div);
		
		 div=document.createElement('div');
	     div.className='row';
	     div.innerHTML = $message;
	     document.getElementById('light').appendChild(div);
		
		
		button=document.createElement('button');
			button.innerHTML='OK';
			//button.style='margin-left:90px;margin-top:100px;width:100px;height:40px';
			button.onclick = function(e) {  
				document.getElementById('light').style.display='none';
				document.getElementById('fade').style.display='none';
			    return false;
			};
			div=document.createElement('div');
			div.className='row';
			div.style='margin-left:50%';
			div.id='mess';
			document.getElementById('light').appendChild(div);
			document.getElementById('mess').appendChild(button);
}

function parseMenu(obj_ul, tree){

    var obj_lis = obj_ul.find("li")
    if (obj_lis.length == 0) return;        

    obj_lis.each(function(){
        var $this = $(this);
        if($this.parent("ul").get(0) == obj_ul.get(0))
        {   
         	route={'tagName':$this.prop('tagName'),'name':$this.children().eq(0).children().eq(2).children().eq(0).val(),'uri':$this.children().eq(0).children().eq(4).children().eq(0).val()};
	        tree.push({
                name : route,
                child : parseMenu($this.find("ul").first(), [])
            });
        }
    });
    return tree;
}

function deleteMenu(){
	 var id= $("#menu_id").val();
	 var token =$("#token").val();
		
	 $.ajax({
         type: 'post',
         data : {'id': id, '_token': token},
         dateType:'json',
         url: "/admin/menu/delete",
          success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['success']){
            	 buildSucessMessage("menu deleted");
            	 //$("#menu_id").attr("value",parsed['datas']['id']);
            	 $("#delete").attr("disabled", "disabled");
             }else{
            	 buildErrorMessage(parsed['errors']['reason']);
             }
         },
         error: function(xhr, textStatus, thrownError) {
             alert(thrownError);
             alert('Something went to wrong.Please Try again later...');
         }
        
     });
}

function saveMenu(){
	 var tree=new Array();
	 var navBar=new Array();
	 $('ul.u').each(function(){
		 var tree=new Array();
		 var menu=parseMenu($(this),tree);
		 navBar.push(menu);
	 })
	 var token =$("#token").val();
	 var id= $("#menu_id").val();
	 var name=$("#title").val()
	 var type=$( "#layout option:selected" ).text();
	 var lang=$( "#langages option:selected" ).text();
	 $.ajax({
         type: 'post',
         data : {'id': id,'name':name,'langage':lang,'menu':navBar,'layout':type, '_token': token},
         dateType:'json',
         url: "/admin/menu/add",
          success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['success']){
            	 buildSucessMessage("menu saved and updated");
            	 $("#menu_id").attr("value",parsed['datas']['id']);
            	 $("#delete").removeAttr("disabled");
             }else{
            	 buildErrorMessage(parsed['errors']['reason']);
             }
         },
         error: function(xhr, textStatus, thrownError) {
             alert(thrownError);
             alert('Something went to wrong.Please Try again later...');
         }
        
     });
}

function deleteMenu(){
	 var token =$("#token").val();
	 var id= $("#menu_id").val();
	 var res=[];
	 $.ajax({
         type: 'post',
         data : {'id':id, '_token': token},
         dateType:'json',
         url: "/admin/menu/delete",
          success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['success']){
            	 buildSucessMessage("menu has been deleted");
            	 $("#delete").attr("disabled", "disabled");
             }else{
            	 buildErrorMessage("Oops Something wrong happens");
             }
         
         },
         error: function(xhr, textStatus, thrownError) {
             alert(thrownError);
             alert('Something went to wrong.Please Try again later...');
         }
        
     });
	
}



function createUL(varclassd){
  var u=$('<ul>');
  if(varclassd=='d'){
	   	li=createLI("d");
	    u.append(li);
	    u.attr('class','u');
   }else if(varclassd=='dd'){
	   	li=createLI("dd");
	   	u.append(li);
   }else if(varclassd=='ddd'){
	   	li=createLI("ddd");
	   	u.append(li);
   }else if(varclassd=='dddd'){
	   	li=createLI("dddd");
	   	u.append(li);
   }
return u;
}


function createLI(varclassd){
   
	var a="add-right"+" "+varclassd+" "+ "row";
	var div=$('<div class=\''+a+'\'>');

	var divPlus=$('<div class=\'col-md-1\'>');
    $('<i style=\"font-size:15px\" class=\"glyphicon glyphicon-plus\" onmouseover=\"this.style.cursor=\'pointer\'\">').appendTo(divPlus);

    divPlus.appendTo(div);
	
	var divColName=null;
	var divColName=$('<div class=\'col-md-1\'>');
	if(varclassd=="dd"){
		divColName=$('<div class=\'col-md-2\'>');
	}else if(varclassd=="ddd"){
		divColName=$('<div class=\'col-md-2\'>');
	}else if(varclassd=="dddd"){
		divColName=$('<div class=\'col-md-2\'>');
	}
	var labelName=$('<label for=\'name\'>').html('link name');
 
    labelName.appendTo(divColName);	
    
	var divInputName=$('<div class=\'col-md-2\'>');
	var inputName=$('<input type=\'text\' class=\'form-control\' id=\'name\' placeholder=\'name\'>');

	inputName.appendTo(divInputName);
	
	var divUrl=$('<div class=\'col-md-1\'>');
	var labelUrl=$('<label for=\'url\'>').html('url');

	labelUrl.appendTo(divUrl);	
	
	var divInputUrl=$('<div class=\'col-md-2\'>');
	var inputUrl=$('<input type=\'text\' class=\'form-control\' id=\'url\' placeholder=\'url\'>');

	inputUrl.appendTo(divInputUrl);

	divColName.appendTo(div);
	divInputName.appendTo(div);
	divUrl.appendTo(div);
	divInputUrl.appendTo(div);

	var divButton=$('<div class=\'col-md-4\'>');
	$('<button id=\'addMnItem\' style=\"margin-bottom:15px;margin-right:5px\" class=\"btn btn-info\">Add Item</button>').appendTo(divButton);
	 
	$('<button id=\'addMnChildItem\' style=\"margin-bottom:15px\" class=\"btn btn-primary\">Add Child Item</button>').appendTo(divButton);

	$('<i style=\"font-size:15px\" class=\"glyphicon glyphicon-remove\" onmouseover=\"this.style.cursor=\'pointer\'\">').appendTo(divButton);
	 
	var li=$('<li>');
	li.attr('style','list-style: none;');
	divButton.appendTo(div);
	div.appendTo(li);
	return li;
}

/**function edit layou menu **/

function EditMenu(){
var thArray = $("#table_menus thead tr").map(function(index,elem) {
              var ret = [];
              var x = $(this);
              var cells = x.find('th#col_menu');
              $(cells, this).each(function () {
                  var d = $(this).val()||$(this).text();
                  ret.push(d);
              });
              return ret;
            });

  var tdArray=new Array();
  var parent=$(this).parent().parent();
      $(parent).children('td#row_menu').each(function(i,td) {
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
              url: "/admin/menu/edit",
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

function DelMenu(){
  var thArray = $("#table_menus thead tr").map(function(index,elem) {
              var ret = [];
              var x = $(this);
              var cells = x.find('th#col_menu');
              $(cells, this).each(function () {
                  var d = $(this).val()||$(this).text();
                  ret.push(d);
              });
              return ret;
            });

  var tdArray=new Array();
  var parent=$(this).parent().parent();
      $(parent).children('td#row_menu').each(function(i,td) {
          tdArray.push($(this).text());
      });

  var inputData = new Array();
  for (i = 0; i < thArray.length; i++){ 
       inputData[thArray[i]]=tdArray[i];
  }
  $.ajax({
              type: 'get',
              data : any2url('q',inputData),
              url: "/admin/menu/delete",
               success: function(data) {
                  alert('menu deleted successfull');
               },
              error: function(xhr, textStatus, thrownError) {
                 alert(thrownError);
                  alert('Something went to wrong.Please Try again later...');
              }
             
          });
     var par = $(this).parent().parent(); //tr
     par.remove();
}; 
