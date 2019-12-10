<?php

/**
 * @Author: santo
 * @Date:   2018-04-24 00:56:18
 * @Last Modified by:   santo
 * @Last Modified time: 2018-06-25 16:05:16
 */

class App extends CI_Model {

   public function section_head(){
      $this->db->select('name, icon');
      $this->db->where('url', uri_string());
      $rs = $this->db->get('menu');
      return $rs->row_array();
   }

}