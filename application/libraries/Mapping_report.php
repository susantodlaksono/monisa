<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

/**
 *
 * @author SUSANTO DWI LAKSONO
 */

class Mapping_report{

   public function __construct() {
      $this->_ci = & get_instance();
   }

   public function downloadAlias($params, $mode){
      
      $data['alias'] = $this->getAll($params, 'alias');
      $data['no_alias'] = $this->getAll($params, 'undone');
      $data['master_alias'] = $this->getAll($params, 'master');
      $data['blacklist_name'] = $this->getAll($params, 'blacklist');
      $data['common_name'] = $this->getAll($params, 'common');

      // $data['common_name'] = $this->_commonName($params);
      // $data['blacklist_name'] = $this->_blacklist($params);
      // $data['master_alias'] = $this->_masterAlias($params);
      // $monitoringalias = $this->_allMonitoringAlias($params);
      // $data['alias'] = $monitoringalias['alias'];
      // $data['no_alias'] = $monitoringalias['no_alias'];
      $data['mode'] = $mode;
      switch ($params['alias_type']) {
         case '1':
            $label = 'Person';
            break;
         case '2':
            $label = 'Organization';
            break;
         case '3':
            $label = 'Location';
            break;
         
         default:
            # code...
            break;
      }
      if($params['sdate'] == $params['edate']){
         $data['filename'] = 'Alias '.$label.' (Generate '.date('d M Y', strtotime($params['sdate'])).')';
      }else{
         $data['filename'] = 'Alias '.$label.' (Generate '.date('d M Y', strtotime($params['sdate'])).' sd '.date('d M Y', strtotime($params['edate'])).')';
      }
      return $this->_ci->load->view('report/_alias', $data, TRUE);
   }

   public function downloadCommonPerson($params, $mode){
      $data['common_name'] = $this->getAll($params, 'common');
      $data['mode'] = $mode;
      switch ($params['alias_type']) {
         case '1':
            $label = 'Person';
            break;
         case '2':
            $label = 'Organization';
            break;
         case '3':
            $label = 'Location';
            break;
         
         default:
            # code...
            break;
      }
      if($params['sdate'] == $params['edate']){
         $data['filename'] = 'Common '.$label.' (Generate '.date('d M Y', strtotime($params['sdate'])).')';
      }else{
         $data['filename'] = 'Common '.$label.' (Generate '.date('d M Y', strtotime($params['sdate'])).' sd '.date('d M Y', strtotime($params['edate'])).')';
      }
      return $this->_ci->load->view('report/_common_person', $data, TRUE);
   }

   public function getAll($params, $mode){      
      $this->_ci->db->select('a.id, a.alias');
      $this->_ci->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
      $this->_ci->db->join('alias_master as c', 'a.id = c.alias', 'left');
      $this->_ci->db->where('a.priority', 1);
      if($mode == 'common'){
         $this->_ci->db->where('a.common_status', 1);
      }
      if($mode == 'blacklist'){
         $this->_ci->db->where('a.blacklist_status', 1);
      }
      if($mode == 'master'){
         $this->_ci->db->where('c.id IS NOT NULL');
      }
      if($mode == 'alias'){
         $this->_ci->db->where('b.id IS NOT NULL');
      }
      if($mode == 'undone'){
         $this->_ci->db->where('a.common_status IS NULL');
         $this->_ci->db->where('a.blacklist_status IS NULL');
         $this->_ci->db->where('c.id IS NULL');
         $this->_ci->db->where('b.id IS NULL');
      }
      // $this->_ci->db->where('a.data_date', $params['data_date']);
      $this->_ci->db->where('a.data_date BETWEEN "' . $params['sdate'] . '" AND "' . $params['edate'] . '"');

      $this->_ci->db->where('a.alias_type', $params['alias_type']);
      $result = $this->_ci->db->get('alias_monitoring as a')->result_array();
      if($result){
         foreach ($result as $v) {
            if($mode != 'alias'){
               $data[$v['id']]['alias'] = $v['alias'];
               if($mode == 'master'){
                  $data[$v['id']]['username'] = $this->getUsernameMasterById($v['id']);
               }
            }else{
               $data[$v['id']]['alias'] = $v['alias'];
               $data[$v['id']]['master'] = $this->getMasterById($v['id']);
               $data[$v['id']]['username'] = $this->getUsernameById($v['id']);
            }
         }
         return $data;
      }else{
         return false;
      }
   }

   public function getMasterById($id){
      $this->_ci->db->select('c.alias');
      $this->_ci->db->join('alias_master as b', 'a.alias_master = b.id', 'left');
      $this->_ci->db->join('alias_monitoring as c', 'b.alias = c.id', 'left');
      $this->_ci->db->where('a.alias_parent', $id);
      $result = $this->_ci->db->get('alias_master_mapping as a')->row_array();
      if($result){
         return $result['alias'];
      }else{
         return FALSE;
      }
   }

   public function getUsernameMasterById($id){
      $this->_ci->db->select('b.username');
      $this->_ci->db->join('users as b', 'a.pic_by = b.id', 'left');
      $this->_ci->db->where('a.alias', $id);
      $result = $this->_ci->db->get('alias_master as a')->row_array();
      if($result){
         return $result['username'];
      }else{
         return FALSE;
      }
   }

