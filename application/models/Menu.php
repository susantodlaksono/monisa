<?php

class Menu extends CI_Model {

   public function get_menu($mode, $params) {
      if($params['keyword']) {
         $this->db->group_start();
         $this->db->like('a.name', $params['keyword'], 'both');
         $this->db->group_end();
      }
      if($params['status'] != ''){
         $this->db->where('a.status', $params['status']);
      }
      $this->db->order_by('a.parent', 'asc');
      switch ($mode) {
         case 'get':
            return $this->db->get('menu as a', 10, $params['offset'])->result_array();
         case 'count':
            return $this->db->get('menu as a')->num_rows();
      }
   }

   public function get_parent($menu_id){
      $this->db->select('name');
      $this->db->where('id', $menu_id);
      $rs = $this->db->get('menu');
      if($rs){
         $row = $rs->row_array();
         return $row['name'];
      }
   }


}