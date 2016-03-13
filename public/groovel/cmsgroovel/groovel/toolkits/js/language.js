$(document).ready(function(){
$('<img class=\'flag\' src="blank.gif">').insertAfter("#lang_choice");
     $('#lang').val( $("select#lang_choice").val());
     $("select#lang_choice").change(function(){
         $flag='flag flag-'+$("select#lang_choice").val();
         $(".flag").attr('class',$flag);
         $('#lang').val( $("select#lang_choice").val());
      });
})

$(document).on("change", "select#lang_choice", function(){
    	  	var form=$('#languagechoice').serialize();
    		$.post(window.location.pathname, form, function (data, textStatus) {
    		 //refresh the page with translate content
    		  location.reload();
             });
});