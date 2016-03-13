/**function edit search **/

    function EditSearch(){
    var thArray = $("#table_contents thead tr").map(function(index,elem) {
                  var ret = [];
                  var x = $(this);
                  var cells = x.find('th#col_content');
                  $(cells, this).each(function () {
                      var d = $(this).val()||$(this).text();
                      ret.push(d);
                  });
                  return ret;
                });

      var tdArray=new Array();
      var parent=$(this).parent().parent();
          $(parent).children('td#row_content').each(function(i,td) {
              tdArray.push($(this).text());
          });

      var inputData = new Array();
      for (i = 0; i < thArray.length; i++){ 
           inputData[thArray[i]]=tdArray[i];
      }
      
      $.ajax({
                  type: 'get',
                  data : any2url('q',inputData),
                  dateType:'json',
                  url: "/admin/search/edit",
                   success: function(data) {
                	   console.log(data);
                       var parsed = JSON.parse(data);
                       window.location.href = parsed.datas.uri;
                  },
                  error: function(xhr, textStatus, thrownError) {
                      alert(thrownError);
                      alert('Something went to wrong.Please Try again later...');
                  }
                 
              });
    }

   