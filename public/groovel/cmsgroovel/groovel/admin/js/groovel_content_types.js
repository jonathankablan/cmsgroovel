$.fn.exists = function () {
    return this.length !== 0;
}

function checkTitleTemplateNotNull(){
	if($("#form-title").exists() && $("#form-title").val().length>0){
		return true;
	}else return false;
}


function checkFieldTitleUniqueAndNotNull(){
	var titles= new Array();
	var countField=0;
	 $(".field").each(function() {
		 $(this).find(".toggle-view .row .col-md-3").each(function() {
		 	  if($(this).find("input#name").exists() && $(this).find("input#name").val().length>0){
		 		  titles[$(this).find("input#name").val()]=$(this).find("input#name").val();
	     	  }
		 })
		 countField=countField+1;
	 })
	 if(countField!=Object.keys(titles).length||((countField==Object.keys(titles).length) && countField==0)){
		 return false;
	 }else return true;
}

function deleteTemplate(){
	var template=parseTemplate();
	 if(!checkTitleTemplateNotNull()){
		  $("#alertmsg").css("color","red");
          $("#alertmsg").text("template must have a name");
          $("#error").text("template must have a name");
          $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
              "backdrop"  : "static",
              "keyboard"  : true,
              "show"      : true                     // ensure the modal is shown immediately
            });
		 return;
	 }
	 var token =$("#token").val();
	 var id= $("#content_type_id").val();
	 var res=[];
	 $.ajax({
         type: 'post',
         data : {'q': {'id':id}, '_token': token},
         dateType:'json',
         url: "/admin/content_type/delete",
          success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['success']){
            	 $("#alertmsg").css("color","green");
				 $("#alertmsg").text('content_type has been deleted');
				 $("#error").empty();
				  $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
				         "backdrop"  : "static",
				         "keyboard"  : true,
				         "show"      : true                     // ensure the modal is shown immediately
				       });
             }else{
            	 $("#alertmsg").css("color","red");
                 $("#alertmsg").text("Oops Something wrong happens");
                 $("#error").text("Oops Something wrong happens");
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
   

}


function previewTemplate(){
	var template=parseTemplate();
	var title=template['title'];
	var fields=template['body'];
	for (var i=0;i<Object.keys(fields).length;i++){
		fields[i]['fieldtype'];
		fields[i]['fieldname'];
		fields[i]['fielddescription'];
		fields[i]['fieldvalue'];
		fields[i]['fieldwidget'];
		fields[i]['fieldrequired'];
	}
	
}



