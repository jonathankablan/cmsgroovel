@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')



<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Dashboard Groovel</title>
	</head>
	<body>
	    <div id="wrapper">
	         <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h1>Dashboard</h1>
	                </div>
	            </div>
	            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Traffic Estimations for last 30 days</h3>
                        </div>
                        <div class="panel-body">
                   
                   <div id="chartdiv" style="height:400px;width:700px; "></div>
                         </div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Number of users</h3>
                        </div>
                        <div class="panel-body">
                            <div style='margin-left:70px;font-size:50px'>
	                        {{$total_users}}
	                        </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Number of users sessions connected</h3>
                        </div>
                        <div class="panel-body">
                          <div style='margin-left:100px;font-size:50px'>
	                        {{$total_users_connected}}
	                       </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Number of messages sent</h3>
                        </div>
                        <div class="panel-body">
                        	 <div style='margin-left:100px;font-size:50px'>
	                        {{$total_message}}
	                        </div>
                        </div>
                    </div>
                </div>
                   <div id="container"  class="col-lg-12"  style="position: relative;margin-top:50px; margin-bottom:50px; width:900px;height:500px" > </div>
	         
             </div>
	    </div>

  
	     
	</body>
</html>

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
    	$.ajax({
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