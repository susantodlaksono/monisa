<?php

/**
 * @Author: santo
 * @Date:   2018-06-21 13:23:13
 * @Last Modified by:   santo
 * @Last Modified time: 2018-06-25 10:21:47
 */

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Users_management extends MY_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model('users');
      $this->load->library('validation_lib');
      if (!$this->ion_auth->logged_in() && php_sapi_name() != 'cli') {
         redirect('security?_redirect=' . urlencode(uri_string()));
      }
   }

   public function index() {
      $obj = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'title'=>'- Users Management',
         'result_view' => 'settings/users',
      );
      $this->rendering_page($obj);
   }

   public function render_data(){
      $params = $this->input->get();
      $list = array();

      $rs = $this->users->get_users('get', $params);
      if ($rs) {
         foreach ($rs as $v) {
            $list[] = array(
               'id' => $v['user_id'],
               'first_name' => $v['first_name'] ? $v['first_name'] : 'None',
               'username' => $v['username'] ? $v['username'] : 'None',
               'email' => $v['email'] ? $v['email'] : 'None',
               'status' => $v['active']  == 0 ? '<span class="label label-danger">Inactive</span>' : '<span class="label label-success">Active</span>',
               'role' => $this->users->get_role($v['user_id']),
            );
         }
         $response['response'] = $list;
         $response['total'] = $this->users->get_users('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }   

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $this->load->library('ion_auth');

      if($this->validation_lib->create_user($params)){
         $user = array(
            'active' => $params['status'],
            'first_name' => $params['fullname']
         );
         $usersave = $this->ion_auth->register($params['username'], $params['password'], $params['email'], $user, $params['role']);
         if($usersave){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function change(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $this->load->library('ion_auth');

      if($this->validation_lib->modify_user($params)){
         $user = array(
            'first_name' => $params['fullname'],
            'email' => $params['email'],
            'active' => $params['status'],
            'username' => $params['username']
         );
         $usersave = $this->ion_auth->update($params['id'], $user);
         $this->ion_auth->remove_from_group(false, $params['id']);
         if($params['role']){
            foreach ($params['role'] as $v) {
               $this->ion_auth->add_to_group($v, $params['id']);
            }
         }
         if($usersave){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function change_password(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $this->load->library('ion_auth');

      if($this->validation_lib->modify_user_password($params)){
         $user = array(
            'password' => $params['password']
         );
         $usersave = $this->ion_auth->update($params['id'], $user);
         if($usersave){
            $response['success'] = TRUE;
            $response['msg'] = 'Data Update';
         }else{
            $response['msg'] = 'Function Failed';
         }
      }else{
         $response['msg'] = validation_errors();
      }
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['users'] = $this->db->where('id', $params['id'])->get('users')->row_array();
      if($response['users']){
         $get_role = $this->db->select('group_id')->where('user_id', $params['id'])->get('users_groups')->result_array();
         foreach($get_role as $v){
            $role[] = $v['group_id'];
         }
      }else{
         $role = NULL;
      }
      $response['role'] = $role;
      $this->json_result($response);
   }


}