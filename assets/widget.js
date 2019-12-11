var Widget = {};
var loadajax = [];
var ajaxRunning = new Object;
Widget.Loader = function (module, data, containerId, load = true, callback) {
    var siteUrl = site_url.replace(/\/+$/, "");
    if (ajaxRunning[containerId]) {
        ajaxRunning[containerId].abort();
    }
    data.container = containerId;
   ajaxRunning[containerId] = $.ajax({
      url: siteUrl + '/' + module + '/widget/',
      type: 'GET',
      data: data,
      cache: true,
      dataType: 'json',
      beforeSend: function(){
        $('#' + containerId).html('<h2 class="text-danger text-center" style="color:#fff;"><i class="fa fa-refresh fa-spin"></i></h2>');  
      },
      error: function (jqXHR, status, errorThrown) {
         error_handle(jqXHR, status, errorThrown);
      },
      success: function (response) {
         if(response.sessionapp){
            if (response.css) {
               if (!$("link[href*='" + base_url + "assets/widgets/" + response.css + ".css']").length) {
                  $('head').append($('<link rel="stylesheet" type="text/css" />')
                             .attr('href', base_url + "assets/widgets/" + response.css + ".css?version=" + new Date().getTime()).load(function () {
                             }));
               }
            }
            $('#' + containerId).html(response.html).promise().done(function() {
               $.getScript( base_url + "assets/widgets/" + module + ".js?version=" + new Date().getTime(), function(){
                  $('[data-toggle="tooltip"]').tooltip();
                  if (typeof callback == "function") {
                     callback(response, '#' + containerId, data);
                  }
               });
            });
         }else{
            window.location.href = location;
         }
      },
      complete: function () {
        if(!load){
            // $('.refreshing').hide();
        }
      }
   });
};