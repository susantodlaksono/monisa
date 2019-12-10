<?php

class Users extends CI_Model {

   public function get_users($mode, $params) {
      // $this->db->select('group_concat(b.group_id SEPARATOR ", ")');
      $this->db->join('users_groups as b', 'a.id = b.user_id', 'left');
      if($params['keyword']) {
         $this->db->group_start();
         $this->db->like('a.username', $params['keyword'], 'both');
         $this->db->or_like('a.email', $params['keyword'], 'both');
         $this->db->or_like('a.first_name', $params['keyword'], 'both');
         $this->db->group_end();
      }
      if($params['status'] != ''){
         $this->db->where('a.active', $params['status']);
      }
      if($params['role'] != ''){
         $this->db->where_in('b.group_id', $params['role']);
      }
      $this->db->order_by('a.id', 'desc');
      $this->db->group_by('b.user_id');
      switch ($mode) {
         case 'get':
            return $this->db->get('users as a', 10, $params['offset'])->result_array();
         case 'count':
            // $this->db->group_by('b.user_id');
            return $this->db->get('users as a')->num_rows();
      }
   }

   public function get_role($user_id) {
      $this->db->select('b.name');
      $this->db->join('groups as b', 'a.group_id = b.id');
      $this->db->where('a.user_id', $user_id);
      return $this->db->get('users_groups as a')->result_array();
   }


}