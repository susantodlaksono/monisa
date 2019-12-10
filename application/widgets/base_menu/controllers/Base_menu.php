<?php

class Base_menu extends Widgets {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_base_menu');
    }

    public function index(){
        $menu_id = $this->m_base_menu->render_menu($this->_user->id);
        echo $this->m_base_menu->generate_menu($menu_id);
    }

}
