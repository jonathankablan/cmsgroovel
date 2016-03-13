<!DOCTYPE html>
<html>
<head>
<title> File Browser</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<!-- <script type="text/javascript" src="ajax.js"></script>-->
<!-- <script type="text/javascript" src="browser.js"></script>-->
{!! HTML::script('groovel/cmsgroovel/groovel/browser/ajax.js') !!}
{!! HTML::script('groovel/cmsgroovel/groovel/browser/browser.js') !!}
{!!HTML::style('groovel/cmsgroovel/groovel/browser/styles.css')!!}
 
<script type="text/javascript">
function init(){
browser({
	contentsDisplay:document.getElementById("dvContents"),
	refreshButton:document.getElementById("btnrefresh"),
	pathDisplay:document.getElementById("pPathDisplay"),
	filter:document.getElementById("txtFilter"),
	openFolderOnSelect:true,
	onSelect:function(item,params){
		/*if(item.type=="folder")
			return confirm("Do you want to open this Folder : "+item.path);
		else
			alert("You selected :"+item.path)*/
		if(item.type!="folder"){
			groovelDialogue.fileSubmit("http://"+window.location.hostname+"/"+params.currentPath+"/"+item.title);
		}
	},
	currentPath:"/"
	});
}
</script>

</head>
<body onload="init()">
<div class="browser">
	<p class="pfilter">File types filter
		<input type="text" id="txtFilter" value=""/>
		<input type="button" value="Refresh" id="btnrefresh"/>
	</p>
	<p id="pPathDisplay" class="pPathDisplay">Loading...</p>
	<div id="dvContents" class="dvContents">&nbsp;</div>
	<input type="hidden" id="token" value="{{ csrf_token() }}">
</div>
</body>
</html>