function saveTemplate(){
	 var template=parseTemplate();
	 if(!checkTitleTemplateNotNull()){
		  $("#alertmsg").css("color","red");
          $("#alertmsg").text("template must have a name");
          $("#error").text("template must have a name");
          $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
              "backdrop"  : "static",
              "keyboard"  : true,
              "show"      : true                     // ensure the modal is shown immediately
            });
		 return;
	 }
	 if(!checkFieldTitleUniqueAndNotNull()){
		  $("#alertmsg").css("color","red");
          $("#alertmsg").text("field title is missing and title must be unique");
          $("#error").text("field title is missing and title must be unique");
          $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
              "backdrop"  : "static",
              "keyboard"  : true,
              "show"      : true                     // ensure the modal is shown immediately
            });
		 return;
	 }
	 var token =$("#token").val();
	 var id= $("#content_type_id").val();
	// console.log(template);
	 $.ajax({
         type: 'post',
         data : {'id': id,'template':template, '_token': token},
         dateType:'json',
         url: "/admin/content_type/add",
          success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['success']){
            	 $("#alertmsg").css("color","green");
				 $("#alertmsg").text('content_type saved and updated');
				 $("#error").empty();
            	 $("#content_type_id").attr("value",parsed['datas']['id']);
            	 $("#popupModal").modal({                    // wire up the actual modal functionality and show the dialog
                     "backdrop"  : "static",
                     "keyboard"  : true,
                     "show"      : true                     // ensure the modal is shown immediately
                   });
             }else{
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
	
}

function parseTemplate(){
	var template={};
	var body={};
	var index=0;
	if($("#form-title").exists()){
		template['title']=$("#form-title").val();
	}
	template['type']=$("#form-type").val();
    $(".field").each(function() {
    	  var field={};
    	  var fieldtype=null;
    	  var fieldname=null;
    	  var fielddescription=null;
    	  var fieldrequired=null;
    	  var fieldvalue=null;
    	  var fieldwidget=null;
    	  $(this).find(".toggle-view .row .col-md-1").each(function() {
    		  if($(this).find("input#required").exists()){
    			  fieldrequired=$(this).find("input#required").is(':checked');
    			  field['fieldrequired']=fieldrequired;
    		  }
	    	  if($(this).find("input#type").exists()){
	    		  fieldtype=$(this).find("input#type").val();
	    		  field['fieldtype']=fieldtype;
	    	  }
	    	  if($(this).find("select#widget").exists()){
	    		  fieldwidget=$(this).find("select#widget").val();
	    		  field['fieldwidget']=fieldwidget;
	    	  }
	      })
	       $(this).find(".toggle-view .row .col-md-3").each(function() {
		    	  if($(this).find("input#name").exists()){
		    		  fieldname=$(this).find("input#name").val();
		    		  field['fieldname']=fieldname;
		    	  }
		    	  if($(this).find("input#description").exists()){
		     		  fielddescription=$(this).find("input#description").val();
		     		  field['fielddescription']=fielddescription;
		    	  }
		      });
    	  if(fieldtype!="select" && fieldtype!="textarea"){
		      field['fieldvalue']=null;
		      field['fieldwidget']=null; 
    	  }
    	  if(fieldtype=="textarea"){
    		  field['fieldvalue']=null;
    	  }
	      if(fieldtype=="select"){
	    	  field['fieldwidget']=null;
	    	  var options={};
	    	  $(this).find(".toggle-view table tbody tr").each(function() {
	    		  if($(this).find("input#optional_name").exists() && $(this).find("input#optional_value").exists()){
	    			  options[$(this).find("input#optional_name").val()]=$(this).find("input#optional_value").val();
	    		  }
	    		  
	    	  });
	    	  field['fieldvalue']=options;
	      }
        body[index]=field;  
	    index=index+1;
	 });
     template['body']=body;
     return template;
}

function selectOption(){
	 $(document).delegate("#refresh_list", "click", function() {
		 $(this).parents().eq(4).find("select.val").html('');
		 $(this).parents().eq(2).find("table tbody tr").each(function() {
			    var optional_name = $(this).find("input#optional_name");
			    var optional_value = $(this).find("input#optional_value");
			    if($(this).find("input#optional_name").exists() && $(this).find("input#optional_value").exists()){
			    	$(this).parents().eq(4).find("select.val").append($("<option></option>").attr("value", optional_value.val()).text(optional_name.val()));
	            }
		});
	 });
}


function dragContentType(){
		  
		$('#form-fields div').draggable({
		        revert: "valid",
		        appendTo: "body",
		        helper: "clone",
		        cursor: "move"
		    });

		$(".droppedFields").droppable({  
		    accept: ":not(.ui-sortable-helper)",
		    drop: function(event, ui) {   

	           var newclass = "field";
		       var item = ui.draggable.html(); 
		       var s =item; 
		       var r = /<span>(.*)<\/span>/g;
		       var newtxt=s.replace(r,""); 
		       newtxt=newtxt.replace("panel",""),
		       
		        $("<div/>", {            
		            "html":  "<div class=\"row\" style=\"background-color:#E6E6E6;width:100% \"><div id=\"title\" class=\"title col-md-2\">Set your title: </div>"+ "<div id=\"del\" class=\"glyphicon glyphicon-remove pull-right\"></div>"+"<div class=\"col-md-12 \">"+newtxt+"</div>"+"</div>",
		            "class": newclass
		        }).appendTo(this);   
		    }
	    });
			  
		$( ".droppedFields" ).sortable();
		$(document).delegate(".glyphicon.glyphicon-remove.pull-right", "click", function() {
		     $(this).parent().parent().remove();
		    });
		 
			
		
		 
		 //set title
		 $(document).delegate("#name", "click", function() {
			     $(this).on("change, keyup",  $(this).parents().eq(4).children('#title'), function() {
		    	 $(this).parents().eq(4).children('#title').html("");
		    	 $(this).parents().eq(4).children('#title').append($(this).val());
		    	 
		     });
		 });
		 
		 
		 //start select type 
		 //add values for optional select value 
		 $(document).delegate(".glyphicon.glyphicon-plus", "click", function() {
			    var $tr    = $(this).closest('.tr_clone');
			    var $clone = $tr.clone();
			    $clone.find(':text').val('');
			    $(document).delegate(".glyphicon.glyphicon-minus", "click", function() {
					     $(this).parents().eq(1).remove();
			    });
			    $tr.after($clone);
		 });
		 
		
		 selectOption();
		 //end select type
				 
			    
};   