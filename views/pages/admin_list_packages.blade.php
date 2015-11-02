@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12">
       	@if(Session::get('messages'))
             <div>{!!var_dump(Session::get('messages'))!!}</div>
        @endif
       
         <h2>Packages</h2>
      
          <div class="span2">      
            <button id="artisanCacheClear" class="btn btn-default btnArtisanCacheClear">Artisan Cache Clear</button>
            <button id="artisanDumpAutoload" class="btn btn-default btnArtisanDumpAutoload">Artisan dump-autoload</button>
          </div>
          
            <div class="row" id="packages">
	                <div class="col-lg-12">
	                <div class="panel panel-primary" style="width:1020px">
	                        <div class="panel-body">
	                        <div style='margin-bottom: 10px' >
		                        	<input class="search" placeholder="Search" style="height:30px" />
							  		<button class="sort" data-sort="packagename" style="height:30px">
							    		Sort by name
							  		</button>
						  		</div>
	            				<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" id="table_packages">
										<thead>
									          <tr>
					                             <th id="col_package" style='display: none'>packageDir</th>
						                         <th id="col_package" style='background-color:#E0FFFF'>packageName</th>
						                         <th id="col_package" style='background-color:#E0FFFF'>description</th>
						                         <th id="col_package" style='background-color:#E0FFFF'>require</th>
						                         <th id="col_package" style='background-color:#E0FFFF'>require-dev</th>
						                         <th id="col_package" style='background-color:#E0FFFF'></th>
						                         <th id="col_package" style='background-color:#E0FFFF'></th>
						                         <th id="col_package" style='background-color:#E0FFFF'></th>
						                 		</tr>
                             			</thead>
										<tbody aria-relevant="all" aria-live="polite" role="alert" class="list"><tr class="gradeA odd">
											 @foreach ($packages as $package)
											    <tr id="row_packages">
												    <td id="row_package" style='display: none'>{!!$package->pathComposerJson!!}</td>
						                            <td id="row_package" class="packagename">{!!$package->name!!}</td>
						                            <td id="row_package">{!!$package->description!!}</td>
						                             <td id="row_package">
						                             @if(!empty($package->require))
						                              @foreach ($package->require as $key=>$require)
						                              	{!!$key!!}{!!$require!!}
						                              @endforeach
						                            @endif
						                             </td>
						                             <td id="row_package">
						                             @if(!empty($package->requiredev))
						                              @foreach ($package->requiredev as $key=>$requiredev)
						                              	{!!$key!!}{!!$requiredev!!}
						                              @endforeach
						                            @endif
						                             </td>
						                           <td id="update">
						                       	   <button id="update" class="btn btn-success btnUpdatePackage">update</button>
								                     </td>
						                            <td id="dump">
						                             <button id="dump" class="btn btn-success btnDumpAutoloadPackage">dump-autoload</button>
						                            </td>
						                             <td id="del">
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
   
        </div>

 
         <script>
 var options = {
  valueNames: [ 'packagename']
};

var packagesList = new List('packages', options);
 </script>         


@stop