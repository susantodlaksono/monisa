<div class="row">
	<div class="col-md-4">
	 	<div class="panel panel-invert" data-collapsed="0">
      	<div class="panel-heading">
            <div class="panel-title"><i class="fa fa-user-times"></i> Alias Person</div>
            <div class="panel-options" style="width: auto">
            	<div class="form-group" style="margin-top:6px;margin-bottom: 5px;"> 
	            	<div class="btn-group dropdown-default"> 
	                  <div class="input-group">
	                     <div class="input-group-addon" style="background-color: #222222;border: 1px solid #525252;color:#fff;"><i class="fa fa-calendar"></i></div>
	                     <input type="hidden" id="filter_date_person" value="<?php echo date('Y-m-d') ?>">
	                     <input type="text" style="width:100px;color: #fff;background-color: #222222;border: 1px solid #525252;"
                        class="form-control input-sm filter_date" 
	                     data-targeted="#filter_date_person"
	                     data-type="1" 
	                     data-widget="widget-alias-person" 
	                     value="<?php echo date('d/M/Y') ?>">
	                  </div>
	               </div>
               </div>
         	</div>
      	</div>
         <div class="panel-body" id="widget-alias-person"></div>
     	 </div>
	</div>
	<div class="col-md-4">
	 	<div class="panel panel-invert" data-collapsed="0">
      	<div class="panel-heading">
            <div class="panel-title"><i class="fa fa-hospital-o"></i> Alias Organization</div>
            <div class="panel-options" style="width: auto">
            	<div class="form-group" style="margin-top:6px;margin-bottom: 5px;"> 
	            	<div class="btn-group dropdown-default"> 
	                  <div class="input-group">
	                     <div class="input-group-addon" style="background-color: #222222;border: 1px solid #525252;color:#fff;"><i class="fa fa-calendar"></i></div>
	                     <input type="hidden" id="filter_date_organization" value="<?php echo date('Y-m-d') ?>">
	                     <input type="text" style="width:100px;color: #fff;background-color: #222222;border: 1px solid #525252;"
                        class="form-control input-sm filter_date" 
	                     data-targeted="#filter_date_organization" 
	                     data-type="2" 
	                     data-widget="widget-alias-organization" 
	                     value="<?php echo date('d/M/Y') ?>">
	                  </div>
	               </div>
               </div>
         	</div>
      	</div>
         <div class="panel-body" id="widget-alias-organization"></div>
     	 </div>
	</div>
	<div class="col-md-4">
	 	<div class="panel panel-invert" data-collapsed="0">
      	<div class="panel-heading">
            <div class="panel-title"><i class="fa fa-map-marker"></i> Alias Location</div>
            <div class="panel-options" style="width: auto">
            	<div class="form-group" style="margin-top:6px;margin-bottom: 5px;"> 
	            	<div class="btn-group dropdown-default"> 
	                  <div class="input-group">
	                     <div class="input-group-addon" style="background-color: #222222;border: 1px solid #525252;color:#fff;"><i class="fa fa-calendar"></i></div>
	                     <input type="hidden" id="filter_date_location" value="<?php echo date('Y-m-d') ?>">
	                     <input type="text" style="width:100px;color: #fff;background-color: #222222;border: 1px solid #525252;"
                        class="form-control input-sm filter_date" 
	                     data-targeted="#filter_date_location" 
	                     data-type="3" 
	                     data-widget="widget-alias-location" 
	                     value="<?php echo date('d/M/Y') ?>">
	                  </div>
	               </div>
               </div>
         	</div>
      	</div>
         <div class="panel-body" id="widget-alias-location"></div>
     	 </div>
	</div>
</div>

<script type="text/javascript">
	$(function () {

		Widget.Loader(
         'stats_alias',
         {
            date : $('#filter_date_person').val(),
            type : 1
         },
         'widget-alias-person'
      );

      Widget.Loader(
         'stats_alias',
         {
            date : $('#filter_date_organization').val(),
            type : 2
         },
         'widget-alias-organization'
      );

      Widget.Loader(
         'stats_alias',
         {
            date : $('#filter_date_location').val(),
            type : 3
         },
         'widget-alias-location'
      );

		$('.filter_date').daterangepicker({
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.filter_date').on('apply.daterangepicker', function(ev, picker) {
      	var targeted = $(this).data('targeted');
      	var type = $(this).data('type');
      	var widget = $(this).data('widget');
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $(targeted).val(picker.startDate.format('YYYY-MM-DD'));

         Widget.Loader(
	         'stats_alias',
	         {
	            date : $(targeted).val(),
	            type : type
	         },
	         ''+widget+''
	      );
      });
	});
</script>
