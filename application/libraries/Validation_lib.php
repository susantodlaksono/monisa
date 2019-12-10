<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validation_Lib{

   public function __construct() {
      $this->_ci = & get_instance();
      $this->_ci->load->library('form_validation');
      $this->_ci->load->database();
   }

   public function create_user(){
      $this->_ci->form_validation->set_rules('fullname', 'Fullname', 'required');
      $this->_ci->form_validation->set_rules('role[]', 'Role', 'required');
      $this->_ci->form_validation->set_rules('status', 'Status', 'required');
      $this->_ci->form_validation->set_rules('email', 'Email ', 'required|valid_email|is_unique[users.email]');
      $this->_ci->form_validation->set_rules('username', 'Username ', 'required|alpha_numeric_spaces|is_unique[users.username]');
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('passwordconf', 'Password confirmation', 'required|matches[password]');

      // $this->_ci->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
      // $this->_ci->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|alpha_numeric_spaces');

      // $this->_ci->form_validation->set_message('is_unique', '%s telah digunakan');
      // $this->_ci->form_validation->set_message('required', '%s harus diisi');
      // $this->_ci->form_validation->set_message('matches', '%s harus sama');
      // $this->_ci->form_validation->set_message('alpha_numeric_spaces', '%s hanya boleh berisi karakter dan spasi alfa-numerik');
      return $this->_ci->form_validation->run();
   }

   public function modify_user($params){
      $this->_ci->form_validation->set_rules('fullname', 'Fullname', 'required');
      $this->_ci->form_validation->set_rules('role[]', 'Role', 'required');
      $this->_ci->form_validation->set_rules('status', 'Status', 'required');
      if($params['email'] != $params['email_before']){
         $this->_ci->form_validation->set_rules('email', 'Email ', 'required|valid_email|is_unique[users.email]');
      }else{
         $this->_ci->form_validation->set_rules('email', 'Email ', 'required|valid_email');
      }
      if($params['username'] != $params['username_before']){
         $this->_ci->form_validation->set_rules('username', 'Username ', 'required|alpha_numeric_spaces|is_unique[users.username]');   
      }else{
         $this->_ci->form_validation->set_rules('username', 'Username ', 'required|alpha_numeric_spaces');
      }

      return $this->_ci->form_validation->run();
   }

   public function modify_user_password($params){
      $this->_ci->form_validation->set_rules('password', 'Password', 'required');
      $this->_ci->form_validation->set_rules('passwordconf', 'Password confirmation', 'required|matches[password]');
      return $this->_ci->form_validation->run();
   }

}