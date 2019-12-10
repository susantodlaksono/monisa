<?php

class Main extends MY_Controller {

   public function __construct() {
      parent::__construct();
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security');
      }
   }

   public function index(){
      $obj = array(
         'result_view' => 'pages/dashboard',
      );
      $this->rendering_page($obj);
   }

   public function get_users(){
      $this->db->select('id,first_name');
      $this->db->where('active', 1);
      return $this->db->get('users')->result_array();
   }

}