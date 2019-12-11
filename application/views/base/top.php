<style type="text/css">
   .notif-summary{
      font-size: 10.5px;
      margin-top: -25px;
   }   
   .profile-info.dropdown .dropdown-menu{
      margin-left: -72px;
      margin-top: -1px;
   }
</style>

<div class="row">
   <div class="col-md-9 col-sm-5 clearfix" style="border-right:1px solid #black;height:50px;padding-left:10px;">
      <img src="<?php echo base_url() ?>logo.png" width="50" height="50" class="pull-left">
      <h3 class="pull-left ebdesk-title">MONISA</h3><br>
      <p class="ebdesk-subtitle">Support Operational & Management Activity</p>
   </div>
   <!-- <div class="col-md-6 col-sm-5 clearfix" style="border-right:0px solid #e6e6e6;height:50px;">
      <div class="input-group" style="margin-top:9px;margin-bottom: 9px;">
         <input type="text" class="form-control" name="search" placeholder="Search for something...">
         <div class="input-group-btn">
            <button type="submit" class="btn btn-primary">
               <i class="entypo-search"></i> Search 
            </button>
         </div>
      </div>
   </div> -->
   <!-- <div class="col-md-3 col-sm-2 clearfix text-center" style="border-right:0px solid #e6e6e6;height:50px;">
      <h5 class="bold" style="margin-top:-2px;">All Role :</h5>
      <span class="label label-default notif-summary">10 Admin</span>
      <span class="label label-default notif-summary">10 Operator</span>
      <span class="label label-default notif-summary">10 Management</span>
   </div> -->
   <div class="col-md-3 col-sm-3 clearfix hidden-xs" style="border:0px solid black;height:50px;">
      <ul class="user-info pull-right pull-none-xsm" style="margin-top: 13px;margin-bottom: 9px;border: 1px solid #5d5252;">
         <li class="profile-info dropdown" style="padding:7px;margin-right:0px;"><!-- add class "pull-right" if you want to place this from right -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff;">
               <?php 
                  // if($avatar){
                  //    echo '<img src="'.base_url().'/files/user_profil_image/'.$avatar.'" alt="" class="img-circle" width="44">';
                  // }else{
                  //    echo '<img src="'.base_url().'/files/user_profil_image/noavatar.png" alt="" class="img-circle" width="44">';
                  // }
               ?>
               <?php echo $username ?> <i class="fa fa-caret-square-o-down"></i>
            </a>
            <ul class="dropdown-menu" style="margin-left:-147px;border:1px solid #4c4b4b;">
               <!-- Reverse Caret -->
               <li class="caret"></li>
               <li>
                  <a href="<?php echo site_url('security/logout') ?>">
                     <i class="entypo-logout"></i>
                     Logout
                  </a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</div>
<hr style="border-top:1px solid #3c3c3c" />