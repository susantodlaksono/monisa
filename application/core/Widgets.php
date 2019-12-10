<?php

class Widgets extends MY_Controller {

   private $_params;
    
   public function __construct() {
      parent::__construct();
   }

   private function _css() {
      $_css = isset($this->_params['_css']) && $this->_params['_css'] ? $this->_params['_css'] : FALSE;
      if ($_css) {
         if (!is_array($_css)) {
            $_css = array((string) $_css);
         }
         foreach ($_css as $url) {
            $css[] = preg_match('/^http/', $url) ? $url : base_url($url);
         }
      }
      return isset($css) ? $css : FALSE;
   }

   public function render($params = array()) {
      $this->_params = $params;
      $this->_params['module'] = uri_string();
      $this->_params['unixid'] = time();
      
      $data = array(
         'css' => $this->_css(),
         'container' => $this->input->get('container'),
         'html' => $this->load->view('template/' . 'widget', $this->_params, TRUE)
      );
      header('Content-Type: application/json');
      echo json_encode($data);
   }
    
}
