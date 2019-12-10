<?php

class Widget extends Widgets {

   public function __construct() {
      parent::__construct();      
      if (!$this->ion_auth->logged_in()) {
         return '{"msg":"success"}';
      }
   }

   public function index() {
      $params = $this->input->get();
      // $allalias = $this->allMonitoringAlias($params);
      // $alias = $allalias['alias'];
      // $undone = $allalias['no_alias'];;
      // $total = $this->db->where('data_date', $params['date'])->where('alias_type', $params['type'])->count_all_results('alias_monitoring');
      // $master = $this->master($params);
      // $blacklist = $this->status($params, 'blacklist_status');
      // $common = $this->status($params, 'common_status');
      $total = $this->countAll($params, 'count_all');
      $alias = $this->countAll($params, 'alias');
      $undone = $this->countAll($params, 'undone');
      $master = $this->countAll($params, 'master');
      $blacklist = $this->countAll($params, 'blacklist');
      $common = $this->countAll($params, 'common');
      $data = array(
         'alias'=> $alias,
         'master' => $master,
         'undone' => $undone,
         'total' => $total,
         'blacklist' => $blacklist,
         'common' => $common
      );
      $this->render_widget($data, TRUE);
   }

   public function countAll($params, $mode){      
      $this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
      $this->db->join('alias_master as c', 'a.id = c.alias', 'left');
      $this->db->where('a.priority', 1);
      $this->db->where('a.common_ref IS NULL');
      if($mode != 'count_all'){
         if($mode == 'common'){
            $this->db->where('a.common_status', 1);
         }
         if($mode == 'blacklist'){
            $this->db->where('a.blacklist_status', 1);
         }
         if($mode == 'master'){
            $this->db->where('c.id IS NOT NULL');
         }
         if($mode == 'alias'){
            $this->db->where('b.id IS NOT NULL');
         }
         if($mode == 'undone'){
            $this->db->where('a.common_status IS NULL');
            $this->db->where('a.blacklist_status IS NULL');
            $this->db->where('c.id IS NULL');
            $this->db->where('b.id IS NULL');
         }
      }
      
      $this->db->where('a.data_date', $params['date']);
      $this->db->where('a.alias_type', $params['type']);
      return $this->db->count_all_results('alias_monitoring as a');
   }

   private function status($params, $field){
      $this->db->where('data_date', $params['date']);
      $this->db->where('alias_type', $params['type']);
      $this->db->where($field, 1);
      return $this->db->count_all_results('alias_monitoring');
   }

   private function master($params){
      $this->db->join('alias_master as b', 'a.id = b.alias', 'left');
      $this->db->join('users as c', 'b.pic_by = c.id', 'left');
      $this->db->where('a.data_date', $params['date']);
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('b.id IS NOT NULL');
      return $this->db->count_all_results('alias_monitoring as a');
   }

   private function allMonitoringAlias($params){
      $this->db->where('a.data_date', $params['date']);
      $this->db->where('a.alias_type', $params['type']);
      $rs = $this->db->get('alias_monitoring as a')->result_array();
      if($rs){
         $alias = 0;
         $noalias = 0;
         foreach ($rs as $v) {
            $masteralias = $this->_getMasterByAlias($v['id']);
            if($masteralias){
               if($masteralias != $v['alias']){
                  $alias++;
               }
            }else{
               if(!$v['common_status'] && !$v['blacklist_status']){
                  $noalias++;
               }
            }
         }
         return array(
            'alias' => $alias,
            'no_alias' => $noalias,
         );
      }else{
         return array(
            'alias' => 0,
            'no_alias' => 0,
         );
      }
   }

   private function _getMasterByAlias($id){
      $this->db->select('c.alias');
      $this->db->join('alias_master as b', 'a.alias_master = b.id', 'left');
      $this->db->join('alias_monitoring as c', 'b.alias = c.id', 'left');
      $this->db->where('a.alias_parent', $id);
      $rs = $this->db->get('alias_master_mapping as a')->row_array();
      if($rs){
         return $rs['alias'];
      }else{
         return $this->_getMasteryAlias($id);
      }
   }

   private function _getMasteryAlias($id){
      $this->db->select('b.alias');
      $this->db->where('a.alias', $id);
      $this->db->join('alias_monitoring as b', 'a.alias = b.id', 'left');
      $rs = $this->db->get('alias_master as a')->row_array();
      if($rs){
         return $rs['alias'];
      }else{
         return FALSE;
      }
   }
}