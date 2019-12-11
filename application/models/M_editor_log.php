<?php

class M_editor_log extends CI_model{

	public function getAlias($mode,$params){      
		$this->db->select('a.*, b.id as id_alias, c.id as id_master');
		$this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
		$this->db->join('alias_master as c', 'a.id = c.alias', 'left');
		// $this->db->join('alias_master as c', 'a.alias = c.alias and c.data_date ="'.$params['filter_date'].'"', 'left');
      $this->db->where('a.priority', 1);
      if(!$params['common_ref']){
         $this->db->where('a.common_ref IS NULL');
      }else{
         $this->db->where('a.common_ref', $params['common_ref']);
      }
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('a.data_date', $params['filter_date']);
      if($params['filter_keyword'] != ""){
      	$alias_replaced = str_replace(' ', '+', $params['filter_keyword']);
         $this->db->group_start();
         $this->db->like('a.alias', $alias_replaced);
         $this->db->group_end();
      }
      if($params['filter_common'] != ''){
      	$this->db->where('a.common_status', $params['filter_common'] == 1 ? 1 : NULL);
      }
      if($params['filter_blacklist'] != ''){
      	$this->db->where('a.blacklist_status', $params['filter_blacklist'] == 1 ? 1 : NULL);
      }
      if($params['filter_master'] != ''){
      	if($params['filter_master'] == 1){
      		$this->db->where('c.id IS NOT NULL');
      	}else{
      		$this->db->where('c.id IS NULL');
      	}
      }
      if($params['filter_alias'] != ''){
      	if($params['filter_alias'] == 1){
      		$this->db->where('b.id IS NOT NULL');
      	}else{
      		$this->db->where('b.id IS NULL');
      	}
      }
		// $this->db->where('a.pic_by', $params['user_id']);
		// $this->db->where('b.alias_parent IS NULL');
		// $this->db->where('c.alias IS NOT NULL');
		$this->db->order_by('a.total_news', 'desc');
		switch ($mode) {
			case 'get':
				return $this->db->get('alias_monitoring as a', 30, $params['offset'])->result_array();
			case 'count':
				return $this->db->get('alias_monitoring as a')->num_rows();
		}
	}

   public function getAliasUnder($mode,$params){      
      $this->db->select('a.*, b.id as id_alias, c.id as id_master');
      $this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
      $this->db->join('alias_master as c', 'a.id = c.alias', 'left');
      // $this->db->join('alias_master as c', 'a.alias = c.alias and c.data_date ="'.$params['filter_date'].'"', 'left');
      $this->db->where('a.priority IS NULL');
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('a.data_date', $params['filter_date']);
      
      if($params['filter_keyword'] != ""){
         $alias_replaced = str_replace(' ', '+', $params['filter_keyword']);
         $this->db->group_start();
         $this->db->like('a.alias', $alias_replaced);
         $this->db->group_end();
      }
      if($params['filter_common'] != ''){
         $this->db->where('a.common_status', $params['filter_common'] == 1 ? 1 : NULL);
      }
      if($params['filter_blacklist'] != ''){
         $this->db->where('a.blacklist_status', $params['filter_blacklist'] == 1 ? 1 : NULL);
      }
      if($params['filter_master'] != ''){
         if($params['filter_master'] == 1){
            $this->db->where('c.id IS NOT NULL');
         }else{
            $this->db->where('c.id IS NULL');
         }
      }
      if($params['filter_alias'] != ''){
         if($params['filter_alias'] == 1){
            $this->db->where('b.id IS NOT NULL');
         }else{
            $this->db->where('b.id IS NULL');
         }
      }
      $this->db->order_by('a.total_news', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_monitoring as a', 30, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('alias_monitoring as a')->num_rows();
      }
   }

   public function searchAlias($mode,$params){      
      $this->db->select('a.*, b.id as id_alias, c.id as id_master');
      $this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
      $this->db->join('alias_master as c', 'a.id = c.alias', 'left');
      // $this->db->join('alias_master as c', 'a.alias = c.alias and c.data_date ="'.$params['filter_date'].'"', 'left');
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('a.data_date', $params['date']);
      if($params['keyword'] != ""){
         $alias_replaced = str_replace(' ', '+', $params['keyword']);
         $this->db->group_start();
         $this->db->like('a.alias', $alias_replaced);
         $this->db->group_end();
      }
      $this->db->order_by('a.total_news', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_monitoring as a')->result_array();
         case 'count':
            return $this->db->get('alias_monitoring as a')->num_rows();
      }
   }

   public function searchAliasCommon($mode,$params){      
      $this->db->select('a.*, b.id as id_alias, c.id as id_master');
      $this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent', 'left');
      $this->db->join('alias_master as c', 'a.id = c.alias', 'left');
      $this->db->where('a.common_ref', 1);
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('a.data_date', $params['date']);
      if($params['keyword'] != ""){
         $alias_replaced = str_replace(' ', '+', $params['keyword']);
         $this->db->group_start();
         $this->db->like('a.alias', $alias_replaced);
         $this->db->group_end();
      }
      $this->db->order_by('a.total_news', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_monitoring as a')->result_array();
         case 'count':
            return $this->db->get('alias_monitoring as a')->num_rows();
      }
   }

