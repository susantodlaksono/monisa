<?php

/**
 * @Author: santo
 * @Date:   2018-06-25 11:07:26
 * @Last Modified by:   santo
 * @Last Modified time: 2018-06-25 13:27:48
 */

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Group_management extends MY_Controller {

   public function __construct() {
      parent::__construct();
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
         'title'=>'- Group Management',
         'result_view' => 'settings/groups',
      );
      $this->rendering_page($obj);
   }

   public function render_data(){
      $params = $this->input->get();
      $list = array();

      $rs = $this->db->get('groups')->result_array();
      if ($rs) {
         foreach ($rs as $v) {
            $list[] = array(
               'id' => $v['id'],
               'name' => $v['name'] ? $v['name'] : 'None',
               'description' => $v['description'] ? $v['description'] : 'None'
            );
         }
         $response['response'] = $list;
         $response['total'] = count($rs);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }   

   public function create(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $this->load->library('ion_auth');

      $obj = array(
         'name' => $params['description'],
         'description' => $params['description']
      );
      $usersave = $this->db->insert('groups', $obj);
      if($usersave){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Update';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function change(){
      $params = $this->input->post();
      $response['success'] = FALSE;
   
      $obj = array(
         'name' => $params['name'],
         'description' => $params['description']
      );
      $process = $this->db->update('groups', $obj, array('id' => $params['id']));
      if($process){
         $response['success'] = TRUE;
         $response['msg'] = 'Data Updated';
      }else{
         $response['msg'] = 'Function Failed';
      }
      $this->json_result($response);
   }

   public function edit(){
      $params = $this->input->get();
      $response['response'] = $this->db->where('id', $params['id'])->get('groups')->row_array();
      $this->json_result($response);
   }

   public function delete(){
      $params = $this->input->get();
      $process = $this->db->delete('groups', array('id' => $params['id']));
      $response['success'] = $process ? TRUE : FALSE;
      $response['msg'] = $process ? 'Data Updated' : 'Function Failed';
      $this->json_result($response);
   }




}