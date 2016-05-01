@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')

	     <div class="container-fluid" style='margin-top:100px'>
	             <div class="row">
		            <div class="col-lg-12 col-lg-offset-0 col-sm-12 col-sm-offset-0 col-xs-12">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <font color='black'>Traffic Estimations for last 30 days</font></h3>
	                        </div>
	                        <div class="panel-body">
	                   
			                   <div id="chartdiv">
			                   
			                   </div>
			                   
	                         </div>
	                    </div>
	                  </div>
                   </div>
                  <div class="row"> 
	                  <div class="col-lg-2 col-lg-offset-0 col-sm-4 col-sm-offset-0 col-xs-4">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i><font color='black'> Number of users</font></h3>
	                        </div>
	                        <div class="panel-body">
	                            <div style='font-size:50px'>
		                        {!!$total_users!!}
		                        </div>
	                        </div>
	                    </div>
	                </div>
	                 <div class="col-lg-3 col-sm-4 col-xs-4">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <font color='black'>Number of users sessions connected</font></h3>
	                        </div>
	                        <div class="panel-body">
	                          <div style='font-size:50px'>
		                        {!!$total_users_connected!!}
		                       </div>
	                        </div>
	                    </div>
	                </div>
	                 <div class="col-lg-3 col-sm-4 col-xs-4">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <font color='black'>Number of messages sent</font></h3>
	                        </div>
	                        <div class="panel-body">
	                        	 <div style='font-size:50px'>
		                        {!!$total_message!!}
		                        </div>
	                        </div>
	                    </div>
	                </div>
	              </div>
                   <!--  <div id="container"  class="col-lg-8 col-lg-offset-3"  style="position: relative;margin-top:50px; margin-bottom:50px; width:900px;height:500px" > </div>-->
	         
             </div>

     <style media="screen">
           
            #latlon-form input {
                font-size: 14px;
                width: 200px;
            }
            #latlon-form button {
                font-size: 14px;
            }
            #cities {
                position: absolute;
                top: 470px;
                margin: 0 10px;
                padding: 0;
                list-style: none;
            }
            #cities a {
                color: #ccf;
            }
        </style>
 
    <script>
    $(document).ready(function() {
    	/* 	$.ajax({
            type: 'get',
            data : 'test',
            dateType:'json',
            url: 'dashboard/users/location',
             success: function(data) {
               //   $('#test').empty();
             	var parsed = JSON.parse(data);
             	var map = new Datamap({element: document.getElementById('container')});
                var bombarrays=new Array();
      
             	for (var i in parsed){
        	 	   var po=JSON.parse(parsed[i]);
        	 	   bombarrays[i]={radius: 2, yield: 40,latitude: po['latitude'],longitude: po['longitude'],borderColor:'red',people:po['people'],country:po['country'],city:po['city']};
             	}
            
                 map.bubbles(bombarrays, {
                     popupTemplate: function (geo, data) { 
                             return ['<div class="hoverinfo">' +  
                             '<br/>country : ' +  data.country + '',
                             '<br/>city : ' +  data.city + '',
                             '<br/>visitors count : ' +  data.people + '',
                             '</div>'].join('');
                     }
                 });
            	  
            	
            },
            error: function(xhr, textStatus, thrownError) {
               console.log(thrownError);
                alert(thrownError);
                alert('Something went to wrong.Please Try again later...');
            }
           
        });
*/


    	$.ajax({
            type: 'get',
            data : 'test',
            dateType:'json',
            url: 'dashboard/users/totalUsersByDay',
             success: function(data) {
              	var parsed = JSON.parse(data);
             	var input=new Array();
              	for (var i in parsed){
        	 	   var po=JSON.parse(parsed[i]);
        		   var args=[po['date'],po['number']]
				   input.push(args);
                }
               	  var line1=input;
              	  var plot1 = $.jqplot('chartdiv', [line1], {
              	    title:'Statistics number total of users per date',
              	    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
              	    series:[{lineWidth:4, markerOptions:{style:'square'}}]
              	  });  
            	  
            	
            },
            error: function(xhr, textStatus, thrownError) {
               console.log(thrownError);
                alert(thrownError);
                alert('Something went to wrong.Please Try again later...');
            }
           
        });
    	
           
   });

    
    
    </script>

@stop