   public function getAllAliasByMaster($mode, $params){
      $this->db->select('a.id, b.alias, b.data_date, c.username');
      $this->db->join('alias_monitoring as b', 'a.alias_parent = b.id', 'left');
      $this->db->join('users as c', 'a.mapping_by = c.id', 'left');
      $this->db->where('a.alias_master', $params['alias_master_id']);
      $this->db->where('b.alias_type', $params['type']);
      // $this->db->where('b.data_date', $params['filter_date']);
      if($params['filter_keyword'] != ""){
         $alias_replaced = str_replace(' ', '+', $params['filter_keyword']);
         $this->db->group_start();
         $this->db->like('b.alias', $alias_replaced);
         $this->db->group_end();
      }
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_master_mapping as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('alias_master_mapping as a')->num_rows();
      }
   }

   public function getAliasByMaster($mode, $params){      
      $this->db->select('a.id, a.alias, alias_parent');
      $this->db->join('alias_master_mapping as b', 'a.id = b.alias_parent and alias_master = '.$params['alias_master_id'].'', 'left');
      $this->db->where('a.alias_type', $params['type']);
      $this->db->where('a.data_date', $params['filter_date']);

      if($params['filter_keyword'] == ''){
         if($params['master_like_query']){
            $this->db->group_start();
            $i = 0;
            foreach ($params['master_like_query'] as $v) {
               if($i == 0){
                  $this->db->like('a.alias', $v);
               }else{
                  $this->db->or_like('a.alias', $v);
               }
               $i++;
            }
            $this->db->group_end();
         }
      }else{
         $this->db->group_start();
         $this->db->like('a.alias', $params['filter_keyword']);
         $this->db->group_end();
      }
      $this->db->order_by('a.alias', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_monitoring as a')->result_array();
         case 'count':
            return $this->db->get('alias_monitoring as a')->num_rows();
      }
   }

   public function getMaster($mode, $params){      
      $this->db->select('b.id, b.alias, count(c.id) as total_alias, d.username');
      $this->db->join('alias_monitoring as b', 'a.alias = b.id', 'left');
      $this->db->join('alias_master_mapping as c', 'a.id = c.alias_master', 'left');
      $this->db->join('users as d', 'a.pic_by = d.id', 'left');
      $this->db->where('b.alias_type', $params['type']);
      if($params['filter_keyword'] != ""){
         $alias_replaced = str_replace(' ', '+', $params['filter_keyword']);
         $this->db->group_start();
         $this->db->like('b.alias', $alias_replaced);
         $this->db->group_end();
      }
      $this->db->group_by('a.id');
      $this->db->order_by('total_alias', 'desc');
      switch ($mode) {
         case 'get':
            return $this->db->get('alias_master as a', 100, 0)->result_array();
         case 'count':
            return $this->db->get('alias_master as a')->num_rows();
      }
   }

	public function getParentByMaster($params){
		$master_id = $this->getMasterId($params);
		if($master_id){
			$this->db->select('a.id, b.alias as alias_parent');
         $this->db->join('alias_monitoring as b', 'a.alias_parent = b.id');
         $this->db->where('a.alias_master', $master_id['id']);
			return $this->db->get('alias_master_mapping as a')->result_array();
		}else{
			return FALSE;
		}
	}

	public function getMasterId($params){
		$this->db->select('a.id');
		$this->db->where('a.alias', $params['id']);
		return $this->db->get('alias_master as a')->row_array();
	}

	public function bulkCommon($params, $common){
      $count = 0;
      foreach ($params['data'] as $v) {
         $obj = array(
            'common_status' => $common
         );
         $this->db->where('id', $v);
         $rs = $this->db->update('alias_monitoring', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

   public function bulkMaster($params){
      $count = 0;
      foreach ($params['data'] as $v) {
         if($this->db->where('alias', $v)->count_all_results('alias_master') == 0){
            $obj = array(
               'alias' => $v,
               'pic_by' => $params['user_id'],
            );
            $rs = $this->db->insert('alias_master', $obj);
            $rs ? $count++ : FALSE;
         }
      }
      return $count;
   }
   public function bulkRemoveMaster($params){
      $count = 0; 
      foreach ($params['data'] as $v) {
         $obj = array(
            'alias' => $v,
         );
         $rs = $this->db->delete('alias_master', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

   public function bulkBlacklist($params, $blacklist){
      $count = 0;
      foreach ($params['data'] as $v) {
         $obj = array(
            'blacklist_status' => $blacklist
         );
         $this->db->where('id', $v);
         $rs = $this->db->update('alias_monitoring', $obj);
         $rs ? $count++ : FALSE;
      }
      return $count;
   }

}