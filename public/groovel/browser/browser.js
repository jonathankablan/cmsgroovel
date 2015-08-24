

var groovelDialogue = {
    
     init : function () {
          // remove tinymce stylesheet.
        var allLinks = document.getElementsByTagName("link");
        allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
    },
     fileSubmit : function (FileURL) {
        var URL = FileURL;
        var win = top.tinymce.activeEditor.windowManager.getParams().window;
        win.document.getElementById(top.tinymce.activeEditor.windowManager.getParams().input).value = URL;
        top.tinymce.activeEditor.windowManager.close();
    }
}  




/*This file contains one main function which accepts one argument(params as Object) and 3 child functions for internal use.
params object can holds the following properties:
contentsDisplay: html element reference, where the folder contents will be listed.
currentPath: String, represents the base_dir related path (you type the path as you are in the base_dir set in the php code).
filter: String/html element reference, that hold comma separated file types (extensions) to be displayed.
loadingMessage: String, the message to be displayed in the pathDisplay while loading folder contents.
pathDisplay: html element reference, this is where the current folder path will appear.
pathMaxDisplay: Number, the maximum characters to be shown in the pathDisplay element.
refreshButton: html element reference, the refresh button.
openFolderonselect: Boolean, open selected folder once selected.
onselect: Function, fired on selecting an item and accepts one object argument which has 4 properties: (type:file type,path:file path,title:file name, item:clicked html element)
data: string, any extra information you may want to pass to the php file (maybe a file browser identity so the base_dir can change accordingly)*/



function browser(params){
	if(params==null)params={};
	if(params.contentsDisplay==null)params.contentsDisplay=document.body;
	if(params.currentPath==null)params.currentPath="";
	if(params.filter==null)params.filter="";
	if(params.loadingMessage==null)params.loadingMessage="Loading...";
	if(params.data==null)params.data="";
/*Show loading message if possible.
Get the filter.
Send a request to the search_dir.php file and receive the result in the showFiles function
Add click event to the refresh button if assigned.
*/
	var search=function(){
		if(params.pathDisplay!=null)params.pathDisplay.innerHTML=params.loadingMessage;
		
		var f=typeof(params.filter)=="object"?params.filter.value:params.filter;
		var a=new Ajax();
		with (a){
			Method="POST";
			URL=window.location.toString()+"/explore";
			//console.log(URL);
			Data="path="+params.currentPath+"&filter="+f+"&data="+params.data;
			ResponseFormat="json";
			ResponseHandler=showFiles;
			Send();
		}
	}
	
	if(params.refreshButton!=null)params.refreshButton.onclick=search;
	/*Get the current folder path received from server.
	Remove unnecessary (./ , ../ , .) from the beginning of the path.
	subtract the last pathMaxDisplay if applicable.
	Display the path in the pathDisplay.
	Clear the contentsDisplay contents.
	Declare the oddeven variable to hold the row's odd/even class.
	Loop the contents.
	Create a paragraph for each element (el) in the contents.
	Set the title, fPath, fType attributes.
	Set the class name depending on the file type and the odd/even status.
	Display the file name in the (el) innerHTML.
	Append the paragraph (el) to the (contentsDisplay).
	Swap the oddeven variable.
	Add click event to the (el) to call the selectItem function*/
	var showFiles=function(res){
		//console.log('show files');
		if(params.pathDisplay!=null){
			var p=res.currentPath;
			p=p.replace(/^(\.\.\/|\.\/|\.)*/g,"");
			
			if(params.pathDisplay!=null){
				params.pathDisplay.title=p;
				if(params.pathMaxDisplay!=null){
					if(p.length>params.pathMaxDisplay)p="..."+p.substr(p.length-params.pathMaxDisplay,params.pathMaxDisplay);
				}
				params.pathDisplay.innerHTML="[Rt:\] "+p;
			}
		}
		
		params.contentsDisplay.innerHTML="";
		var oddeven="odd";
		
		for (i=0;i<res.contents.length;i++){
			var f=res.contents[i];
			var el=document.createElement("p");
			with(el){
				setAttribute("title",f.fName);
				setAttribute("fPath",f.fPath);
				setAttribute("fType",f.fType);
				className=oddeven + " item ft_"+f.fType;
				innerHTML=f.fName;
			}
			params.contentsDisplay.appendChild(el);
			oddeven=(oddeven=="odd")?"even":"odd";
			el.onclick=selectItem;
		}
	}
/*
 * This function will be fired whenever the user clicks an item.
Get the ftype, fpath and title attribute we previously assigned to each element.
Call onselect function if assigned and pass it two arguments: an object has these properties: file type, file path, file title and the html element itself,
 and the params object.
If selected item is a folder and openSelectedFolder property is set to true then set the browser current path to this folder and open it by calling (search) function.
 */
	var selectItem=function(){
		var ftype=this.getAttribute("fType");
		var fpath=this.getAttribute("fPath");
		var ftitle=this.getAttribute("title");

		if(params.onSelect!=null)params.openFolderOnSelect=params.onSelect({"type":ftype,"path":fpath,"title":ftitle,"item":this},params);
		if(params.openFolderOnSelect==null)params.openFolderOnSelect=true;

		if(ftype=="folder" && params.openFolderOnSelect){
			params.currentPath=fpath;
			search();
		}
	}

	search();
}