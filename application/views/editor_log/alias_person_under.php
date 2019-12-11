<style type="text/css">
   .dropdown-menu > li > a{
      padding: 3px 10px;
   }
   input[type="radio"], input[type="checkbox"]{
      margin:0px;
   }
</style>
<h3 style="margin-top: -10px;" class="text-muted"><?php echo $title['name'] ?></h3>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-invert" data-collapsed="0">
         <div class="panel-heading">
            <!-- <div class="panel-title"><i class="<?php echo $title['icon'] ?>"></i> <?php echo $title['name'] ?></div> -->
            <div class="panel-options" style="width: auto">
               <div class="form-group" style="margin-top:6px;margin-bottom: 5px;"> 
                  <!-- <div class="btn-group dropdown-default"> 
                     <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-import"><i class="fa fa-download"></i> Download Alias</button>
                  </div>
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-upload"></i> Upload Alias</button>
                  </div> -->
                  <div class="btn-group" data-toggle="buttons">
                     <button type="button" class="btn btn-primary btn-sm disabled bold">Common : </button>
                     <label class="btn btn-primary btn-sm active"><input type="radio" name="filter_common" class="filter_common" value="" checked="">All</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_common" class="filter_common" value="1">Yes</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_common" class="filter_common" value="2">No</label>                
                  </div>
                  <div class="btn-group" data-toggle="buttons">
                     <button type="button" class="btn btn-primary btn-sm disabled bold">Blacklist : </button>
                     <label class="btn btn-primary btn-sm active"><input type="radio" name="filter_blacklist" class="filter_blacklist" value="" checked="">All</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_blacklist" class="filter_blacklist" value="1">Yes</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_blacklist" class="filter_blacklist" value="2">No</label>                
                  </div>
                  <div class="btn-group" data-toggle="buttons">
                     <button type="button" class="btn btn-primary btn-sm disabled bold">Master : </button>
                     <label class="btn btn-primary btn-sm active"><input type="radio" name="filter_master" class="filter_master" value="" checked="">All</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_master" class="filter_master" value="1">Yes</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_master" class="filter_master" value="2">No</label>                
                  </div>
                  <div class="btn-group" data-toggle="buttons">
                     <button type="button" class="btn btn-primary btn-sm disabled bold">Alias : </button>
                     <label class="btn btn-primary btn-sm active"><input type="radio" name="filter_alias" class="filter_alias" value="" checked="">All</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_alias" class="filter_alias" value="1">Yes</label>
                     <label class="btn btn-primary btn-sm"><input type="radio" name="filter_alias" class="filter_alias" value="2">No</label>                
                  </div>
                  <div class="btn-group dropdown-default" style="width: 123px;"> 
                     <div class="input-group">
                        <div class="input-group-addon" style="background-color: #222222;border: 1px solid #525252;color:#fff;"><i class="fa fa-calendar"></i></div>
                        <input type="hidden" id="filter_date" value="<?php echo date('Y-m-d') ?>">
                        <input type="text" class="form-control input-sm filter_date" value="<?php echo date('d/M/Y') ?>" style="color: #fff;background-color: #222222;border: 1px solid #525252;">
                     </div>
                  </div>
                  <div class="btn-group dropdown-default" style="display: none;">
                     <input type="text" id="filter_keyword" class="form-control input-sm" placeholder="Search Alias Name Here..."> 
                  </div>
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-sm btn-primary btn-filter"><i class="fa fa-filter"></i> Filter</button>
                  </div>
                  <div class="btn-group dropdown-default"> 
                     <button class="btn btn-sm btn-primary btn-modal-search-alias" data-toggle="modal" data-target="#modal-search-alias"><i class="fa fa-search"></i> Search Alias</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-body" id="cont-data">
            <div class="row">
               <div class="col-md-9">
                  <div class="row sect-data">
                  </div>
                  <div class="row" style="margin-top: 3px;">
                     <div class="col-md-6">
                        <h4 class="sect-total"></h4>
                     </div>
                     <div class="col-md-6">
                        <ul class="sect-pagination pagination pagination-sm no-margin pull-right"></ul> 
                     </div>
                  </div>
               </div>
               <div class="col-md-3" style="">
                  <form id="form-update-master" style="border:1px solid #3c3c3c;padding:5px;">
                     <h5 class="text-center bold">Used as Master</h5>
                     <ul class="list-group sect-used"></ul>
                     <h5 class="text-center bold">Selected as Alias</h5>
                     <ul class="list-group sect-selected"></ul>
                     <button type="submit" class="btn btn-primary btn-block btn-sm">Apply</button>
                     <button type="button" class="btn btn-primary btn-block btn-sm btn-clear">Clear</button>
                  </form>
                  <div style="border:1px solid #3c3c3c;padding:5px;margin-top: 5px;text-align: center;">
                     <div class="row">
                        <div class="col-md-6">
                           <h5 class="text-left bold">Bulk Master</h5>
                        </div>
                        <div class="col-md-6">
                           <div class="btn-group">
                              <button type="button" class="btn btn-primary btn-sm btn-add-master">Apply</button>
                              <button type="button" class="btn btn-primary btn-sm btn-bulk-remove-master">Remove</button> 
                           </div>
                        </div>
                     </div>
                  </div>
                  <div style="border:1px solid #3c3c3c;padding:5px;margin-top: 5px;text-align: center;">
                     <div class="row">
                        <div class="col-md-6">
                           <h5 class="text-left bold">Common Name</h5>
                        </div>
                        <div class="col-md-6">
                           <div class="btn-group">
                              <button type="button" class="btn btn-primary btn-sm btn-add-common">Apply</button>
                              <button type="button" class="btn btn-primary btn-sm btn-remove-common">Remove</button>  
                           </div>
                        </div>
                     </div>
                  </div>
                  <div style="border:1px solid #3c3c3c;padding:5px;margin-top: 5px;text-align: center;">
                     <div class="row">
                        <div class="col-md-6">
                           <h5 class="text-left bold">Blacklist</h5>
                        </div>
                        <div class="col-md-6">
                           <div class="btn-group">
                              <button type="button" class="btn btn-primary btn-sm btn-add-blacklist">Apply</button>
                              <button type="button" class="btn btn-primary btn-sm btn-remove-blacklist">Remove</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-search-alias">
   <div class="modal-dialog" style="width: 55%;">
      <div class="modal-content" style="background-color: #222222;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Search Alias</h4>
         </div>
         <div class="modal-body" id="cont-data-search">
            <div class="form-group">
               <input type="text" id="search_keyword" class="form-control" placeholder="search here...">
            </div>
            <div class="row sect-data-search" style="max-height: 335px;overflow: auto;"></div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-primary btn-block btn-search-alias"><i class="fa fa-search"></i> Search</button>
         </div>
      </div>
   </div>
