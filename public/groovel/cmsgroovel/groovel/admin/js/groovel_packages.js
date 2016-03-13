function UpdatePackage(){
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'update';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			alert('package has been updated');
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}

function DumpAutoloadPackage() {
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'dump-autoload';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			alert('package has been refresh');
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});

}
function removePackage(){
	
	
	
}

function InstallPackage(){
	var thArray = $("#table_packages thead tr").map(function(index, elem) {
		var ret = [];
		var x = $(this);
		var cells = x.find('th#col_package');
		$(cells, this).each(function() {
			var d = $(this).val() || $(this).text();
			ret.push(d);
		});
		return ret;
	});

	var tdArray = new Array();
	var parent=$(this).parent().parent();
	
	 $(parent).children('td#row_package').each(function(i,td) {
         tdArray.push($(this).text());
     });
	
	var inputData = new Array();
	for (i = 0; i < thArray.length; i++) {
			inputData[thArray[i]] = tdArray[i];
	}
	inputData['function'] = 'install';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			alert('package has been installed');
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}



function ArtisanCacheClear(){
	var inputData = new Array();
	inputData['function'] = 'artisan-cache-clear';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			alert('cache has been cleared');
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
}


function ArtisanDumpAutoload(){
	var inputData = new Array();
	inputData['function'] = 'artisan-dump-autoload';
	$.ajax({
		type : 'get',
		data : any2url('q', inputData),
		url : "packages/composer",
		success : function(data) {
			alert('artisan dump autoload done');
		},
		error : function(xhr, textStatus, thrownError) {
			alert(thrownError);
			alert('Something went to wrong.Please Try again later...');
		}

	});
	
}
