<?php

class MY_Controller extends MX_Controller {

   protected $_user;
   protected $_role_id;
   protected $_role_id_list;
   protected $_message;
   protected $_nik;
   protected $_post, $_get;

   public function __construct() {
      parent::__construct();
      if($this->config->item('maintenance_mode') == TRUE) {
         $this->load->helper('url');
         redirect('mv');
      }
      $this->load->add_package_path(APPPATH . 'third_party/ion_auth/');
      $this->load->library('ion_auth');
      $this->load->config('service');

      $this->_user = $this->ion_auth->user()->row();

      if($this->ion_auth->logged_in()){
         $role_id = $this->db->select('group_id')->where('user_id', $this->_user->id)->get('users_groups')->result_array();
         foreach ($role_id as $v) {
            $this->_role_id_list[] = $v['group_id'];
         }
      }
      $this->_post = $this->input->post();
      $this->_get = $this->input->get();
    }

   public function render_page($data = array(), $view = 'index') {
      $data['_user'] = $this->_user;
      $data['_post'] = $this->_post;
      $data['_get'] = $this->_get;

      if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'] && $view != 'login') {
         echo $this->load->view('template/' . 'pjax', $data, TRUE);
      } else {
         $this->load->view('template/' . $view, $data);
      }
   }

   public function _logging($module, $action, $module_id, $user_id){
      $obj = array(
         'log_module' => $module,
         'log_action' => $action,
         'log_module_id' => $module_id,
         'log_user_id' => $user_id
      );
      $this->db->insert('log', $obj);
   }
   public function render_widget($data, $css = FALSE) {
      $data['container'] = $this->input->get('container');
      $data['uniqid'] = uniqid();
      $data['widget_name'] = str_replace('/', '_', uri_string());
      if ($css) {
         $result['css'] = $this->router->fetch_module();
      }
      $result['html'] = $this->load->widget_view($this->router->fetch_module(), $data, TRUE);
      $this->json_result($result);
   }

   public function json_result($data) {
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         $data['sessionapp'] = FALSE; 
      }else{
         $data['sessionapp'] = TRUE;
         $this->session->set_userdata('_csrf', $this->security->get_csrf_hash());
         // $data['csrf'] = $this->security->get_csrf_hash();
      }

      header('Content-Type: application/json');
      echo json_encode($data);
      exit();
   }

   public function on_duplicate($table, $data, $exclude = array(), $db = 'default') {
      $this->_db = $this->load->database($db, TRUE);
      $updatestr = array();
      foreach ($data as $k => $v) {
         if (!in_array($k, $exclude)) {
            // $updatestr[] = '`' . $k . '`="' . mysql_real_escape_string($v) . '"'; // local
            // $updatestr[] = '`' . $k . '`="' . mysql_escape_string($v) . '"'; // server
            $updatestr[] = '`' . $k . '`="' . $this->db->escape_str($v) . '"'; // local
         }
      }
      $query = $this->_db->insert_string($table, $data);
      $query .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', array_filter($updatestr));
      $this->_db->query($query);
      return $this->_db->affected_rows();
   }

   public function rendering_page($data = array(), $view = 'index') {
      $data['_user'] = $this->_role_id_list;
      $data['_user'] = $this->_user;
      $data['_post'] = $this->_post;
      $data['_get'] = $this->_get;
      $data['username'] = $this->_user->username;
      $data['avatar'] = $this->_user->avatar;
      $data['uri_string'] = explode('/', uri_string());
      $data['title'] = $this->db->select('name,icon')->where('url', uri_string())->get('menu')->row_array();
      
      $this->load->model('app');
      $data['section_head'] = $this->app->section_head();
      $this->session->set_userdata('_csrf', $this->security->get_csrf_hash());
      $this->load->view('base/' . $view, $data);
   }


}