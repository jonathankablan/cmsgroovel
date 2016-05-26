function parseMenu(obj_ul){

    var obj_lis = obj_ul.find("li");
    //console.log(obj_lis);//run horizontal
    if (obj_lis.length == 0) return;        

    obj_lis.each(function(){
        var $this = $(this);
        if($(this).children().length > 0){
        	$(this).find("a").eq("0").addClass('dropdown-toggle');
        	$(this).find("a").eq("0").attr("data-toggle", "dropdown");
        	$(this).find("a").eq("0").attr("role", "button");
        	$(this).find("a").eq("0").attr("aria-haspopup", "true");
        	$(this).find("a").eq("0").attr("aria-expanded", "false");
        }
        if($this.parent("ul").get(0) == obj_ul.get(0))
        {   
        	   $this.find("ul").eq("0").addClass('dropdown-menu');
        	   $this.find("ul").eq("0").find("li").each(function(){
        		   if($(this).children().children().length>0){
        			   $(this).addClass('dropdown-submenu');
        		   }
        	   })
               child : parseMenu($this.find("ul").first())
         }
        
    });
}



$(document).ready(function(){
	 parseMenu($("ul.menu"));
	 $(this).find('li').each(function(){
		 if($(this).next().size() > 0){
		  $(this).append("<li class=\'divider\'></li>");
		 }
	 });
	 
	

})

$(document).ready(function(){
      $('#Menu').on('show.bs.dropdown', function () {
  		 // $(this).siblings('.open').removeClass('open').find('a.dropdown-toggle').attr('data-toggle', 'dropdown');
  		 // $(this).find('a.dropdown-toggle').removeAttr('data-toggle');
    	  //make parents link clickable
    	  $('.dropdown-toggle').click(function() {
    		    var location = $(this).attr('href');
    		    window.location.href = location;
    		    return false;
    		});

  		});
})

