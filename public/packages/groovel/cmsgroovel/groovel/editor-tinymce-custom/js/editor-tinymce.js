tinymce.init({
    selector: "textarea#elm1",
    theme: "modern",
    width: 600,
    height: 300,
    file_browser_callback : function GroovelFileBrowser (field_name, url, type, win) {

        // alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

        /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
           the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
           These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */
       // var cmsURL       = '/groovel/file/browser';
        var cmsURL = window.location.toString()+'/file/browser';    // script URL - use an absolute path!
       /* if (cmsURL.indexOf("?") < 0) {
            //add the type as the only query parameter
            cmsURL = cmsURL + "?type=" + type;
        }
        else {
            //add the type as an additional query parameter
            // (PHP session ID is now included if there is one at all)
            cmsURL = cmsURL + "&type=" + type;
        }*/
        tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Groovel File Browser',
            width : 420,  // Your dimensions may differ - toy around with them!
            height : 400,
            resizable : "yes",
            inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
            close_previous : "no"
        }, {
            window : win,
            input : field_name
        });
         return false;
      },
        
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
