<style type="text/css">
	.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus{
		background-color: #f3f3f3;
	}
</style>
<h3 style="margin-top: -10px;" class="text-muted"><?php echo $title['name'] ?></h3>
<div class="row">
   <div class="col-md-3">
      <div class="panel panel-primary" data-collapsed="0" id="cont-master">
         <div class="panel-heading">
         	<div class="panel-options" style="width: auto">
               <div class="form-group" style="margin-top:12px;margin-bottom: 5px;"> 
               	<div class="btn-group dropdown-default">
                     <input type="text" id="filter_keyword_master" class="form-control input-sm" placeholder="Search master name here..." style="width:260px"> 
                  </div>
            	</div>
         	</div>
     		</div>
     		<div class="panel-body" style="height: 392px;overflow: auto;">
  				<ul class="nav nav-pills nav-stacked sect-data" style="margin-top: -10px;"></ul>
  			</div>
  			<div class="panel-footer">
  				<h4 class="text-center bold">Top 100 Master</h4>
			</div>
  		</div>
	</div>
	<div class="col-md-9">
      <div class="panel panel-primary" data-collapsed="0" id="panel-detail">
     		<div class="panel-body" style="">
     			<div class="please-wait" style="">
     				<i class="fa fa-file" style="color: #9e9b9b;"></i>
     				<p class="" style="color: #9e9b9b;margin-left: -84px;">Click Master to Getting Start</p>
     			</div>
     			<ul class="nav nav-tabs bordered" style="margin-top: 0px;">
     				<li class="active">
     					<a href="#tab-alias" data-toggle="tab">
				         <span class="hidden-xs">Alias</span>
				      </a>
  					</li>
  					<li>
     					<a href="#tab-master" data-toggle="tab">
				         <span class="hidden-xs">Master Alias</span>
				      </a>
  					</li>
  				</ul>
  				<div class="tab-content">
					<div class="tab-pane active" id="tab-alias" style="">
						<div class="row">
							<div class="col-md-12">
								<div class="btn-group dropdown-default"> 
		                     <div class="input-group">
		                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		                        <input type="hidden" id="filter_date_alias" value="<?php echo date('Y-m-d') ?>">
		                        <input type="text" class="form-control input-sm filter_date_alias" value="<?php echo date('d/M/Y') ?>">
		                     </div>
		                  </div>
		                  <div class="btn-group dropdown-default">
		                     <input type="text" id="filter_keyword_alias" class="form-control input-sm" placeholder="Search alias here..." style="width:260px"> 
		                  </div>
		                  <div class="btn-group dropdown-default"> 
		                     <button class="btn btn-sm btn-blue btn-filter"><i class="fa fa-search"></i> Search</button>
		                  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9" style="margin-top: 10px;">
								<div class="row" id="cont-alias">
									<div class="col-md-12">
										<h5 class="text-muted bold">Keyword Criteria : <span class="keyword-criteria label label-default" style="font-size: 12px;"></span></h5>
									</div>
									<div class="col-md-12 sect-data-alias" style="height: 331px;overflow: auto;"></div>
								</div>
								<div class="row" style="margin-top: 3px;">
		                     <div class="col-md-12">
		                        <h4 class="sect-total text-center"></h4>
		                     </div>
		                  </div>
							</div>
							<div class="col-md-3" style="margin-top: 10px;">
								<form id="form-update-master" style="border:1px solid #e0e0e0;">
		                     <h5 class="text-center bold">Selected Names</h5>
		                     <ul class="list-group sect-selected"></ul>
		                     <button type="submit" class="btn btn-blue btn-block btn-sm">Apply</button>
		                     <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Clear</button>
		                  </form>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-master">
						<div class="row">
							<div class="col-md-12">
								<div class="btn-group dropdown-default" style="display: none;"> 
		                     <div class="input-group">
		                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		                        <input type="hidden" id="filter_date_alias_result" value="<?php echo date('Y-m-d') ?>">
		                        <input type="text" class="form-control input-sm filter_date_alias_result" value="<?php echo date('d/M/Y') ?>">
		                     </div>
		                  </div>
		                  <div class="btn-group dropdown-default">
		                     <input type="text" id="filter_keyword_alias_result" class="form-control input-sm" placeholder="Search alias here..." style="width:260px"> 
		                  </div>
		                  <div class="btn-group dropdown-default"> 
		                     <button class="btn btn-sm btn-blue btn-filter-result"><i class="fa fa-search"></i> Search</button>
		                  </div>
							</div>
						</div>
						<div class="row" id="cont-alias-result" style="margin-top: 10px;">
							<div class="col-md-12">
								<table class="table table-condensed">
									<thead>
										<th>Alias</th>
										<th>Data Date</th>
										<th>PIC</th>
										<th></th>
									</thead>
									<tbody class="sect-data-result"></tbody>
								</table>
							</div>
							<div class="col-md-6">
                        <h4 class="sect-total"></h4>
                     </div>
                     <div class="col-md-6">
                        <ul class="sect-pagination sect-pagination-result pagination-sm no-margin pull-right"></ul> 
                     </div>
						</div>
					</div>
				</div>
  			</div>
  		</div>
	</div>
