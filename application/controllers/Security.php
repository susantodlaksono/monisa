<?php

class Security extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_security');
        $this->load->add_package_path(APPPATH . 'third_party/ion_auth/');
        $this->load->library('ion_auth');
        $this->load->config('service');
        // $this->load->library('validation_form');    
    }

   private function json_result($result = array()) {
      header('Content-Type: application/json');
      echo json_encode($result);
      exit();
   }

   public function index(){
      if ($this->ion_auth->logged_in()) {
         redirect('home');
      }
      $data = array(
         'title' => 'Beranda'
      );
      $this->load->view('base/' . 'login', $data);
   }

   public function get_count(){     
      $list['total'] = array(
          'simcards' => $this->M_security->get_data('simcard','count'),
          'emails' => $this->M_security->get_data('email','count'),
          'facebooks' => $this->M_security->get_data('facebook','count'),
          'twitters' => $this->M_security->get_data('twitter','count'),
          'instagrams' => $this->M_security->get_data('instagram','count')
      );

      $list['data'] = array(
          'simcards' => $this->M_security->get_data('simcard','get'),
          'emails' => $this->M_security->get_data('email','get'),
          'facebooks' => $this->M_security->get_data('facebook','get'),
          'twitters' => $this->M_security->get_data('twitter','get'),
          'instagrams' => $this->M_security->get_data('instagram','get')
      );

      $response['data'] = $list;

      echo json_encode($response);
   }
   
   public function verify() {
      if ($this->input->post()) {
         $username = $this->input->post('username');
         $password = $this->input->post('password');
         $remember = true;
         $redirect = $this->input->post('redirect') ? $this->input->post('redirect') : 'main';

         $login = $this->ion_auth->login($username, $password, $remember);
         if ($login) {
            redirect(urldecode($redirect));
         } else {
            $this->_message = array(
               'message' => 'Kesalahan Username atau Password',
               'label' => 'danger'
            );
            $this->session->set_flashdata('message', $this->_message);
            redirect('security?redirect=' . urlencode($redirect));
         }
      } else {
         redirect('security');
      }
   }

   public function logout() {
      $this->ion_auth->logout();
      redirect('security');
   }

}