<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
/**
 *
 * @author SUSANTO DWI LAKSONO
 */

class Reporting extends MY_Controller {
	public function __construct() {
  		parent::__construct();
      $this->load->library('mapping_report');
	}

	public function downloadAlias(){
      $this->load->library('mapping_report');
      $params = $this->input->get();
      $params['user_id'] = $this->_user->id;
      return $this->mapping_report->downloadAlias($params, 'download');
   }

   public function downloadCommonPerson(){
      $this->load->library('mapping_report');
      $params = $this->input->get();
      $params['user_id'] = $this->_user->id;
      return $this->mapping_report->downloadCommonPerson($params, 'download');
   }

}