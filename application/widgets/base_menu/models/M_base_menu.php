<?php

class M_base_menu extends CI_Model {
    protected $_user;

    public function __construct() {
        parent::__construct();
        $this->_user = $this->ion_auth->user()->row();
    }

    public function render_menu($user_id){
        $groups_id = $this->_get_groups($user_id);
        if($groups_id){
            $this->db->where_in('group_id', $groups_id);
            $rs = $this->db->get('menu_groups');
            if($rs->num_rows() > 0){
                foreach ($rs->result_array() as $key => $value) {
                    $menu_id[] = $value['menu_id'];
                }
                return $menu_id;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function _get_groups($user_id){
        $this->db->where('user_id', $user_id);
        $rs = $this->db->get('users_groups');
        if($rs->num_rows() > 0){
            foreach ($rs->result_array() as $key => $value) {
                $group_id[] = $value['group_id'];
            }
            return $group_id;
        }else{
            return false;
        }
    }

    public function menu($id = NULL, $parent = 0) {
        $this->db->from('menu');
        if ($id) {
            $this->db->where_in('id', $id);
        }
        $this->db->where('parent', $parent);
        $this->db->where('status', 1);
        $this->db->order_by('sort', 'asc');
        return $this->db->get()->result_array();
    }

   public function generate_menu($menu_id){
      $r = '';
      $r .= '<ul id="main-menu" class="main-menu">';
         $menu = $this->menu($menu_id, 0);
         if(count($menu) > 0){

            $uri_segment = uri_string();
            $menu_uri_segment = $this->db->select('id,parent')->where('url', uri_string())->get('menu')->row_array();

            foreach ($menu as $v) {
               $sub_menu = $this->menu(NULL, $v['id']);
               if(count($sub_menu) > 0){
                  $menu_uri_segment_first = $this->db->select('id,parent')->where('id', $menu_uri_segment['parent'])->get('menu')->row_array();

                  $r .= '<li class="has-sub '.($v['id'] == $menu_uri_segment_first['parent'] ? 'active' : '').'">';
                     $r .= '<a href="'.site_url($v['url']).'">';
                        $r .= '<i class="'.$v['icon'].'"></i>';
                        $r .= '<span class="title" style="border: 1px solid #303641;">'.$v['name'].'</span>';
                     $r .= '</a>';
                     $r .= '<ul style="border: 1px solid #3e3e3e;">';
                        foreach ($sub_menu as $vv) {
                           $sub_menu_third = $this->menu(NULL, $vv['id']);
                           if(count($sub_menu_third) > 0){
                              $r .= '<li class="has-sub '.($vv['id'] == $menu_uri_segment['parent'] ? 'active' : '').'">';
                                 $r .= '<a href="'.site_url($vv['url']).'">';
                                    $r .= '<i class="'.$vv['icon'].'"></i>';
                                    $r .= '<span class="title">'.$vv['name'].'</span>';
                                 $r .= '</a>';
                                 $r .= '<ul style="border: 1px solid #3e3e3e;">';
                                    foreach ($sub_menu_third as $vvv) {
                                       $r .= '<li class="'.($vvv['url'] == uri_string() ? 'active' : '').'">';
                                          $r .= '<a href="'.site_url($vvv['url']).'">';
                                             $r .= '<i class="'.$vvv['icon'].'"></i>';
                                             $r .= '<span class="title">'.$vvv['name'].'</span>';
                                          $r .= '</a>';
                                       $r .= '</li>';
                                    }
                                 $r .= '</ul>';
                              $r .= '</li>';
                           }else{
                              $r .= '<li class="'.($vv['id'] == $menu_uri_segment['id'] ? 'active' : '').'">';
                                 $r .= '<a href="'.site_url($vv['url']).'">';
                                    $r .= '<i class="'.$vv['icon'].'"></i>';
                                    $r .= '<span class="title">'.$vv['name'].'</span>';
                                 $r .= '</a>';
                              $r .= '</li>';
                           }
                        }
                     $r .= '</ul>';
                  $r .= '</li>';
                  // $third_menu = $this->menu(NULL, $vv['id'], $rstatus);
               }else{
                  $r .= '<li class="'.($v['id'] == $menu_uri_segment['id'] ? 'active' : '').'">';
                     $r .= '<a href="'.site_url($v['url']).'">';
                        $r .= '<i class="'.$v['icon'].'"></i>';
                        $r .= '<span class="title">'.$v['name'].'</span>';
                     $r .= '</a>';
                  $r .= '</li>';
               }
            }
         }
      $r .= '</ul>';
      return $r;
   }


}
