var ajaxManager = (function() {
   var requests = [];

   return {
      addReq: function(opt) {
         requests.push(opt);
      },
      removeReq: function(opt) {
         if ($.inArray(opt, requests) > -1)
            requests.splice($.inArray(opt, requests), 1);
      },
      run: function() {
         var self = this,
            oriSuc;
         if (requests.length) {
            oriSuc = requests[0].complete;
            requests[0].complete = function() {
               if (typeof(oriSuc) === 'function') oriSuc();
               requests.shift();
               self.run.apply(self, []);
            };

            $.ajax(requests[0]);
         } else {
            self.tid = setTimeout(function() {
               self.run.apply(self, []);
            }, 1000);
         }
      },
      stop: function() {
         requests = [];
         clearTimeout(this.tid);
      }
   };
}());

function error_handle(jqXHR, status, errorThrown) {
   if (jqXHR.status === 0) {
      return alert('Not connect.\n Verify Network.');
   } else if (jqXHR.status == 404) {
      return alert('Requested page not found. [404]');
   } else if (jqXHR.status == 500) {
      return alert('Internal Server Error [500].');
   } else if (errorThrown === 'parsererror') {
      return alert('Requested JSON parse failed.');
   } else if (errorThrown === 'timeout') {
      return alert('Time out error.');
   } else if (errorThrown === 'abort') {
      return alert('Ajax request aborted.');
   } else {
      alert('Login session expired...');
      // window.location.href = location;
   }
}

function set_loading_table(container, colspan) {
   var loading = '<i class="fa fa-spinner fa-spin"></i>';
   return $(container).html('<tr><td colspan="' + colspan + '"><h1 class="text-center text-danger">' + loading + '</h1></td></tr>');
}

function set_no_result(colspan) {
   return '<tr><td colspan="' + colspan + '"><h4 class="text-center">No Result</h4></td></tr>';
}

function show_loading() {
   $('.loading').html(loading);
   $('.loading').show();
}

function hide_loading() {
   $('.loading').hide();
}

function notifications(container, style, position, message, type, timeout) {
   $(container).pgNotification({
      style: style,
      message: message,
      position: position,
      timeout: timeout,
      type: type
   }).show();
}

function loading_form(form, mode, label) {
   if (mode == 'show') {
      form.find('[type="submit"]').addClass('disabled');
      form.find('[type="submit"]').html('<i class="fa fa-refresh fa-spin"></i>');
   }
   if (mode == 'hide') {
      form.find('[type="submit"]').removeClass('disabled');
      if(label != ''){
         form.find('[type="submit"]').html(label);
      }else{
         form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
      }
   }
}

function loading_button(selector_name, id, mode, icon) {
   var loading = '<i class="fa fa-spinner fa-spin"></i>';
   if (icon == 'edit') {
      var icon_show = '<i class="fa fa-edit"></i>';
   }
   if (icon == 'delete') {
      var icon_show = '<i class="fa fa-trash"></i>';
   }
   if (mode == 'show') {
      $('' + selector_name + '[data-id="' + id + '"]').addClass('disabled');
      $('' + selector_name + '[data-id="' + id + '"]').html(loading);
   }
   if (mode == 'hide') {
      $('' + selector_name + '[data-id="' + id + '"]').removeClass('disabled');
      $('' + selector_name + '[data-id="' + id + '"]').html(icon_show);
   }

}

$(function() {
   ajaxManager.run();
   $('body').tooltip({ selector: '[data-toggle="tooltip"]' });

   // $.fn.paging = function (opt) {
   //    var s = $.extend({
   //       items: 0,
   //       itemsOnPage: 10,
   //       currentPage: 1,
   //       function_name: null,
   //       container: null
   //    }, opt);

   //    $(s.container).pagination({
   //       items: s.items,
   //       itemsOnPage: s.itemsOnPage,
   //       prevText: '&laquo;',
   //       nextText: '&raquo;',
   //       hrefTextPrefix: '#',
   //       currentPage: s.currentPage,
   //       onPageClick: function (n, e) {
   //          e.preventDefault();
   //          var offset = (n - 1) * s.itemsOnPage;
   //          $(this)+s.function_name+({
   //             offset: offset,
   //             currentPage: n
   //          });
   //       }
   //    });
   // };

});