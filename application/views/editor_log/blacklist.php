<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
         <div class="panel-heading">
         	<div class="panel-title"><i class="<?php echo $title['icon'] ?>"></i> <?php echo $title['name'] ?></div>
         	<div class="panel-options" style="width: auto">
         		<div class="form-group" style="margin-top:6px;margin-bottom: 5px;"> 
	         		<div class="btn-group dropdown-default"> 
	         			<div class="input-group">
	                     <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
	                     <input type="text" class="form-control input-sm filter_date" id="filter_date">
	                  </div>
	               </div>
	               <div class="btn-group dropdown-default"> 
                     <select class="form-control input-sm" id="filter_status">
                        <option value="">All</option>
                        <option value="1">No Blacklist</option>
                        <option value="2">Blacklist</option>
                     </select>
                  </div>
                  <div class="btn-group dropdown-default"> 
                  	<button class="btn btn-sm btn-blue" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-upload"></i> Upload</button>
               	</div>
               </div>
      		</div>
      	</div>
   	</div>
	</div>
</div>