   public function getUsernameById($id){
      $this->_ci->db->select('b.username');
      $this->_ci->db->join('users as b', 'a.mapping_by = b.id', 'left');
      $this->_ci->db->where('a.alias_parent', $id);
      $result = $this->_ci->db->get('alias_master_mapping as a')->row_array();
      if($result){
         return $result['username'];
      }else{
         return FALSE;
      }
   }

   public function _masterAlias($params){
      $this->_ci->db->select('a.alias, b.id, c.username');
      $this->_ci->db->join('alias_master as b', 'a.id = b.alias', 'left');
      $this->_ci->db->join('users as c', 'b.pic_by = c.id', 'left');
   	$this->_ci->db->where('a.data_date', $params['data_date']);
   	$this->_ci->db->where('a.alias_type', $params['alias_type']);
      $this->_ci->db->where('b.id IS NOT NULL');
      return $this->_ci->db->get('alias_monitoring as a')->result_array();
      // $this->_ci->db->where('pic_by', $params['user_id']);
   	// return $this->_ci->db->get('alias_master')->result_array();
   }

   public function _commonName($params){
      $this->_ci->db->select('a.id, a.alias');
      $this->_ci->db->where('a.data_date', $params['data_date']);
      // $this->_ci->db->where('a.pic_by', $params['user_id']);
      $this->_ci->db->where('a.alias_type', $params['alias_type']);
      $this->_ci->db->where('a.common_status', 1);
      $rs = $this->_ci->db->get('alias_monitoring as a')->result_array();
      if($rs){
         foreach ($rs as $v) {
            $common[$v['id']]['alias'] = $v['alias'];
         }
         return $common;
      }else{
         return FALSE;
      }
   }

   public function _blacklist($params){
      $this->_ci->db->select('a.id, a.alias');
      $this->_ci->db->where('a.data_date', $params['data_date']);
      // $this->_ci->db->where('a.pic_by', $params['user_id']);
      $this->_ci->db->where('a.alias_type', $params['alias_type']);
      $this->_ci->db->where('a.blacklist_status', 1);
      $rs = $this->_ci->db->get('alias_monitoring as a')->result_array();
      if($rs){
         foreach ($rs as $v) {
            $common[$v['id']]['alias'] = $v['alias'];
         }
         return $common;
      }else{
         return FALSE;
      }
   }

   public function _allMonitoringAlias($params){
   	$this->_ci->db->where('a.data_date', $params['data_date']);
      // $this->_ci->db->where('a.pic_by', $params['user_id']);
   	$this->_ci->db->where('a.alias_type', $params['alias_type']);
   	$rs = $this->_ci->db->get('alias_monitoring as a')->result_array();
   	if($rs){
         $alias = array();
         $noalias = array();
   		foreach ($rs as $v) {
            $masteralias = $this->_getMasterByAlias($v['id']);
            if($masteralias){
               if($masteralias != $v['alias']){
                  $alias[$v['id']]['alias'] = $v['alias'];
                  $alias[$v['id']]['master'] = $masteralias;
               }
            }else{
               if(!$v['common_status'] && !$v['blacklist_status']){
                  $noalias[$v['id']]['alias'] = $v['alias'];
               }
            }
   		}
   		return array(
            'alias' => $alias,
            'no_alias' => $noalias,
         );
   	}else{
   		return array(
            'alias' => FALSE,
            'no_alias' => FALSE,
         );
   	}
   }

   public function _getMasterByAlias($id){
		$this->_ci->db->select('c.alias');
		$this->_ci->db->join('alias_master as b', 'a.alias_master = b.id', 'left');
      $this->_ci->db->join('alias_monitoring as c', 'b.alias = c.id', 'left');
		$this->_ci->db->where('a.alias_parent', $id);
		$rs = $this->_ci->db->get('alias_master_mapping as a')->row_array();
		if($rs){
			return $rs['alias'];
		}else{
			return $this->_getMasteryAlias($id);
		}
   }

   public function _getMasteryAlias($id){
   	$this->_ci->db->select('b.alias');
      $this->_ci->db->where('a.alias', $id);
      $this->_ci->db->join('alias_monitoring as b', 'a.alias = b.id', 'left');
   	$rs = $this->_ci->db->get('alias_master as a')->row_array();
   	if($rs){
			return $rs['alias'];
		}else{
			return $this->_aliasNoMaster($id);
		}
   }

   public function _aliasNoMaster($id){
      $this->_ci->db->select('c.alias');
      $this->_ci->db->join('alias_monitoring as c', 'a.alias_parent = c.id', 'left');
      $this->_ci->db->where('a.alias_parent', $id);
      $rs = $this->_ci->db->get('alias_master_mapping as a')->row_array();
      if($rs){
         return $rs['alias'];
      }else{
         return NULL;
      }
   }

   public function excelColumnRange($lower, $upper) {
      ++$upper;
      for ($i = $lower; $i !== $upper; ++$i) {
         $data[] = $i;
      }
      return $data;
   }

}