<h3 style="margin-top: -10px;" class="text-muted">Delete Data</h3>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-body" id="cont-data">
				<form id="form-delete">
					<div class="form-group">
						<label>Tgl Data</label>
						<input type="hidden" name="data_date" id="data_date" value="<?php echo date('Y-m-d') ?>">
	               <input type="text" class="form-control input-sm dp" value="<?php echo date('d/M/Y') ?>">
					</div>
					<div class="form-group">
						<label>Module</label>
						<select class="form-control" name="type">
							<option value="1">Person</option>
							<option value="2">Organization</option>
							<option value="3">Location</option>
						</select>
					</div>
					<div class="form-group">
						<label>Password Login (For Autentication)</label>
						<input type="password" name="password_login" class="form-control">
					</div>
					<button type="submit" class="btn btn-blue btn-block"><i class="fa fa-trash"></i> Delete</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function () {
		$(this).on('submit', '#form-delete', function(e){
         var form = $(this);
         var conf = confirm('Are you sure?');
         if(conf){
         	$(this).ajaxSubmit({
	            url  : site_url +'editor_log/deleteAlias',
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
	                  toastr.success(r.msg);
	               }else{
	                  toastr.error(r.msg);
	               }
	               loading_form(form, 'hide');
	            },
	         });
         }else{
         	return false;
         }
         e.preventDefault();
      });

      $('.dp').daterangepicker({
         parentEl : '#modal-upload',
         autoUpdateInput: false,
         locale: {
            format: 'DD/MMM/YYYY'
         },
         singleDatePicker: true,
         showDropdowns: true
      });

      $('.dp').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('DD/MMM/YYYY'));
         $('#data_date').val(picker.startDate.format('YYYY-MM-DD'));
      });

	});
</script>