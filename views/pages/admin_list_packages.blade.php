@extends('cmsgroovel.layouts.groovel_admin_package')
@section('content')
	 <div style="margin-top:70px">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
         
          
            <div id="packages">
	                <div class="row">
	                <div class="panel panel-default">
	                  		<div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Packages</h3>
	                        </div>
	                        <div class="panel-body col-xs-7 col-sm-10 col-md-10">
		                        <div style='margin-bottom: 10px' >
		                        	<div class="col-md-2 col-sm-3 col-xs-2  hidden-xs">
			                        	<input class="search" placeholder="Search" style="height:30px" />
			                        </div>
			                        <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm">
								  		<button class="sort" data-sort="packagename" style="height:30px">
								    		Sort by name
								  		</button>
								  	</div>
								  	 <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm">     
								        <button id="artisanCacheClear" class="btn btn-default btnArtisanCacheClear">Artisan Cache Clear</button>
								     </div>
								      <div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-1 hidden-xs hidden-sm">  
								           <button id="artisanDumpAutoload" class="btn btn-default btnArtisanDumpAutoload">Artisan dump-autoload</button>
								       </div>
							  	</div>
					    	</div>
	            
	            				<table class="table table-hover table-striped table-bordered table-responsive" id="table_packages">
										<thead>
									          <tr>
					                             <th id="col_package" class="col-md-1 hidden-xs hidden-sm" style='display: none'>packageDir</th>
						                         <th id="col_package" class="col-md-1" style='background-color:#E0FFFF'>packageName</th>
						                         <th id="col_package" class="col-md-1" style='background-color:#E0FFFF'>description</th>
						                         <th id="col_package" class="col-md-1" style='background-color:#E0FFFF'>require</th>
						                         <th id="col_package" class="col-md-1 hidden-xs hidden-sm" style='background-color:#E0FFFF'>require-dev</th>
						                         <th id="col_package" class="col-md-1 hidden-xs hidden-sm" style='background-color:#E0FFFF'></th>
						                         <th id="col_package" class="col-md-1 hidden-xs hidden-sm" style='background-color:#E0FFFF'></th>
						                         <th id="col_package" class="col-md-1 hidden-xs hidden-sm" style='background-color:#E0FFFF'></th>
						                 		</tr>
                             			</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($packages as $package)
											    <tr id="row_packages">
												    <td id="row_package" class="col-md-1 hidden-xs hidden-sm" style='display: none'>{!!$package->pathComposerJson!!}</td>
						                            <td id="row_package" class="packagename">{!!$package->name!!}</td>
						                            <td id="row_package" class="col-md-1">{!!$package->description!!}</td>
						                             <td id="row_package" class="col-md-1">
						                             @if(!empty($package->require))
						                              @foreach ($package->require as $key=>$require)
						                              	{!!$key!!}{!!$require!!}
						                              @endforeach
						                            @endif
						                             </td>
						                             <td id="row_package" class="col-md-1 hidden-xs hidden-sm">
						                             @if(!empty($package->requiredev))
						                              @foreach ($package->requiredev as $key=>$requiredev)
						                              	{!!$key!!}{!!$requiredev!!}
						                              @endforeach
						                            @endif
						                             </td>
						                           <td id="update" class="col-md-1 hidden-xs hidden-sm">
						                       	   <button id="update" class="btn btn-success btnUpdatePackage">update</button>
								                     </td>
						                            <td id="dump" class="col-md-1 hidden-xs hidden-sm">
						                             <button id="dump" class="btn btn-success btnDumpAutoloadPackage">dump-autoload</button>
						                            </td>
						                             <td id="del" class="col-md-1 hidden-xs hidden-sm">
						                            <button id="install" class="btn btn-success btnInstallPackage">install</button>
						                            </td>
					                          </tr>
					                  		@endforeach
          								</tbody>
          							</table>
          							
          						        <ul class="pagination">
						                {!! $packages->render() !!}
	               					 	</ul>
	                    </div>
	                </div>
 				</div>
   
        </div>

 
         <script>
 var options = {
  valueNames: [ 'packagename']
};

var packagesList = new List('packages', options);
 </script>         


@stop