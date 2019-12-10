<div class="modal fade" id="modal-create">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Create New</h4>
         </div>
         <form id="form-create">
            <div class="modal-body">
               <div class="form-group">
                  <label>Group Name</label>
                  <input type="text" class="form-control" name="name" required="">
               </div>
               <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Submit</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-modify">
   <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Groups</h4>
         </div>
         <form id="form-modify">
            <input type="hidden" name="id">
            <div class="modal-body">
               <div class="form-group">
                  <label>Group Name</label>
                  <input type="text" class="form-control" name="name" required="">
               </div>
               <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> Change</button> 
            </div>
         </form>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-object-group"></i> List Groups</div>
            <div class="panel-options" style="width: auto;border:0px solid black;">
               <div class="form-group" style="margin-top: 8px;margin-bottom: 5px;">  
                  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> New</button>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <input type="hidden" id="offset" value="0">
            <input type="hidden" id="curpage" value="1">
            <table class="table">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Description</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody id="sect-data"></tbody>
            </table>
            <div class="row">
               <div class="col-md-3">
                  <h4 id="sect-total" class="text-left"></h4>
               </div>
               <div class="col-md-9">
                  <ul id="sect-pagination" class="pagination pagination-sm no-margin pull-right"></ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>  

<script type="text/javascript">
   var sessions = '#<?php echo $this->ion_auth->logged_in() ?>';
   var loading = '<i class="fa fa-spinner fa-spin"></i>';
   var overlay = '<h3 class="text-center text-danger overlay"><i class="fa fa-spinner fa-spin"></i></h3>';

   $(function () {
      $('.choose').select2();

      $.fn.render_data = function(params) {
         var p = $.extend({
            offset: $('#offset').val(),
            currentPage : $('#curpage').val()
         }, params);
         ajaxManager.addReq({
            url: site_url + '/group_management/render_data',
            type: 'GET',
            dataType: 'JSON',
            data: {
               offset : p.offset
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('#sect-data').html('<tr><td colspan="5"><h1 class="text-center text-danger">'+loading+'</h1></td></tr>');
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success: function(r) {
               var t = '';
               if(r.total > 0){
                  $.each(r.response, function(k ,v) {
                     t += '<tr>';
                     t += '<td>'+v.name+'</td>';
                     t += '<td>'+v.description+'</td>';
                     t += '<td>';
                        t += '<div class="btn-group">';
                           t += '<button class="btn btn-white btn-delete btn-sm" data-toggle="tooltip" data-original-title="Delete" data-id="'+v.id+'"><i class="fa fa-trash"></i></button>';
                           t += '<button class="btn btn-white btn-edit btn-sm" data-toggle="tooltip" data-original-title="Edit" data-id="'+v.id+'"><i class="fa fa-edit"></i></button>';
                        t += '</div>';
                     t += '</td>';
                     t += '</tr>';
                  });
               }else{
                  t += '<tr><td colspan="6"><h4 class="text-center">No Result</h4></td></tr>';
               }
               $('#sect-data').html(t);
               $('#sect-total').html('Total : ' + r.total);
               $('#sect-pagination').paging({
                  items : r.total,
                  currentPage : p.currentPage
               });
               $('#offset').val(p.offset);
               $('#curpage').val(p.currentPage);
            }
         });
      }

      $(this).on('click', '.btn-edit', function(e) {
         var id = $(this).data('id');
         var form = $('#form-modify');

         ajaxManager.addReq({
            url: site_url + '/group_management/edit',
            type: 'GET',
            dataType: 'JSON',
            data: {
               id : id
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.btn-edit[data-id="'+id+'"]').addClass('disabled');
                  $('.btn-edit[data-id="'+id+'"]').html(loading);
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               $('.btn-edit[data-id="'+id+'"]').removeClass('disabled');
               $('.btn-edit[data-id="'+id+'"]').html('<i class="fa fa-edit"></i>');

               form.find('textarea[name="description"]').html(r.response.description);
               form.find('input[name="name"]').val(r.response.name);
               form.find('input[name="id"]').val(r.response.id);
               $('#modal-modify').modal('show');
            }
         });
         e.preventDefault();
      });

      $(this).on('click', '.btn-delete', function(e) {
         var id = $(this).data('id');

         ajaxManager.addReq({
            url: site_url + '/group_management/delete',
            type: 'GET',
            dataType: 'JSON',
            data: {
               id : id
            },
            beforeSend: function (xhr) {
               if(sessions){
                  $('.btn-delete[data-id="'+id+'"]').addClass('disabled');
                  $('.btn-delete[data-id="'+id+'"]').html(loading);
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               $('.btn-delete[data-id="'+id+'"]').removeClass('disabled');
               $('.btn-delete[data-id="'+id+'"]').html('<i class="fa fa-trash"></i>');
               if(r.success){
                  $('#offset').val(0);
                  $('#curpage').val(1);
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
            }
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-create', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            url: site_url + '/group_management/create',
            data:{
               'csrf_token_nalda' : $('#csrf').val()
            },
            type: 'POST',
            dataType: 'JSON',
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  form.find('[type="submit"]').addClass('disabled');
                  form.find('[type="submit"]').html(loading);  
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  $('#offset').val(0);
                  $('#curpage').val(1);
                  $('#modal-create').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-save"></i> Submit');
            },
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-modify', function(e) {
         var form = $(this);
         $(this).ajaxSubmit({
            url: site_url + '/group_management/change',
            data:{
               'csrf_token_nalda' : $('#csrf').val()
            },
            type: 'POST',
            dataType: 'JSON',
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-edit"></i> Change');
            },
            beforeSend: function (xhr) {
               if(sessions){
                  form.find('[type="submit"]').addClass('disabled');
                  form.find('[type="submit"]').html(loading);  
               }else{
                  xhr.done();
                  window.location.href = location; 
               }
            },
            success: function(r) {
               $('#csrf').val(r.csrf);
               if(r.success){
                  form.resetForm();
                  $('#offset').val(0);
                  $('#curpage').val(1);
                  $('#modal-modify').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               form.find('[type="submit"]').removeClass('disabled');
               form.find('[type="submit"]').html('<i class="fa fa-edit"></i> Change');
            },
         });
         e.preventDefault();
      });

      $(this).render_data();

      $.fn.paging = function (opt) {
         var s = $.extend({
            items: 0,
            itemsOnPage: 10,
            currentPage: 1
         }, opt);

         $('#sect-pagination').pagination({
            items: s.items,
            itemsOnPage: s.itemsOnPage,
            prevText: '&laquo;',
            nextText: '&raquo;',
            hrefTextPrefix: '#',
            currentPage: s.currentPage,
            onPageClick: function (n, e) {
               e.preventDefault();
               var offset = (n - 1) * s.itemsOnPage;
               $(this).render_data({
                  offset: offset,
                  currentPage: n,
               });
            }
         });
      };

   });
</script>