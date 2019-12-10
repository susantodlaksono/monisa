<?php

class Mv extends CI_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->helper('url');
   }

   public function index(){
      if($this->config->item('maintenance_mode')) {
         $this->load->view('maintenance_view');
      }else{
         redirect('main');
      }
   }

}