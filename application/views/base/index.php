<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="description" content="Neon Admin Panel" />
   <meta name="author" content="" />

   <link rel="icon" href="<?php echo base_url() ?>/indosiar.png">

   <title>Monisa | <?php echo $title['name']; ?></title>

   <?php
      $this->load->view('base/_css');
      $this->load->view('base/css');
   ?>

   <script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.min.js"></script>


</head>
<body class="page-body skin-black" data-url="http://neon.dev">

   <!-- <div class="refreshing" style="display:none;"></div> -->
   
   <div class="page-container sidebar-collapsed">
   <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
      
      <div class="sidebar-menu">
         <div class="sidebar-menu-inner">
            <?php $this->load->view('base/header.php'); ?>
            <?php echo Modules::run('base_menu'); ?>
         </div>
      </div>
      <div class="main-content" style="background-color:#222222;border-left:1px solid #3e3e3e;">
         <?php $this->load->view('base/top.php'); ?>
         <div id="container-content">
            <!-- <h3 class="text-muted bold"><i class="<?php echo $section_head['icon'] ?>"></i> <?php echo $section_head['name'] ?></h3>
            <hr> -->
            <?php
               if ($result_view) {
                  $this->load->view($result_view);
               }
            ?>
         </div>
         <input type="hidden" id="csrf" value="<?php echo $this->security->get_csrf_hash(); ?>">
      </div>
      
   </div>

   <?php
      $this->load->view('base/js');
      $this->load->view('base/_js');
   ?>

   <script>
      var site_url = '<?php echo site_url(); ?>';
      var base_url = '<?php echo base_url(); ?>';
      var loading = '<div class="please-wait"><i class="fa fa-refresh fa-spin" style="color: #fff;"></i></div>';
      // var _csrf = '<?php echo $this->session->userdata('_csrf'); ?>';
   </script>

   <script type="text/javascript">
      // Widget.Loader('master_position', {}, 'container-content', true);

      // $('#main-menu a').on('click', function(e) {
      //    var url = $(this).attr('href');
      //    if(url == '#'){
      //       return false;
      //    }else{
      //       Widget.Loader(url, {}, 'container-content', true);
      //    }
      //    e.preventDefault();
         
      // });

   </script>

</body>
</html>