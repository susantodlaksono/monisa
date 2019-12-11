<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
/**
 *
 * @author SUSANTO DWI LAKSONO
 */

class Editor_log extends MY_Controller {
	public function __construct() {
  		parent::__construct();
      $this->load->model('m_editor_log');
      $this->load->library('bulk_uploader');
	}

	public function blacklist(){
		$data = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/blacklist',
      );
      $this->rendering_page($data);
	}

   public function deletedata(){
      $data = array(
         'result_view' => 'editor_log/delete',
      );
      $this->rendering_page($data);
   }

   public function alias_person(){
      $data = array(
         'title' => 'test',
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/alias_person',
      );
      $this->rendering_page($data);
   }

   public function common_person(){
      $data = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/common_person',
      );
      $this->rendering_page($data);
   }

   public function alias_person_master(){
      $data = array(
         'title' => 'test',
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/master/alias_person',
      );
      $this->rendering_page($data);
   }

   public function alias_organization(){
      $data = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/alias_organization',
      );
      $this->rendering_page($data);
   }

   public function alias_location(){
      $data = array(
         '_css' => array(
            'assets/plugins/simplepagination/simplePagination.css'
         ),
         '_js' => array(
            'assets/plugins/simplepagination/jquery.simplePagination.js"',
         ),
         'result_view' => 'editor_log/alias_location',
      );
      $this->rendering_page($data);
   }

   public function getAlias(){
      $params = $this->input->get();
      $list = array();
      $params['user_id'] = $this->_user->id;
      $data = $this->m_editor_log->getAlias('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'alias' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'aliasreplaced' => $value['alias'] ? $value['alias'] : '',
               'id_alias_parent' => $value['id_alias'],
               'id_alias_master' => $value['id_master'],
               'common_name' => $value['common_status'],
               'blacklist_name' => $value['blacklist_status'],
               'alias_no_spaces' => $value['alias'] ? str_replace('+', '_', $value['alias']) : '',
               'total_news' => $value['total_news'] ? $value['total_news'] : '0',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->getAlias('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function searchAlias(){
      $params = $this->input->get();
      $list = array();      
      $data = $this->m_editor_log->searchAlias('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'alias' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'aliasreplaced' => $value['alias'] ? $value['alias'] : '',
               'id_alias_parent' => $value['id_alias'],
               'id_alias_master' => $value['id_master'],
               'common_name' => $value['common_status'],
               'blacklist_name' => $value['blacklist_status'],
               'alias_no_spaces' => $value['alias'] ? str_replace('+', '_', $value['alias']) : '',
               'total_news' => $value['total_news'] ? $value['total_news'] : '0',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->searchAlias('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function searchAliasCommon(){
      $params = $this->input->get();
      $list = array();      
      $data = $this->m_editor_log->searchAliasCommon('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'alias' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'aliasreplaced' => $value['alias'] ? $value['alias'] : '',
               'id_alias_parent' => $value['id_alias'],
               'id_alias_master' => $value['id_master'],
               'common_name' => $value['common_status'],
               'blacklist_name' => $value['blacklist_status'],
               'alias_no_spaces' => $value['alias'] ? str_replace('+', '_', $value['alias']) : '',
               'total_news' => $value['total_news'] ? $value['total_news'] : '0',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->searchAliasCommon('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }


   public function getAllAliasByMaster(){
      $params = $this->input->get();
      $list = array();
      $params['user_id'] = $this->_user->id;
      $params['alias_master_id'] = $this->getAliasMasterId($params['master_id']);
      $data = $this->m_editor_log->getAllAliasByMaster('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'alias' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'data_date' => $value['data_date'] ? date('d M Y', strtotime($value['data_date'])) : '',
               'username' => $value['username'] ? $value['username'] : '',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->getAllAliasByMaster('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function getAliasByMaster(){
      $params = $this->input->get();
      $list = array();
      $params['user_id'] = $this->_user->id;
      $params['master_like_query'] = $this->getMasterQuery($params['master_id']);
      $params['alias_master_id'] = $this->getAliasMasterId($params['master_id']);
      $data = $this->m_editor_log->getAliasByMaster('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'alias' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'aliasreplaced' => $value['alias'] ? $value['alias'] : '',
               'alias_parent' => $value['alias_parent'],
               'alias_no_spaces' => $value['alias'] ? str_replace('+', '_', $value['alias']) : '',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->getAliasByMaster('count', $params);
      }else{
         $response['total'] = 0;
      }
      $response['master_like_query'] = implode(',', $params['master_like_query']);
      $this->json_result($response);
   }

   public function getMaster(){
      $params = $this->input->get();
      $list = array();
      $params['user_id'] = $this->_user->id;
      $data = $this->m_editor_log->getMaster('get', $params);
      if($data){
         foreach ($data as $value) {
            $list[] = array(
               'id' => $value['id'],
               'pic' => $value['username'] ? $value['username'] : '-',
               'master' => $value['alias'] ? str_replace('+', ' ', $value['alias']) : '',
               'total_alias' => $value['total_alias'] ? $value['total_alias'] : '0',
            );
         }
         $response['result'] = $list;
         $response['total'] = $this->m_editor_log->getMaster('count', $params);
      }else{
         $response['total'] = 0;
      }
      $this->json_result($response);
   }

   public function getMasterQuery($id){
      $alias_monitoring = $this->getAliasName($id);
      $exp = explode('+', $alias_monitoring['alias']);
      foreach ($exp as $v) {
         // $data[] = substr($v, 0,3);
         $data[] = $v;
      }
      return $data;
   }

   public function getAliasName($id){
      $this->db->select('alias');
      $this->db->where('id', $id);
      return $this->db->get('alias_monitoring')->row_array();
   }

   public function getAliasMasterId($id){
      $this->db->select('id');
      $this->db->where('alias', $id);
      $rs = $this->db->get('alias_master')->row_array();
      return $rs['id'];
   }

   public function bulkCommon(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $result = $this->m_editor_log->bulkCommon($params, 1);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Common Name Added';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function bulkMaster(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $params['user_id'] = $this->_user->id;
      $result = $this->m_editor_log->bulkMaster($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Master Name Added';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function bulkBlacklist(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $result = $this->m_editor_log->bulkBlacklist($params, 1);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Blacklist Added';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function bulkRemoveCommon(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $result = $this->m_editor_log->bulkCommon($params, NULL);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Common Name Removed';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function bulkRemoveMaster(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $result = $this->m_editor_log->bulkRemoveMaster($params);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Common Name Removed';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function bulkRemoveBlacklist(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $result = $this->m_editor_log->bulkBlacklist($params, NULL);
      if($result > 0){
         $response['success'] = TRUE;
         $response['msg'] = 'Blacklist Removed';
      }else{
         $response['msg'] = 'No Data Updated';
      }
      $this->json_result($response);
   }

   public function getParentByMaster(){
      $params = $this->input->get();
      $list = array();
      if($params['id']){
         $params['user_id'] = $this->_user->id;
         $data = $this->m_editor_log->getParentByMaster($params);
         if($data){
            foreach ($data as $value) {
               $list[] = array(
                  'alias_parent' => $value['alias_parent'] ? str_replace('+', ' ', $value['alias_parent']) : '',
                  'alias_parent_replaced' => $value['alias_parent'] ? $value['alias_parent'] : '',
                  'alias_parent_no_spaces' => $value['alias_parent'] ? str_replace('+', '', $value['alias_parent']) : '',
                  'id' => $value['id']
               );
            }
            $response['result'] = $list;
            $response['total'] = count($list);
         }else{
            $response['total'] = 0;
         }
      }else{
         $params['total'] = 0;
      }
      $this->json_result($response);
   }

   public function deleteMapping(){
      $params = $this->input->get();
      if(isset($params['id']) && $params['id'] != ''){
         $result = $this->db->delete('alias_master_mapping', array('id' => $params['id']));
         if($result){
            $response['success'] = TRUE;
         }else{
            $response['success'] = FALSE;
         }
      }else{
         $response['success'] = FALSE;
      }
      $this->json_result($response);
   }

   public function deleteAliasMaster(){
      $params = $this->input->get();
      if(isset($params['id']) && $params['id'] != ''){
         $result = $this->db->delete('alias_master_mapping', array('id' => $params['id']));
         if($result){
            $response['success'] = TRUE;
         }else{
            $response['success'] = FALSE;
         }
      }else{
         $response['success'] = FALSE;
      }
      $this->json_result($response);
   }

   public function deleteMaster(){
      $params = $this->input->get();
      if(isset($params['id']) && $params['id'] != ''){
         $result = $this->db->delete('alias_master', array('id' => $params['id']));
         if($result){
            $response['success'] = TRUE;
         }else{
            $response['success'] = FALSE;
         }
      }else{
         $response['success'] = FALSE;
      }
      $this->json_result($response);
   }

   public function updateStatus(){
      $params = $this->input->get();
      if(isset($params['id']) && $params['id'] != ''){
         $result = $this->db->update('alias_monitoring', array(''.$params['field'].'' => NULL), array('id' => $params['id']));
         if($result){
            $response['success'] = TRUE;
         }else{
            $response['success'] = FALSE;
         }
      }else{
         $response['success'] = FALSE;
      }
      $this->json_result($response);
   }

   public function uploadAlias(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $filename = $this->_user->username.'-'.uniqid(date("hisu"));
      $params['user_id'] = $this->_user->id;

      if($_FILES) {
         $config['upload_path'] = './upload/';
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 0;
         $config['file_name'] = $filename;

         $this->load->library('upload', $config);
         if($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $read = $this->bulk_uploader->uploadAlias($data['file_name'], $params);
            if($read['success']){
               $response['success'] = $read['success'];
               $response['data'] = $read['data'];
               $response['dataunique'] = $read['dataunique'];
               $response['msg'] = $read['msg'];
            }else{
               $response['msg'] = $read['msg'];
            }
         }else{
            $response['msg'] = $this->upload->display_errors();
         }
      }else{
         $response['msg'] = 'File Format Required';
      }
      $this->json_result($response);
   }

   public function updateMaster(){
      $params = $this->input->post();
      $response['success'] = FALSE;
      $count = 0;
      if(isset($params['alias_master'])){
         $alias_master = $this->db->where('alias', $params['alias_master'])->get('alias_master')->row_array();
         if(!$alias_master){
            $master = array(
               'alias' => $params['alias_master'],
               'pic_by' => $this->_user->id
            );
            $this->db->insert('alias_master', $master);
            $master_id = $this->db->insert_id();
         }else{
            $master_id = $alias_master['id'];
         }
         if(isset($params['alias_parent'])){
            foreach ($params['alias_parent'] as $v) {
               $tmp = array(
                  'alias_master' => $master_id,
                  'alias_parent' => $v['alias_parent'],
                  'mapping_by' => $this->_user->id,
                  'mapping_date' => date('Y-m-d H:i:s')
               );
               $insert = $this->db->insert('alias_master_mapping', $tmp);
               $insert ? $count++ : FALSE;
            }
            if($count > 0){
               $response['success'] = TRUE;
               $response['msg'] = 'Data Updated';
            }
         }else{
            $response['success'] = TRUE;
            $response['msg'] = 'Data Updated';
         }
      }else{
         if(isset($params['alias_parent'])){
            foreach ($params['alias_parent'] as $v) {
               $tmp = array(
                  'alias_master' => NULL, 
                  'alias_parent' => $v['alias_parent'],
                  'mapping_by' => $this->_user->id,
                  'mapping_date' => date('Y-m-d H:i:s')
               );
               $insert = $this->db->insert('alias_master_mapping', $tmp);
               $insert ? $count++ : FALSE;
            }
            if($count > 0){
               $response['success'] = TRUE;
               $response['msg'] = 'Data Updated';
            }
         }else{
            $response['success'] = TRUE;
            $response['msg'] = 'Data Updated';
         }
      }
      $this->json_result($response);
   }

   public function deleteAlias(){
      $params = $this->input->post();
      $response['success'] = FALSE;  
      if(isset($params['password_login']) && $params['password_login'] != ''){
         $this->load->library('ion_auth');
         $login = $this->ion_auth->login($this->_user->username, $params['password_login'], FALSE);
         if($login) {
            if(isset($params['data_date']) && $params['data_date'] != ''){
               $result = $this->db->delete('alias_monitoring', array('data_date' => $params['data_date'], 'alias_type' => $params['type']));
               if($result){
                  $response['success'] = TRUE;    
                  $response['msg'] = 'Data deleted';      
               }else{
                  $response['msg'] = 'Delete data failed';      
               }
            }
         }else{
            $response['msg'] = 'Authentication Failed';   
         }
      }else{
         $response['msg'] = 'Password required for authentication';
      }
      $this->json_result($response);
   }

}