</div>



<script type="text/javascript">

   _offset = 0;
   _curpage = 1;

   // _offset_after_search = 0;
   // _curpage_after_search = 1;
   // _after_search = false;
   // _date = null;

   
   var loading = '<h2 class="text-danger text-center"><i class="fa fa-spinner fa-spin"></i></h2>';

   function clearPaging(){
      _offset = 0;
      _curpage = 1;
   }

   $(function () {

      $.fn.render_data = function(params){
         $panel = $('#cont-data');
         var str = $.extend({
            offset : _offset,
            curpage : _curpage,
            filter_keyword : $('#filter_keyword').val(),
            filter_common : $('input[name=filter_common]').filter(':checked').val(),
            filter_blacklist : $('input[name=filter_blacklist]').filter(':checked').val(),
            filter_master : $('input[name=filter_master]').filter(':checked').val(),
            filter_alias : $('input[name=filter_alias]').filter(':checked').val(),
            filter_date : $('#filter_date').val(),
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/getAliasUnder',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
               filter_date : str.filter_date,
               filter_common : str.filter_common,
               filter_blacklist : str.filter_blacklist,
               filter_master : str.filter_master,
               filter_alias : str.filter_alias,
               type : 1
            },
            beforeSend: function (xhr) {
               $panel.find('.sect-data').html(loading);
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               var t = '';
               if(r.total > 0){
                  var data  = r.result;
                  t += '<table class="table">';
                  t += '<tbody>';
                  for(var i = 0; i < data.length; i++){
                     t += '<tr>';
                        t += '<td class="alias-'+data[i].id+'"><input type="checkbox" class="common_name" value="'+data[i].id+'"> '+data[i].alias+'</td>';
                        t += '<td>';
                        t += '<div class="btn-group">';
                        if(data[i].id_alias_master){
                           t += '<button type="button" class="btn btn-success btn-xs btn-remove-master" data-id="'+data[i].id_alias_master+'">M</button>';   
                        }
                        if(data[i].id_alias_parent){
                           t += '<button type="button" class="btn btn-info btn-xs btn-remove-alias" data-id="'+data[i].id_alias_parent+'">A</button>';   
                        }
                        if(data[i].common_name){
                           t += '<button type="button" class="btn btn-default btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="common_status">C</button>';   
                        }
                        if(data[i].blacklist_name){
                           t += '<button type="button" class="btn btn-danger btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="blacklist_status">B</button>';   
                        }
                        t += '<button type="button" class="btn btn-primary btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                        t += '<button type="button" class="btn btn-primary btn-xs used-alias" data-id="'+data[i].id+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-total="'+data[i].total_news+'">Used</button>';
                        t += '</div>';
                        t += '</td>';
                        i++;
                        t += '<td></td>';
                        if(i < data.length){
                           t += '<td class="alias-'+data[i].id+'"><input type="checkbox" class="common_name" value="'+data[i].id+'"> '+data[i].alias+'</td>';
                           t += '<td>';
                           t += '<div class="btn-group">';
                           if(data[i].id_alias_master){
                              t += '<button type="button" class="btn btn-success btn-xs btn-remove-master" data-id="'+data[i].id_alias_master+'">M</button>';   
                           }
                           if(data[i].id_alias_parent){
                              t += '<button type="button" class="btn btn-info btn-xs btn-remove-alias" data-id="'+data[i].id_alias_parent+'">A</button>';   
                           }
                           if(data[i].common_name){
                              t += '<button type="button" class="btn btn-default btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="common_status">C</button>';   
                           }
                           if(data[i].blacklist_name){
                              t += '<button type="button" class="btn btn-danger btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="blacklist_status">B</button>';   
                           }
                           t += '<button type="button" class="btn btn-primary btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                           t += '<button type="button" class="btn btn-primary btn-xs used-alias" data-id="'+data[i].id+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-total="'+data[i].total_news+'">Used</button>';
                           t += '</div>';
                           t += '</td>';
                           i++;
                           t += '<td></td>';
                           if(i < data.length){
                              t += '<td class="alias-'+data[i].id+'"><input type="checkbox" class="common_name" value="'+data[i].id+'"> '+data[i].alias+'</td>';
                              t += '<td>';
                              t += '<div class="btn-group">';
                              if(data[i].id_alias_master){
                                 t += '<button type="button" class="btn btn-success btn-xs btn-remove-master" data-id="'+data[i].id_alias_master+'">M</button>';   
                              }
                              if(data[i].id_alias_parent){
                                 t += '<button type="button" class="btn btn-info btn-xs btn-remove-alias" data-id="'+data[i].id_alias_parent+'">A</button>';   
                              }
                              if(data[i].common_name){
                                 t += '<button type="button" class="btn btn-default btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="common_status">C</button>';   
                              }
                              if(data[i].blacklist_name){
                                 t += '<button type="button" class="btn btn-danger btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="blacklist_status">B</button>';   
                              }
                              t += '<button type="button" class="btn btn-primary btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                              t += '<button type="button" class="btn btn-primary btn-xs used-alias" data-id="'+data[i].id+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-total="'+data[i].total_news+'">Used</button>';
                              t += '</div>';
                              t += '</td>';
                           }
                        }
                     t += '</tr>';
                  }
                  t += '</tbody>';
                  t += '</table>';
               }else{
                  t += '<h3 class="text-center" style="color:#fff">No Result</h3>';
               }

               $panel.find('.sect-data').html(t);
               $panel.find('.sect-total').html("Total : " + r.total);
               $panel.find('.sect-pagination').paging({
                  items : r.total,
                  itemsOnPage : 30,
                  currentPage : str.curpage 
               });
               _offset = str.offset;
               _curpage = str.curpage;
               // if(str.filter_keyword != ''){
               //    _after_search = true;
               // }
               // if(_after_search == false){
               //    _offset_after_search = str.offset;
               //    _curpage_after_search = str.curpage;
               // }
               // alert(_after_search);
            }
         });
      };

      $(this).on('click', '.btn-modal-search-alias', function(e) {
         e.preventDefault();
         $('.sect-data-search').html('');
         $('#search_keyword').val('');
      });

      $(this).on('click', '.btn-search-alias', function(e) {
         e.preventDefault();
         var keyword = $('#search_keyword').val();
         $panel = $('#cont-data-search');

         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/searchAlias',
            dataType : "JSON",
            data : {
               keyword : keyword,
               date : $('#filter_date').val(),
               type : 1
            },
            beforeSend: function (xhr) {
               $panel.find('.sect-data-search').html(loading);
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               var t = '';
               if(r.total > 0){
                  var data  = r.result;
                  t += '<table class="table">';
                  t += '<tbody>';
                  for(var i = 0; i < data.length; i++){
                     t += '<tr>';
                        t += '<td class="alias-'+data[i].id+'"><input type="checkbox" class="common_name" value="'+data[i].id+'"> '+data[i].alias+'</td>';
                        t += '<td>';
                        t += '<div class="btn-group">';
                        if(data[i].id_alias_master){
                           t += '<button type="button" class="btn btn-success btn-xs btn-remove-master" data-id="'+data[i].id_alias_master+'">M</button>';   
                        }
                        if(data[i].id_alias_parent){
                           t += '<button type="button" class="btn btn-info btn-xs btn-remove-alias" data-id="'+data[i].id_alias_parent+'">A</button>';   
                        }
                        if(data[i].common_name){
                           t += '<button type="button" class="btn btn-primary btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="common_status">C</button>';   
                        }
                        if(data[i].blacklist_name){
                           t += '<button type="button" class="btn btn-danger btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="blacklist_status">B</button>';   
                        }
                        t += '<button type="button" class="btn btn-primary btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                        t += '<button type="button" class="btn btn-primary btn-xs used-alias" data-id="'+data[i].id+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-total="'+data[i].total_news+'">Used</button>';
                        t += '</div>';
                        t += '</td>';
                        i++;
                        t += '<td></td>';
                        if(i < data.length){
                           t += '<td class="alias-'+data[i].id+'"><input type="checkbox" class="common_name" value="'+data[i].id+'"> '+data[i].alias+'</td>';
                           t += '<td>';
                           t += '<div class="btn-group">';
                           if(data[i].id_alias_master){
                              t += '<button type="button" class="btn btn-success btn-xs btn-remove-master" data-id="'+data[i].id_alias_master+'">M</button>';   
                           }
                           if(data[i].id_alias_parent){
                              t += '<button type="button" class="btn btn-info btn-xs btn-remove-alias" data-id="'+data[i].id_alias_parent+'">A</button>';   
                           }
                           if(data[i].common_name){
                              t += '<button type="button" class="btn btn-primary btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="common_status">C</button>';   
                           }
                           if(data[i].blacklist_name){
                              t += '<button type="button" class="btn btn-danger btn-xs btn-remove-status" data-id="'+data[i].id+'" data-field="blacklist_status">B</button>';   
                           }
                           t += '<button type="button" class="btn btn-primary btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                           t += '<button type="button" class="btn btn-primary btn-xs used-alias" data-id="'+data[i].id+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-total="'+data[i].total_news+'">Used</button>';
                           t += '</div>';
                           t += '</td>';
                        }
                     t += '</tr>';
                  }
                  t += '</tbody>';
                  t += '</table>';
               }else{
                  t += '<h3 class="text-center">No Result</h3>';
               }

               $panel.find('.sect-data-search').html(t);
               $(this).prop('disabled', false);
               $(this).html('<i class="fa fa-search"></i> Search');
            }
         });
      });

      $.fn.parent_master  = function(params){
         var str = $.extend({
            id : null
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/getParentByMaster',
            dataType : "JSON",
            data : {
               id : str.id
            },
            beforeSend: function (xhr) {
               // $('.sect-selected').html(loading);
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
            success : function(r){
               var t = '';
               if(r.total > 0){
                  $.each(r.result, function(k,v){
                     t += '<li class="list-group-item text-info item-alias-'+v.alias_parent_no_spaces+'" style="border: 0px;background-color: #4c4c4c;padding:4px;color:#fff;">';
                        t += '<button type="button" class="btn btn-xs btn-primary btn-remove-selected" data-id="'+v.id+'"><i class="fa fa-remove"></i></button>&nbsp;';
                        t += ''+v.alias_parent+'';
                     t += '</li>';
                  });
                  $('.sect-selected').html(t);  
               }else{
                  $('.sect-selected').html(''); 
               }
            }
         });
      };

      $('.btn-add-common').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkCommon',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-add-common').prop("disabled", true);
                  $('.btn-add-common').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-add-common').prop('disabled', false);
                  $('.btn-add-common').html('Apply');
               },
               success: function (r) {
                  if(r.success){
                     $('.btn-add-common').prop('disabled', false);
                     $('.btn-add-common').html('Apply');
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $('.btn-add-master').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkMaster',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-add-master').prop("disabled", true);
                  $('.btn-add-master').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-add-master').prop('disabled', false);
                  $('.btn-add-master').html('Apply');
               },
               success: function (r) {
                  if(r.success){
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
                  $('.btn-add-master').prop('disabled', false);
                  $('.btn-add-master').html('Apply');
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $('.btn-add-blacklist').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkBlacklist',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-add-blacklist').prop("disabled", true);
                  $('.btn-add-blacklist').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-add-blacklist').prop('disabled', false);
                  $('.btn-add-blacklist').html('Apply');
               },
               success: function (r) {
                  if(r.success){
                     $('.btn-add-blacklist').prop('disabled', false);
                     $('.btn-add-blacklist').html('Apply');
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $('.btn-remove-common').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkRemoveCommon',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-remove-common').prop("disabled", true);
                  $('.btn-remove-common').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-remove-common').prop('disabled', false);
                  $('.btn-remove-common').html('Remove');
               },
               success: function (r) {
                  if(r.success){
                     $('.btn-remove-common').prop('disabled', false);
                     $('.btn-remove-common').html('Remove');
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $('.btn-bulk-remove-master').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkRemoveMaster',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-bulk-remove-master').prop("disabled", true);
                  $('.btn-bulk-remove-master').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-bulk-remove-master').prop('disabled', false);
                  $('.btn-bulk-remove-master').html('Remove');
               },
               success: function (r) {
                  if(r.success){
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
                  $('.btn-bulk-remove-master').prop('disabled', false);
                  $('.btn-bulk-remove-master').html('Remove');
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $('.btn-remove-blacklist').on('click', function(e) {
         var data = [];
         $('.common_name').each(function () {
            if (this.checked) {
                data.push($(this).val());
            }
         });
         if (data.length > 0) {
            ajaxManager.addReq({
               url: site_url + 'editor_log/bulkRemoveBlacklist',
               type: 'POST',
               dataType: 'JSON',
               data: {
                  data: data
               },
               beforeSend: function (xhr) {
                  $('.btn-remove-blacklist').prop("disabled", true);
                  $('.btn-remove-blacklist').html('<i class="fa fa-refresh fa-spin"></i>');  
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-remove-blacklist').prop('disabled', false);
                  $('.btn-remove-blacklist').html('Remove');
               },
               success: function (r) {
                  if(r.success){
                     $('.btn-remove-blacklist').prop('disabled', false);
                     $('.btn-remove-blacklist').html('Remove');
                     $('.common_name').removeAttr('checked'); 
                     $(this).render_data();
                     toastr.success(r.msg);
                  }else{
                     toastr.error(r.msg);
                  }
               }
            });
         } else {
            alert('No Data Selected');
         }
         e.preventDefault();
      });

      $(this).on('submit', '#form-upload', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'editor_log/uploadAlias',
            type : "POST",
            dataType : "JSON",
            data : {
               type : 1
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide', 'Apply');
            },
            beforeSend: function (xhr) {
               loading_form(form, 'show');
            },
            success: function(r) {
               if(r.success){
                  form.resetForm();
                  $('#modal-upload').modal('hide');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide', 'Apply');
            },
         });
         e.preventDefault();
      });

      $(this).on('submit', '#form-update-master', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'editor_log/updateMaster',
            type : "POST",
            dataType : "JSON",
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               loading_form(form, 'show');
            },
            success: function(r) {
               if(r.success){
                  $('.sect-used').html(''); 
                  $('.sect-selected').html('');
                  $(this).render_data();
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide', 'Apply');
            },
         });
         e.preventDefault();
      });


      $(this).on('click', '.used-alias', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var aliasreplaced = $(this).data('aliasreplaced');
         var aliasnoreplace = $(this).data('aliasnoreplace');
         var total = $(this).data('total');
         var alias = $('.alias-'+id+'').text();

         $(this).parent_master({
            id : id
         });

         var t = '';
         t += '<li class="list-group-item item-used-'+aliasnoreplace+'" style="border: 0px;background-color: #4c4c4c;padding:4px;">';
            t += '<input type="hidden" name="alias_master" value="'+id+'">';
            t += ''+alias+'';
         t += '</li>';
         $('.sect-used').html(t);
      });

      $(this).on('click', '.selected-alias', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var aliasreplaced = $(this).data('aliasreplaced');
         var aliasnoreplace = $(this).data('aliasnoreplace');
         var alias = $('.alias-'+id+'').text();
         if($('.item-alias-'+aliasnoreplace+'').length == 0){
            if($('.item-used-'+aliasnoreplace+'').length == 0){
               var t = '';
               t += '<li class="list-group-item item-alias-'+aliasnoreplace+'" style="border: 0px;background-color: #4c4c4c;padding:4px;">';
                  t += '<input type="hidden" name="alias_parent['+id+'][alias_parent]" value="'+id+'">';
                  t += '<button type="button" class="btn btn-xs btn-primary btn-remove-selected" data-id=""><i class="fa fa-remove"></i></button>&nbsp;';
                  t += ''+alias+'';
               t += '</li>';
               $('.sect-selected').prepend(t);  
            }
         }
      });

      $(this).on('click', '.btn-remove-selected', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         if(id != ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'editor_log/deleteMapping',
               dataType : "JSON",
               data : {
                  id : id,
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
               },
               success : function(r){
                  if(r.success){
                     $('.btn-remove-selected[data-id="'+id+'"]').parent().remove();
                  }else{
                     toastr.error('Gaga Menghapus Alias');
                  }
               }
            });
         }else{
            $(this).parent().remove();
         }
      });

      $(this).on('click', '.btn-remove-alias', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         if(id != ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'editor_log/deleteMapping',
               dataType : "JSON",
               data : {
                  id : id,
               },
               beforeSend: function (xhr) {
                  $('.btn-remove-alias[data-id="'+id+'"]').prop("disabled", true);
                  $('.btn-remove-alias[data-id="'+id+'"]').html('<i class="fa fa-refresh fa-spin"></i>'); 
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-remove-alias[data-id="'+id+'"]').prop("disabled", false);
                  $('.btn-remove-alias[data-id="'+id+'"]').html('A'); 
               },
               success : function(r){
                  if(r.success){
                     toastr.success('Alias Berhasil di Hapus');
                     $(this).render_data();
                     // $('.btn-remove-alias[data-id="'+id+'"]').remove();
                     // $('.btn-remove-alias[data-id="'+id+'"]').prop("disabled", false);
                     // $('.btn-remove-alias[data-id="'+id+'"]').html('A'); 
                  }else{
                     toastr.error('Gagal Menghapus Alias');
                  }
               }
            });
         }else{
            $(this).parent().remove();
         }
      });

      $(this).on('click', '.btn-remove-status', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var field = $(this).data('field');
         if(id != ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'editor_log/updateStatus',
               dataType : "JSON",
               data : {
                  id : id,
                  field : field,
               },
               beforeSend: function (xhr) {
                  $('.btn-remove-status[data-id="'+id+'"]').prop("disabled", true);
                  $('.btn-remove-status[data-id="'+id+'"]').html('<i class="fa fa-refresh fa-spin"></i>'); 
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-remove-status[data-id="'+id+'"]').prop("disabled", false);
                  $('.btn-remove-status[data-id="'+id+'"]').html('A'); 
               },
               success : function(r){
                  if(r.success){
                     toastr.success('Status Berhasil di Perbaharui');
                     $(this).render_data();
                  }else{
                     toastr.error('Gagal Merubah Status');
                  }
               }
            });
         }else{
            $(this).parent().remove();
         }
      });

      $(this).on('click', '.btn-remove-master', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         if(id != ''){
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'editor_log/deleteMaster',
               dataType : "JSON",
               data : {
                  id : id,
               },
               beforeSend: function (xhr) {
                  $('.btn-remove-master[data-id="'+id+'"]').prop("disabled", true);
                  $('.btn-remove-master[data-id="'+id+'"]').html('<i class="fa fa-refresh fa-spin"></i>'); 
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  $('.btn-remove-master[data-id="'+id+'"]').prop("disabled", false);
                  $('.btn-remove-master[data-id="'+id+'"]').html('M'); 
               },
               success : function(r){
                  if(r.success){
                     toastr.success('Master Berhasil di Hapus');
                     $(this).render_data();
                     // $('.btn-remove-master[data-id="'+id+'"]').remove();
                     // $('.btn-remove-master[data-id="'+id+'"]').prop("disabled", false);
                     // $('.btn-remove-master[data-id="'+id+'"]').html('M'); 
                  }else{
                     toastr.error('Gagal Menghapus Master');
                  }
               }
            });
         }else{
            alert('Parameter Tidak Ditemukan');
         }
      });
      
      $(this).on('click', '.btn-filter', function(e) {
         e.preventDefault();
         // var common = $('input[name=filter_common]').filter(':checked').val();
         // var blacklist = $('input[name=filter_blacklist]').filter(':checked').val();
         // var alias = $('input[name=filter_alias]').filter(':checked').val();
         // var master = $('input[name=filter_master]').filter(':checked').val();
         // var date = $('#filter_date').val();
         // // if(common == '' && blacklist == '' && alias == '' && master == '' && date == _date && _after_search == true){
         // if(common == '' && blacklist == '' && alias == '' && master == '' && _after_search == true){
         //    $(this).render_data({
         //       offset : _offset_after_search,
         //       curpage : _curpage_after_search
         //    });
         //    _after_search = false;
         // }else{
         //    clearPaging();
         //    $(this).render_data();   
         //    _after_search = false;
         // }
         // alert(_after_search);
         clearPaging();
         $(this).render_data();   
      });

      $(this).on('click', '.btn-clear', function(e) {
         $('.sect-used').html(''); 
         $('.sect-selected').html(''); 
      });

      $.fn.paging = function (opt) {
         var s = $.extend({
            items: 0,
            itemsOnPage: '',
            currentPage: 1
         }, opt);

         $('.sect-pagination').pagination({
            items: s.items,
            itemsOnPage: s.itemsOnPage,
            displayedPages: 1,
            edges: 0,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            hrefTextPrefix: '#',
            currentPage: s.currentPage,
            dropdown: true,
            onPageClick: function (n, e) {
               e.preventDefault();
               var offset = (n - 1) * s.itemsOnPage;
               _offset = offset;
               _curpage = n;
               // _offset_after_search = offset;
               // _curpage_after_search = n;
               $(this).render_data();
            }
         });
      };

      $('.filter_date').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.filter_date').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#filter_date').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.data_date').daterangepicker({
         parentEl : '#modal-upload',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.data_date').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#data_date').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.data_date_download').daterangepicker({
         parentEl : '#modal-import',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.data_date_download').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#data_date_download').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.data_date_download_edate').daterangepicker({
         parentEl : '#modal-import',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.data_date_download_edate').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#data_date_download_edate').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $(this).render_data();

   });

</script>