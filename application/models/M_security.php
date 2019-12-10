<?php

class M_security extends CI_model{

	public function get_data($table,$mode){

		switch ($mode) {
			case 'get':
				$this->db->select('count(a.phone_number) as subtot,b.username as name');
		      	$this->db->join('users as b', 'a.user_id = b.id', 'left');
				$this->db->like('created_date',date('Y-m-d'));
				$this->db->group_by('a.user_id');
				return $this->db->get($table.' as a')->result_array();
			case 'count':
				$this->db->select('count(phone_number) as totals');
				$this->db->like('created_date',date('Y-m-d'));
				return $this->db->get($table)->row_array();
		}
	}

}

?>