</div>

<script type="text/javascript">

	_master_id = null;
	_offset_master = 0;
   _curpage_master = 1;
   _offset_alias_result = 0;
   _curpage_alias_result = 1;

	function clearPagingMaster(){
      _offset_master = 0;
      _curpage_master = 1;
   }

   function clearPagingAliasResult(){
      _offset_alias_result = 0;
      _curpage_alias_result = 1;
   }

	$(function () {
		
		$.fn.get_master = function(params){
			$panel = $('#cont-master');
			var str = $.extend({
            offset : _offset_master,
            curpage : _curpage_master,
            filter_keyword : $('#filter_keyword_master').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/getMaster',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_keyword : str.filter_keyword,
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
               	$.each(r.result, function(k,v){
               		t += '<li class="master-item">';
		             		t += '<a href="'+v.id+'">';
		                 		t += '<span class="text-danger media-name">'+v.master+'</span><br>';
		                 		t += '<span class="text-muted media-last-check">';
		                        t += '<small>Total Alias : '+v.total_alias+' | Added By : '+v.pic+'</small>';
		                    	t += '</span>';
		                	t += '</a>';
		            	t += '</li>';
            		});
            	}else{
            		t += '<h3 class="text-center">No Result</h3>';
            	}
            	$panel.find('.sect-data').html(t);
               $panel.find('.sect-total').html("Total : " + r.total);
               // $panel.find('.sect-pagination-master').paging_master({
               //    items : r.total,
               //    itemsOnPage : 10,
               //    currentPage : str.curpage 
               // });
               _offset_alias = str.offset;
               _curpage_alias = str.curpage;
         	}
         });
		};

		$.fn.get_alias = function(params){
			$panel = $('#cont-alias');
			var str = $.extend({
            offset : _offset_alias,
            curpage : _curpage_alias,
            master_id : _master_id,
            filter_keyword : $('#filter_keyword_alias').val(),
            filter_date : $('#filter_date_alias').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/getAliasByMaster',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_date : str.filter_date,
               filter_keyword : str.filter_keyword,
               master_id : str.master_id,
               type : 1
            },
            beforeSend: function (xhr) {
               $('#panel-detail').find('.please-wait').remove();
              	$('#panel-detail').append(loading);
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
                        t += '<td class="alias-'+data[i].id+'">'+data[i].alias+'</td>';
                        t += '<td>';
                        t += '<div class="btn-group">';
                        if(!data[i].alias_parent){
                        	t += '<button type="button" class="btn btn-default btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'"><i class="fa fa-plus"></i></button>';
                        }
                        t += '</div>';
                        t += '</td>';
                        i++;
                        t += '<td></td>';
                        if(i < data.length){
                           t += '<td class="alias-'+data[i].id+'">'+data[i].alias+'</td>';
                           t += '<td>';
                           t += '<div class="btn-group">';
                           if(!data[i].alias_parent){
                           	t += '<button type="button" class="btn btn-default btn-xs selected-alias" data-id="'+data[i].id+'" data-aliasnoreplace="'+data[i].alias_no_spaces+'" data-aliasreplaced="'+data[i].aliasreplaced+'" data-total="'+data[i].total_news+'"><i class="fa fa-plus"></i></button>';
                        	}
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
            	if(str.filter_keyword == ''){
            		$('.keyword-criteria').html(r.master_like_query);
            	}else{
            		$('.keyword-criteria').html(str.filter_keyword);
            	}
            	$('.sect-data-alias').html(t);
               $('.sect-total-alias').html("Total : " + r.total);
               $('#panel-detail').find('.please-wait').remove();
         	}
         });
		};

		$.fn.get_alias_result = function(params){
			$panel = $('#cont-alias-result');
			var str = $.extend({
            offset : _offset_alias_result,
            curpage : _curpage_alias_result,
            master_id : _master_id,
            filter_keyword : $('#filter_keyword_alias_result').val(),
            filter_date : $('#filter_date_alias_result').val()
         },params);
         ajaxManager.addReq({
            type : "GET",
            url : site_url + 'editor_log/getAllAliasByMaster',
            dataType : "JSON",
            data : {
               offset : str.offset,
               curpage : str.curpage,
               filter_date : str.filter_date,
               filter_keyword : str.filter_keyword,
               master_id : str.master_id,
               type : 1
            },
            beforeSend: function (xhr) {
              	// $panel.append(loading);
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
            },
           	success : function(r){
              	var t = '';
               if(r.total > 0){
               	$.each(r.result, function(k,v){
	               	t += '<tr>';
	               		t += '<td>'+v.alias+'</td>';
	               		t += '<td>'+v.data_date+'</td>';
	               		t += '<td>'+v.username+'</td>';
	               		t += '<td>';
	               			t += '<button type="button" class="btn btn-default btn-xs delete-alias-master" data-id="'+v.id+'"><i class="fa fa-trash"></i></button>';
	               		t += '</td>';
	               	t += '</tr>';
               	});
               }else{
                  t += '<tr><td colspan=5" class="text-center">No Result</td></tr>';
               }
            	$('.sect-data-result').html(t);
               $('.sect-total-result').html("Total : " + r.total);
               $('.sect-pagination-result').paging_result({
                  items : r.total,
                  itemsOnPage : 10,
                  currentPage : str.curpage 
               });
               // $panel.find('.please-wait').remove();
               _offset_alias_result = str.offset;
               _curpage_alias_result = str.curpage;
         	}
         });
		};

		$(this).on('click','.master-item a',function(e){
     		e.preventDefault();
        	_master_id = $(this).attr('href');
        	$('.master-item').removeClass('active');
        	$(this).parent('.master-item').addClass('active');
        	$(this).get_alias({
            master_id : _master_id
        	});
        	$(this).get_alias_result({
            master_id : _master_id
        	});
        	$('.sect-selected').html('');
    	});

      $(this).on('click', '.delete-alias-master', function(e){
         var conf = confirm('Are you sure ?');
         if(conf){
            var id = $(this).data('id');
            ajaxManager.addReq({
               type : "GET",
               url : site_url + 'editor_log/deleteAliasMaster',
               dataType : "JSON",
               data : {
                  id : id,
               },
               beforeSend: function (xhr) {
                  loading_button('.delete-alias-master', id, 'show', 'delete');
               },
               error: function (jqXHR, status, errorThrown) {
                  error_handle(jqXHR, status, errorThrown);
                  loading_button('.delete-alias-master', id, 'hide', 'delete');
               },
               success : function(r){
                  if(r.success){
                     $(this).get_alias({
                        master_id : _master_id
                     });
                     $(this).get_alias_result({
                        master_id : _master_id
                     });
                     toastr.success('Alias has been removed');
                  }else{
                     toastr.error('Remove failed');
                  }
                  loading_button('.delete-alias-master', id, 'hide', 'delete');
               }
            });
         }else{
            return false;
         }
         e.preventDefault();
      });

		$(this).on('click', '.btn-clear', function(e) {
         $('.sect-selected').html(''); 
      });

    	$(this).on('change','#filter_keyword_master',function(e){
    		e.preventDefault();
    		$(this).get_master();
 		});

    	$(this).on('click', '.btn-filter', function(e) {
         e.preventDefault();
         $(this).get_alias({
            master_id : _master_id
        	});
      });

      $(this).on('click', '.btn-filter-result', function(e) {
         e.preventDefault();
         $(this).get_alias_result({
            master_id : _master_id
        	});
      });

    	$(this).on('click', '.btn-remove-selected', function(e) {
    		e.preventDefault();
    		$(this).parent().remove();
    	});
      
      $(this).on('click', '.selected-alias', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var aliasreplaced = $(this).data('aliasreplaced');
         var aliasnoreplace = $(this).data('aliasnoreplace');
         var alias = $('.alias-'+id+'').text();
         if($('.item-alias-'+aliasnoreplace+'').length == 0){
            var t = '';
            t += '<li class="list-group-item item-alias-'+aliasnoreplace+'" style="padding:4px;">';
               t += '<input type="hidden" name="alias_parent['+id+'][alias_parent]" value="'+id+'">';
               t += '<button type="button" class="btn btn-xs btn-remove-selected" data-id=""><i class="fa fa-remove"></i></button>&nbsp;';
               t += ''+alias+'';
            t += '</li>';
            $('.sect-selected').prepend(t);  
         }
      });

      $(this).on('submit', '#form-update-master', function(e){
         var form = $(this);
         $(this).ajaxSubmit({
            url  : site_url +'editor_log/updateMaster',
            type : "POST",
            dataType : "JSON",
            data : {
            	'alias_master' : _master_id
            },
            error: function (jqXHR, status, errorThrown) {
               error_handle(jqXHR, status, errorThrown);
               loading_form(form, 'hide');
            },
            beforeSend: function (xhr) {
               loading_form(form, 'show');
            },
            success: function(r) {
               if(r.success){
                  $('.sect-selected').html('');
                  $(this).get_alias({
			            master_id : _master_id
			        	});
                  toastr.success(r.msg);
               }else{
                  toastr.error(r.msg);
               }
               loading_form(form, 'hide');
            },
         });
         e.preventDefault();
      });

    	$('.filter_date_alias').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.filter_date_alias').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#filter_date_alias').val(picker.startDate.format('YYYY-MM-DD'));
      });

      $('.filter_date_alias_result').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.filter_date_alias_result').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#filter_date_alias_result').val(picker.startDate.format('YYYY-MM-DD'));
      });

		$.fn.paging_master = function (opt) {
         var s = $.extend({
            items: 0,
            itemsOnPage: '',
            currentPage: 1
         }, opt);

         $('.sect-pagination-master').pagination({
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
               _offset_master = offset;
               _curpage_master = n;
               $(this).get_master();
            }
         });
      };

      $.fn.paging_result = function (opt) {
         var s = $.extend({
            items: 0,
            itemsOnPage: '',
            currentPage: 1
         }, opt);

         $('.sect-pagination-result').pagination({
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
               _offset_alias_result = offset;
               _curpage_alias_result = n;
               $(this).get_alias_result({
		            master_id : _master_id
		        	});
            }
         });
      };

      $(this).get_master();

	});
</script>