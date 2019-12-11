<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="description" content="Neon Admin Panel" />
   <meta name="author" content="" />

   <link href="<?php echo base_url('favicon.png'); ?>" rel="shortcut icon"/>

   <title>Monisa | Login</title>

   <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-icons/entypo/css/entypo.css">
   <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-core.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-theme.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-forms.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-icons/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/vertical-timeline/css/component.css">
   <script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.min.js"></script>
   <style type="text/css">
      hr{
         margin:0px;
      }
      .label{
         font-size: 13px;
      }
      .label + .label{
         margin-left: 0px;  
         margin-top: 5px;       
      }
      .label{
         margin-right: 2px;
      }
   </style>
</head>
<body style="background-color: #222222">
   <div class="col-md-12" style="border:0px solid black;">
      <div class="row">
         <div class="col-md-4 col-md-offset-4" style="border:1px solid #424242;padding:50px;margin-top: 70px;border-radius:5px;">
            <div class="col-md-12 text-center">
               <a href="<?php echo site_url() ?>" class="logo">
                  <img src="<?php echo base_url() ?>logo.png" width="70" alt="" />
               </a>
            </div>
            <div class="col-md-12 text-center" style="margin-top:20px;">
               <h2 style="color:#fff;margin-top: -10px;" class="bold">MONISA</h2>
               <h5 style="color:#fff;margin-top: -5px;">Support Operational & Management Activity</h5>
            </div>
            <div class="col-md-12" style="margin-top:20px;">
               <form method="post" action="<?php echo site_url('security/verify') ?>">
                  <div class="form-group">
                     <div class="input-group" style="background-color:#ffffff;">
                        <div class="input-group-addon" style="background-color: #222222;color:#fff;">
                           <i class="entypo-user"></i>
                        </div>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" style="color: #fff;background-color: #222222;"/>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group" style="background-color:#ffffff;">
                        <div class="input-group-addon" style="background-color: #222222;color:#fff;">
                           <i class="entypo-key"></i>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" style="color: #fff;background-color: #222222;"/>
                     </div>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-block">
                        <i class="entypo-login"></i> Login In
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   
   <script src="<?php echo base_url() ?>assets/js/gsap/TweenMax.min.js"></script>
   <script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
   <script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
   <script src="<?php echo base_url() ?>assets/js/joinable.js"></script>
   <script src="<?php echo base_url() ?>assets/js/resizeable.js"></script>
   <script src="<?php echo base_url() ?>assets/js/neon-api.js"></script>
   <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
   <script src="<?php echo base_url() ?>assets/js/neon-login.js"></script>
   <script src="<?php echo base_url('assets/js/jquery.form.js') ?>"></script>
   <script src="<?php echo base_url() ?>assets/js/neon-custom.js"></script>
   <script src="<?php echo base_url() ?>assets/js/neon-demo.js"></script>
   <script src="<?php echo base_url() ?>assets/setup.js"></script>

    

</body>
</html>