@extends('cmsgroovel::layouts.groovel_admin_default')
@section('content')
	 <div class="col-md-12 col-md-offset-2">
       	@if(Session::get('messages'))
             <div>{{var_dump(Session::get('messages'))}}</div>
        @endif
       
         <h2>Package board</h2>
             <div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Packages</h3>
	                        </div>
	                        <div class="panel-body">
	            				
          							
          							<div class="row">
		          							<div class="col-lg-1">
		          							</div>
		            					<div class="col-lg-10">
							                <hr/>
							                <h3>Commands:</h3>
							                <div class="form-inline">
							                    <button id="self-update" onclick="del()" class="btn btn-success disabled">Update Composer</button><br /><br />
							                    <input type="text" id="path" style="width:300px;" class="form-control disabled" placeholder="absolute path to project directory"/>
							                    <button id="install" onclick="call('install')" class="btn btn-success disabled">install</button>
							                    <button id="update" onclick="call('update')" class="btn btn-success disabled">update</button>
							                    <button id="update" onclick="call('dump-autoload')" class="btn btn-success disabled">dump-autoload</button>
							                </div>
							                <h3>Console Output:</h3>
							                <pre id="output" class="well"></pre>
		            					</div>
		            					<div class="col-lg-1"></div>
        						   </div>
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
          							
	                          </div>
	                    </div>
	                </div>
 				</div>
   
        </div>

 <script type="text/javascript">
            $(document).ready(function(){
            	checkInstallComposer();
            });
            function url()
            {
                return 'packages/composer';
            }
            function call(func)
            {
                $("#output").append("\nplease wait...\n");
                $("#output").append("\n===================================================================\n");
                $("#output").append("Executing Started");
                $("#output").append("\n===================================================================\n");
                $.post('main.php',
                        {
                            "path":$("#path").val(),
                            "command":func,
                            "function": "command"
                        },
                function(data)
                {
                    $("#output").append(data);
                    $("#output").append("\n===================================================================\n");
                    $("#output").append("Execution Ended");
                    $("#output").append("\n===================================================================\n");
                }
                );
            }

          
            
            function checkInstallComposer()
            {
                $("#output").append('\nloading...\n');
                $.post(url(),
                        {
                            "function": "getStatus"
			             },
                function(data) {
			        var parsed = JSON.parse(data);
                    if (parsed.composer)
                    {   console.log('yes');
                        $("#output").html("Ready. All commands are available.\n");
                        $("button").removeClass('disabled');
                    }
                    /*else if(data.composer)
                    {
                        $.post(url(),
                                {
                                    "password": $("#password").val(),
                                    "function": "extractComposer",
                                },
                                function(data) {
                                    $("#output").append(data);
                                    window.location.reload();
                                }, 'text');
                    }*/
                    else
                    {
                        $("#output").html("Composer is not installed...\n");
                       
                    }
                });
            }
        </script>
<style>
#output
{
  width:100%;
  height:350px;
  overflow-y:scroll;
  overflow-x:hidden;
}
</style>
@stop