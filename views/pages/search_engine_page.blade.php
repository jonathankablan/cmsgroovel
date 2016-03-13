@extends('cmsgroovel.layouts.groovel_admin_default')
@section('content')
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      	    {!! Form::open(array('id'=>'search_form','url' => '/admin/search/execute', 'class' => 'form-horizontal well ','style'=>'width:850px')) !!}
		
			{!! Form::text('search',\Input::old('search'), $attributes = array('class' => 'search','style'=>'width:450px;margin-left:90px')) !!}
		    {!! Form::submit('Search',array('id'=>'submitForm','class'=>'btn btn-default'))!!} 
		  {!! Form::close() !!}		 	 
   	</div>
   	 <table class='table' style='margin-left:150px'>	 
   	 <tbody id='result'></tbody>
   	 </table>
<script>
$("#submitForm").click(function (event) {
	var form=$('#search_form').serialize();
	$.post('/admin/search/execute', form, function (data, textStatus) {
		var div = document.getElementById('result');
		div.innerHTML=null;
		for (var i in data){
			var parsed = JSON.parse(data[i]);
			//console.log(parsed);
			if(parsed['type']=='CONTENT'){
				var div = document.getElementById('result');
				div.style='margin-left:200px;margin-top:10px';
				var tr=document.createElement('tr');
				tr.style='margin-left:300px;margin-top:60px';
				var td=document.createElement('td');
				td.innerHTML='title: '+parsed['title'];
				tr.appendChild(td);

				var td=document.createElement('td');
				td.innerHTML=parsed['refid'];
				tr.appendChild(td);
				
				var td=document.createElement('td');
				td.innerHTML=parsed['data'];
				tr.appendChild(td);
	
				var td=document.createElement('td');
				td.innerHTML=parsed['description'];
				tr.appendChild(td);
	
				var td=document.createElement('td');
				td.innerHTML='created at: '+parsed['created_at']['date'];
				tr.appendChild(td);
	
				var td=document.createElement('td');
				td.innerHTML='last update at: '+parsed['updated_at']['date'];
				tr.appendChild(td);
				div.appendChild(tr);
			}else if(parsed['type']=='USER'){
				var div = document.getElementById('result');
				div.style='margin-left:200px;margin-top:10px';
				var tr=document.createElement('tr');
				tr.style='margin-left:300px;margin-top:60px';
				var td=document.createElement('td');
				td.innerHTML='username: '+parsed['title'];
				tr.appendChild(td);

				var td=document.createElement('td');
				td.innerHTML=parsed['refid'];
				tr.appendChild(td);
				
				var td=document.createElement('td');
				td.innerHTML=parsed['data'];
				tr.appendChild(td);
				
				var td=document.createElement('td');
				td.innerHTML=parsed['description'];
				tr.appendChild(td);
	
				var td=document.createElement('td');
				td.innerHTML='created at: '+parsed['created_at']['date'];
				tr.appendChild(td);
	
				var td=document.createElement('td');
				td.innerHTML='last update at: '+parsed['updated_at']['date'];
				tr.appendChild(td);
				div.appendChild(tr);
			}
		}
		
	 });
	
	return false;
})
</script>
   	
   	
   	
<style>
form {
                width:700px;
                margin:50px auto;
}
.search {
                padding:8px 15px;
                background:#FFFFFF;
                border:0px solid #dbdbdb;
                width:500px;
}
.button {
                position:relative;
                padding:6px 15px;
                left:-8px;
                border:2px solid #207cca;
                background-color:#207cca;
                color:#fafafa;
}
.button:hover  {
                background-color:#fafafa;
                color:#207cca;
}
</style>
@stop