<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

ini_set('memory_limit', '1G');

class Bulk_uploader{

   public function __construct() {
      $this->ci = & get_instance();
      $this->ci->load->library('PHPExcel');
      $this->ci->load->library('excel_reader');
   }

   public function uploadAlias($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) {
            if ($row != 1) {
               if(isset($value['A'])){
                  $replaced_alias = $this->replacedAlias($value['A'], $params['data_date'], $params['user_id']);
                  if(!$replaced_alias['found']){
                     $data[$i]['alias'] = $replaced_alias['replaced'];
                     $data[$i]['total_news'] = isset($value['B']) ? $value['B'] : NULL;
                  }
               }
               $i++;
            }
            $row++;
         }
         if($data){
            $log = array(
               'uploaded_date' => date('Y-m-d H:i:s'),
               'uploaded_by' => $params['user_id'],
               'total_alias' => count($data),
               'alias_type' => $params['type'],
            );
            $this->ci->db->insert('upload_alias_log', $log);
            $log_id = $this->ci->db->insert_id();
            
            $dataunique = $this->multiUnique($data);

            foreach ($dataunique as $v) {
               $tmp = array();
               $tmp['log_id'] = $log_id;
               $tmp['alias'] = $v['alias'];
               $tmp['data_date'] = $params['data_date'];
               $tmp['total_news'] = $v['total_news'];
               $tmp['alias_type'] = $params['type'];
               $tmp['pic_by'] = $params['user_id'];

               if($params['type'] == 1){
                  $explode = explode('+', $v['alias']);
                  if(count($explode) == 1){
                     $tmp['common_ref'] = 1;   
                  }
               }

               if($v['total_news'] > 5){
                  $tmp['priority'] = 1;
               }

               // $create_alias_monitoring = "CALL create_alias_monitoring(?, ?, ?, ?, ?, ?)";
               // $insert = $this->ci->db->query($create_alias_monitoring, $tmp);

               $insert = $this->ci->excel_reader->on_duplicate('alias_monitoring', array_filter($tmp));
               if($insert){
                 $insert ? $count++ : FALSE;
               }
            }

            $response = array(
               'success' => TRUE,
               'data' => $data,
               'dataunique' => $dataunique,
               'msg' => ''.$count.' Data berhasil ditambahkan'
            );
         }else{
            $response = array(
               'success' => FALSE,
               'msg' => 'List not found',
            );
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }


   public function multiUnique($src){
      $output = array_map("unserialize",
      array_unique(array_map("serialize", $src)));
      return $output;
   }

   public function replacedAlias($alias, $data_date, $pic_by){
      $data['replaced'] = str_replace(' ', '+', $alias);
      // $check = $this->ci->db->where('alias_parent', $data['replaced'])
      //                         ->or_where('alias_master', $data['replaced'])
      //                         ->where('data_date', $data_date)
      //                         ->get('alias_master_mapping')->num_rows();
      $check = $this->ci->db->where('alias', $data['replaced'])
                              ->where('data_date', $data_date)
                              ->where('pic_by', $pic_by)
                              ->get('alias_monitoring')->num_rows();
      if($check > 0){
         $data['found'] = TRUE;
      }else{
         $data['found'] = FALSE;
      }
      return $data;
   }

   public function bulkSimcard($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 0;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) {
            if ($row >= 2) {
               $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               $data[$i]['active_period'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['saldo'] = isset($value['C']) ? $value['C'] : NULL;
               $data[$i]['rak_id'] = isset($value['D']) ? $value['D'] : NULL;
               $data[$i]['status_id'] = isset($value['E']) ? $value['E'] : NULL;
            	$i++;
            }
            $row++;
         }
         if($data){
      		if($keycode == 1){
      			foreach ($data as $v) {
      				$tmp = array();
      				if($v['phone_number']){
      					if($v['active_period'] || $v['saldo'] || $v['rak_id'] || $v['status_id']){
                        if($v['status_id'] == 3){
                           $tmp['active_period'] = NULL;
                           $tmp['expired_date'] = NULL;
                           $tmp['status'] = 3;
                        }else{
                           if($v['active_period']){
                              $tmp['active_period'] = date('Y-m-d', strtotime($v['active_period']));
                              $tmp['expired_date'] = date('Y-m-d', strtotime($v['active_period']. ' + 25 days'));
                              $compare_left_days = $this->compare_left_days(date('Y-m-d'), $tmp['expired_date']);
                              if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
                                 $tmp['status'] = 0;
                              }
                              if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
                                 $tmp['status'] = 1;
                              }
                              if($compare_left_days['opr'] == '-'){
                                 $tmp['status'] = 2;
                              }
                           }
                        }
	      					if($v['saldo']){
	      						if($v['saldo'] == '-'){
                              $tmp['saldo'] = 0;
                           }else{
                              $tmp['saldo'] = $v['saldo'];
                           }
	      					}
                        
	      					if($v['rak_id'] && is_numeric($v['rak_id'])){
	      						$rak = $this->ci->db->where('id', $v['rak_id'])->count_all_results('rak');
	      						if($rak > 0){
	      							$tmp['rak_id'] = $v['rak_id'];
	      						}
	      					}
	      					$tmp['updated_user_id'] = $params['user_id'];
	      					$tmp['updated_date'] = date('Y-m-d H:i:s');

	      					$update = $this->ci->db->update('simcard', $tmp, array('phone_number' => $v['phone_number']));
	               		$update ? $count++ : FALSE;
      					}
   					}
   				}
      			$response = array(
		         	'success' => TRUE,
		         	'data' => $data,
		         	'msg' => ''.$count.' Data berhasil diperbaharui'
		         );
      		}else{
      			$response = array(
		         	'success' => FALSE,
		         	'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
		         );
      		}
         }else{
         	$response = array(
	         	'success' => FALSE,
	         	'msg' => 'List not found',
	         );
         }
      }else{
         $response = array(
         	'success' => FALSE,
         	'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

   public function bulkTwitter($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 0;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $sheetmode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ4:ZZ4');
         $keycode = $sheetcode[0][0];
         $keymode = $sheetmode[0][0];
         foreach ($worksheet as $value) {
            if ($row >= 2) {
               if($keymode == 1){
                  $data[$i]['key_data'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               }
               if($keymode == 2){
                  $data[$i]['key_data'] = isset($value['A']) ? $value['A'] : NULL;
               }
               $data[$i]['client_id'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['status'] = isset($value['C']) ? $value['C'] : NULL;
               $data[$i]['proxy_id'] = isset($value['D']) ? $value['D'] : NULL;
               $data[$i]['screen_name'] = isset($value['E']) ? $value['E'] : NULL;
               $data[$i]['display_name'] = isset($value['F']) ? $value['F'] : NULL;
               $i++;
            }
            $row++;
         }
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  $tmp = array();
                  if($v['key_data']){
                     if($v['client_id'] || $v['status'] || $v['proxy_id'] || $v['screen_name'] || $v['display_name']){
                        if($v['client_id'] && is_numeric($v['client_id'])){
                           $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                           if($client_id > 0){
                              $tmp['client_id'] = $v['client_id'];
                           }
                        }
                        if($v['status'] && is_numeric($v['status'])){
                           $status = $this->ci->db->where('id', $v['status'])->count_all_results('twitter_status_detail');
                           if($status > 0){
                              $tmp['status'] = $v['status'];
                           }
                        }
                        if($v['proxy_id'] && is_numeric($v['proxy_id'])){
                           $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                           if($proxy_id > 0){
                              $tmp['proxy_id'] = $v['proxy_id'];
                           }
                        }

                        if($v['screen_name']){
                           $tmp['screen_name'] = $v['screen_name'];
                        }

                        if($v['display_name']){
                           $tmp['display_name'] = $v['display_name'];
                        }

                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');

                        if($keymode == 1){
                           $update = $this->ci->db->update('twitter', $tmp, array('phone_number' => $v['key_data']));
                        }
                        if($keymode == 2){
                           $update = $this->ci->db->update('twitter', $tmp, array('screen_name' => preg_replace('/[^a-zA-Z0-9\_]/', '', strtolower($v['key_data']))));
                        }
                        $update ? $count++ : FALSE;
                     }
                  }  
               }
               $response = array(
                  'success' => TRUE,
                  'data' => $data,
                  'msg' => ''.$count.' data berhasil di perbaharui'
               );
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }else{
            $response = array(
               'success' => FALSE,
               'msg' => 'List not found',
            );
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

   public function bulkFacebook($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 0;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) {
            if ($row >= 2) {
               $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               $data[$i]['client_id'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['status'] = isset($value['C']) ? $value['C'] : NULL;
               $data[$i]['proxy_id'] = isset($value['D']) ? $value['D'] : NULL;
               $i++;
            }
            $row++;
         }
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  $tmp = array();
                  if($v['phone_number']){
                     if($v['client_id'] || $v['status'] || $v['proxy_id']){
                        if($v['client_id'] && is_numeric($v['client_id'])){
                           $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                           if($client_id > 0){
                              $tmp['client_id'] = $v['client_id'];
                           }
                        }
                        if($v['status'] && is_numeric($v['status'])){
                           $tmp['status'] = $v['status'];
                        }
                        if($v['proxy_id'] && is_numeric($v['proxy_id'])){
                           $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                           if($proxy_id > 0){
                              $tmp['proxy_id'] = $v['proxy_id'];
                           }
                        }
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');

                        $update = $this->ci->db->update('facebook', $tmp, array('phone_number' => $v['phone_number']));
                        $update ? $count++ : FALSE;
                     }
                  }
               }
               $response = array(
                  'success' => TRUE,
                  'data' => $data,
                  'msg' => ''.$count.' data was successfully updated from '.count($data).' legible data'
               );
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }else{
            $response = array(
               'success' => FALSE,
               'msg' => 'List not found',
            );
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

    public function bulkInstagram($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count = 0;
         $i = 0;
         $row = 0;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $sheetmode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ4:ZZ4');
         $keycode = $sheetcode[0][0];
         $keymode = $sheetmode[0][0];
         foreach ($worksheet as $value) {
            if ($row >= 2) {
               if($keymode == 1){
                  $data[$i]['key_data'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               }
               if($keymode == 2){
                  $data[$i]['key_data'] = isset($value['A']) ? $value['A'] : NULL;
               }
               $data[$i]['client_id'] = isset($value['B']) ? $value['B'] : NULL;
               $data[$i]['status'] = isset($value['C']) ? $value['C'] : NULL;
               $data[$i]['proxy_id'] = isset($value['D']) ? $value['D'] : NULL;
               $i++;
            }
            $row++;
         }
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  $tmp = array();
                  if($v['key_data']){
                     if($v['client_id'] || $v['status'] || $v['proxy_id']){
                        if($v['client_id'] && is_numeric($v['client_id'])){
                           $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                           if($client_id > 0){
                              $tmp['client_id'] = $v['client_id'];
                           }
                        }
                        if($v['status'] && is_numeric($v['status'])){
                           $tmp['status'] = $v['status'];
                        }
                        if($v['proxy_id'] && is_numeric($v['proxy_id'])){
                           $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                           if($proxy_id > 0){
                              $tmp['proxy_id'] = $v['proxy_id'];
                           }
                        }
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');

                        if($keymode == 1){
                           $update = $this->ci->db->update('instagram', $tmp, array('phone_number' => $v['key_data']));
                        }
                        if($keymode == 2){
                           $update = $this->ci->db->update('instagram', $tmp, array('username' => strtolower(preg_replace('/[^a-zA-Z0-9\_]/', '', $v['key_data']))));
                        }
                        $update ? $count++ : FALSE;
                     }
                  }
               }
               $response = array(
                  'success' => TRUE,
                  'data' => $data,
                  'msg' => ''.$count.' data diperbaharui'
               );
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }else{
            $response = array(
               'success' => FALSE,
               'msg' => 'List not found',
            );
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

   public function migrationSimcard($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                  $data[$i]['active_period'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B'])) : NULL;
                  $data[$i]['expired_date'] = isset($value['B']) ? date('Y-m-d', strtotime($value['B']. ' + 25 days')) : NULL;
                  $data[$i]['nik'] = isset($value['C']) && is_numeric($value['C']) ? $value['C'] : NULL;
                  $data[$i]['nkk'] = isset($value['D']) && is_numeric($value['D']) ? $value['D'] : NULL;
                  $data[$i]['saldo'] = isset($value['E']) && is_numeric($value['E']) ? $value['E'] : NULL;
                  $data[$i]['provider_id'] = isset($value['F']) && is_numeric($value['F']) ? $value['F'] : NULL;
                  $data[$i]['rak_id'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                  $data[$i]['user_id'] = isset($value['H']) && is_numeric($value['H']) ? $value['H'] : NULL;
                  $data[$i]['info'] = isset($value['I']) ? $value['I'] : NULL;
                  $i++;
               }
            }
            $row++;
         }
         
         if($data){
         	if($keycode == 1){
	            foreach ($data as $v) {
	               if($v['phone_number']){
	               	$tmp = array();
	                  $compare_left_days = $this->compare_left_days(date('Y-m-d'), $v['expired_date']);
	                  if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] <= 7){
	                     $tmp['status'] = 0;
	                  }
	                  if($compare_left_days['opr'] == '+' && $compare_left_days['digit'] > 7){
	                     $tmp['status'] = 1;
	                  }
	                  if($compare_left_days['opr'] == '-'){
	                     $tmp['status'] = 2;
	                  }
	                  $tmp['phone_number_type'] = 1;
	                  $tmp['phone_number'] = $v['phone_number'];
	                  $tmp['active_period'] = $v['active_period'];
	                  $tmp['expired_date'] = $v['expired_date'];
	                  $tmp['nik'] = $v['nik'];
	                  $tmp['nkk'] = $v['nkk'];
	                  $tmp['saldo'] = $v['saldo'];
	                  $tmp['info'] = $v['info'];
	                  
	                  if($v['provider_id']){
      						$provider = $this->ci->db->where('id', $v['provider_id'])->count_all_results('provider');
      						if($provider > 0){
      							$tmp['provider_id'] = $v['provider_id'];
      						}
      					}
      					if($v['rak_id']){
      						$rak = $this->ci->db->where('id', $v['rak_id'])->count_all_results('rak');
      						if($rak > 0){
      							$tmp['rak_id'] = $v['rak_id'];
      						}
      					}
      					if($v['user_id'] && $v['user_id'] !== 0){
      						$user_id = $this->ci->db->where('id', $v['user_id'])->count_all_results('users');
      						if($user_id > 0){
      							$tmp['user_id'] = $v['user_id'];
      						}
      					}
	                  if($this->ci->db->where('phone_number', $v['phone_number'])->get('simcard')->num_rows() > 0){
	                  	$tmp['updated_user_id'] = $params['user_id'];
	      					$tmp['updated_date'] = date('Y-m-d H:i:s');
	                     $update = $this->ci->db->update('simcard', $tmp, array('phone_number' => $v['phone_number']));
	                     if($update){
	                        $update ? $count_update++ : false;
	                     }
	                  }else{
                        $tmp['created_date'] = date('Y-m-d H:i:s');
	                     $insert = $this->ci->db->insert('simcard', $tmp);
	                     if($insert){
	                       $insert ? $count_insert++ : false;
	                     }
	                  }
	               }
	            }
	            $response = array(
		            'success' => TRUE,
		            'msg' => $count_insert.' data dibuat dan '.$count_update.' data diperbaharui'
		         );
            }else{
            	$response = array(
		         	'success' => FALSE,
		         	'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
		         );
            }
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

   public function migrationEmail($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               $email = isset($value['B']) ? $value['B'] : NULL;
               if($phone_number){
                  if($this->ci->db->where('phone_number', $phone_number)->count_all_results('simcard') > 0){
                     if($email){
                        if($this->ci->db->where('email', $email)->count_all_results('email') == 0){
                           $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                           $data[$i]['email'] = isset($value['B']) ? $value['B'] : NULL;
                           $data[$i]['password'] = isset($value['C']) ? $value['C'] : NULL;
                           $data[$i]['birth_day'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                           $data[$i]['display_name'] = isset($value['E']) ? $value['E'] : NULL;
                           $data[$i]['user_id'] = isset($value['F']) && is_numeric($value['F']) ? $value['F'] : NULL;
                           $data[$i]['status_id'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                           $data[$i]['info'] = isset($value['H']) ? $value['H'] : NULL;
                        }
                        else{
                           if($this->ci->db->where('email', $email)->where('phone_number', $phone_number)->count_all_results('email') > 0){
                              $data[$i]['phone_number'] = isset($value['A']) ? $this->check_character($value['A']) : NULL;
                              $data[$i]['email'] = isset($value['B']) ? $value['B'] : NULL;
                              $data[$i]['password'] = isset($value['C']) ? $value['C'] : NULL;
                              $data[$i]['birth_day'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                              $data[$i]['display_name'] = isset($value['E']) ? $value['E'] : NULL;
                              $data[$i]['user_id'] = isset($value['F']) && is_numeric($value['F']) ? $value['F'] : NULL;
                              $data[$i]['status_id'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                              $data[$i]['info'] = isset($value['H']) ? $value['H'] : NULL;
                           }
                        }

                     }
                  }
                  $i++;
               }
            }
            $row++;
         }
         
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  if($v['phone_number']){
                     $tmp = array();
                     $tmp['phone_number_type'] = 1;
                     $tmp['phone_number'] = $v['phone_number'];
                     $tmp['email'] = $v['email'];
                     $tmp['display_name'] = $v['display_name'];
                     $tmp['password'] = $v['password'];
                     $tmp['birth_day'] = $v['birth_day'];
                     $tmp['status'] = $v['status_id'];
                     $tmp['info'] = $v['info'];
                     
                     if($v['user_id'] && $v['user_id'] !== 0){
                        $user_id = $this->ci->db->where('id', $v['user_id'])->count_all_results('users');
                        if($user_id > 0){
                           $tmp['user_id'] = $v['user_id'];
                        }
                     }
                     if($this->ci->db->where('phone_number', $v['phone_number'])->where('email', $v['email'])->get('email')->num_rows() > 0){
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');
                        $update = $this->ci->db->update('email', $tmp, array('phone_number' => $v['phone_number']));
                        if($update){
                           $this->ci->db->update('simcard', array('registered' => 1), array('phone_number' => $v['phone_number']));
                           $update ? $count_update++ : false;
                        }
                     }else{
                        $tmp['created_date'] = date('Y-m-d H:i:s');
                        $insert = $this->ci->db->insert('email', $tmp);
                        if($insert){
                           $this->ci->db->update('simcard', array('registered' => 1), array('phone_number' => $v['phone_number']));
                          $insert ? $count_insert++ : false;
                        }
                     }
                  }
               }
               $response = array(
                  'success' => TRUE,
                  'msg' => $count_insert.' data dibuat dan '.$count_update.' data diperbaharui'
               );
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }else{
            $response = array(
               'success' => FALSE,
               'msg' => 'Tidak ada data yang dapat diperbarui atau ditambahkan',
            );
         }
      }else{
         $response = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $response;
   }

   public function migrationTwitter($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character(trim($value['A'])) : NULL;
               if($phone_number){
                  $count = $this->ci->db->where('phone_number', $phone_number)->where('registered', 1)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['created_twitter'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['phone_number'] = $phone_number;
                     $data[$i]['display_name'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['screen_name'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['password'] = isset($value['E']) ? $value['E'] : NULL;
                     $data[$i]['cookies'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['twitter_id'] = isset($value['G']) && is_numeric($value['G']) ? $value['G'] : NULL;
                     $data[$i]['followers'] = isset($value['H'])  && is_numeric($value['H']) ? $value['H'] : NULL;
                     $data[$i]['apps_id'] = isset($value['I'])  && is_numeric($value['I']) ? $value['I'] : NULL;
                     $data[$i]['apps_name'] = isset($value['J']) ? $value['J'] : NULL;
                     $data[$i]['consumer_key'] = isset($value['K']) ? $value['K'] : NULL;
                     $data[$i]['consumer_secret'] = isset($value['L']) ? $value['L'] : NULL;
                     $data[$i]['access_token'] = isset($value['M']) ? $value['M'] : NULL;
                     $data[$i]['access_token_secret'] = isset($value['N']) ? $value['N'] : NULL;
                     $data[$i]['client_id'] = isset($value['O']) && is_numeric($value['O']) ? $value['O'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['P']) && is_numeric($value['P']) ? $value['P'] : NULL;
                     $data[$i]['user_id'] = isset($value['Q']) && is_numeric($value['Q']) ? $value['Q'] : NULL;
                     $data[$i]['status'] = isset($value['R']) && is_numeric($value['R']) ? $value['R'] : NULL;
                     $data[$i]['info'] = isset($value['S']) ? $value['S'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  if($v['phone_number']){
                     $email = $this->ci->db->select('birth_day')->where('phone_number', $v['phone_number'])->get('email')->row_array();
                     $tmp = array();
                     $tmp['phone_number'] = $v['phone_number'];
                     $tmp['birth_date'] = $email['birth_day'] ? date('Y-m-d', strtotime($email['birth_day'])) : NULL;
                     $tmp['display_name'] = $v['display_name'];
                     $tmp['screen_name'] = strtolower(preg_replace('/[^a-zA-Z0-9\_]/', '', $v['screen_name']));
                     $tmp['created_twitter'] = $v['created_twitter'];
                     $tmp['password'] = $v['password'];
                     $tmp['cookies'] = $v['cookies'];
                     $tmp['twitter_id'] = $v['twitter_id'];
                     $tmp['followers'] = $v['followers'];
                     $tmp['status'] = $v['status'] ? $this->check_migration_master('twitter_status_detail', 'id', $v['status']) : NULL;
                     $tmp['apps_id'] = $v['apps_id'];
                     $tmp['apps_name'] = $v['apps_name'];
                     $tmp['consumer_key'] = $v['consumer_key'];
                     $tmp['consumer_secret'] = $v['consumer_secret'];
                     $tmp['access_token'] = $v['access_token'];
                     $tmp['info'] = $v['info'];
                     $tmp['access_token_secret'] = $v['access_token_secret'];

                     if($v['client_id'] && $v['client_id'] !== 0){
                        $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                        if($client_id > 0){
                           $tmp['client_id'] = $v['client_id'];
                        }
                     }

                     if($v['proxy_id'] && $v['proxy_id'] !== 0){
                        $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                        if($proxy_id > 0){
                           $tmp['proxy_id'] = $v['proxy_id'];
                        }
                     }

                     if($v['user_id'] && $v['user_id'] !== 0){
                        $user_id = $this->ci->db->where('id', $v['user_id'])->count_all_results('users');
                        if($user_id > 0){
                           $tmp['user_id'] = $v['user_id'];
                        }
                     }

                     if($this->ci->db->where('phone_number', $v['phone_number'])->get('twitter')->num_rows() > 0){
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');
                        $update = $this->ci->db->update('twitter', $tmp, array('phone_number' => $v['phone_number']));
                        if($update){
                           $this->ci->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
                           $update ? $count_update++ : false;
                        }
                     }else{
                        $insert = $this->ci->db->insert('twitter', $tmp);
                        if($insert){
                           $this->ci->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
                           $insert ? $count_insert++ : false;
                        }
                     }
                  }
               }
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }
         $result = array(
            'success' => TRUE,
            'msg' => $count_insert.' data dibuat dan '.$count_update.' data diperbaharui'
         );
      }else{
         $result = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $result;
   }

   public function migrationFacebook($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $count = $this->ci->db->where('phone_number', $phone_number)->where('registered', 1)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['phone_number'] = $phone_number;
                     $data[$i]['display_name'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['url'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['created_facebook'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['facebook_id'] =  isset($value['E']) && is_numeric($value['E']) ? $value['E'] : NULL;
                     $data[$i]['password'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['cookies'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['access_token'] = isset($value['H']) ? $value['H'] : NULL;
                     $data[$i]['friends'] =  isset($value['I']) && is_numeric($value['I']) ? $value['I'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['J']) && is_numeric($value['J']) ? $value['J'] : NULL;
                     $data[$i]['client_id'] = isset($value['K']) && is_numeric($value['K']) ? $value['K'] : NULL;
                     $data[$i]['status'] = isset($value['L']) ? $value['L'] : NULL;
                     $data[$i]['user_id'] = isset($value['M']) && is_numeric($value['M']) ? $value['M'] : NULL;
                     $data[$i]['info'] = isset($value['N']) ? $value['N'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  if($v['phone_number']){
                     $email = $this->ci->db->select('birth_day')->where('phone_number', $v['phone_number'])->get('email')->row_array();
                     $tmp = array();
                     $tmp['phone_number'] = $v['phone_number'];
                     $tmp['birth_date'] = $email['birth_day'] ? date('Y-m-d', strtotime($email['birth_day'])) : NULL;
                     $tmp['display_name'] = $v['display_name'];
                     $tmp['url'] = $v['url'];
                     $tmp['created_facebook'] = $v['created_facebook'];
                     $tmp['facebook_id'] = $v['facebook_id'];
                     $tmp['password'] = $v['password'];
                     $tmp['cookies'] = $v['cookies'];
                     $tmp['access_token'] = $v['access_token'];
                     $tmp['friends'] = $v['friends'];
                     $tmp['info'] = $v['info'];

                     if($v['client_id'] && $v['client_id'] !== 0){
                        $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                        if($client_id > 0){
                           $tmp['client_id'] = $v['client_id'];
                        }
                     }

                     if($v['proxy_id'] && $v['proxy_id'] !== 0){
                        $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                        if($proxy_id > 0){
                           $tmp['proxy_id'] = $v['proxy_id'];
                        }
                     }

                     if($v['user_id'] && $v['user_id'] !== 0){
                        $user_id = $this->ci->db->where('id', $v['user_id'])->count_all_results('users');
                        if($user_id > 0){
                           $tmp['user_id'] = $v['user_id'];
                        }
                     }

                     if($this->ci->db->where('phone_number', $v['phone_number'])->get('facebook')->num_rows() > 0){
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');
                        $update = $this->ci->db->update('facebook', $tmp, array('phone_number' => $v['phone_number']));
                        if($update){
                           $this->ci->db->update('simcard', array('registered_facebook' => 1), array('phone_number' => $v['phone_number']));
                           $update ? $count_update++ : false;
                        }
                     }else{
                        $insert = $this->ci->db->insert('facebook', $tmp);
                        if($insert){
                           $this->ci->db->update('simcard', array('registered_twitter' => 1), array('phone_number' => $v['phone_number']));
                           $insert ? $count_insert++ : false;
                        }
                     }
                  }
               }
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }
         $result = array(
            'success' => TRUE,
            'msg' => $count_insert.' data is created and '.$count_update.' data are updated'
         );
      }else{
         $result = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $result;
   }

   public function migrationInstagram($filename, $params){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         $sheetcode = $objPHPExcel->getActiveSheet()->rangeToArray('ZZ3:ZZ3');
         $keycode = $sheetcode[0][0];
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $count = $this->ci->db->where('phone_number', $phone_number)->where('registered', 1)->get('simcard')->num_rows();
                  if($count > 0){
                     $data[$i]['phone_number'] = $phone_number;
                     $data[$i]['display_name'] = isset($value['B']) ? $value['B'] : NULL;
                     $data[$i]['username'] = isset($value['C']) ? $value['C'] : NULL;
                     $data[$i]['birth_date'] = isset($value['D']) ? date('Y-m-d', strtotime($value['D'])) : NULL;
                     $data[$i]['created_instagram'] = isset($value['E']) ? date('Y-m-d', strtotime($value['E'])) : NULL;
                     $data[$i]['password'] = isset($value['F']) ? $value['F'] : NULL;
                     $data[$i]['cookies'] = isset($value['G']) ? $value['G'] : NULL;
                     $data[$i]['followers'] =  isset($value['H']) && is_numeric($value['H']) ? $value['H'] : NULL;
                     $data[$i]['info'] = isset($value['I']) ? $value['I'] : NULL;
                     $data[$i]['proxy_id'] = isset($value['J']) && is_numeric($value['J']) ? $value['J'] : NULL;
                     $data[$i]['client_id'] = isset($value['K']) && is_numeric($value['K']) ? $value['K'] : NULL;
                     $data[$i]['status'] = isset($value['L']) ? $value['L'] : NULL;
                     $data[$i]['user_id'] = isset($value['M']) && is_numeric($value['M']) ? $value['M'] : NULL;
                  }
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            if($keycode == 1){
               foreach ($data as $v) {
                  if($v['phone_number']){
                     $email = $this->ci->db->select('birth_day')->where('phone_number', $v['phone_number'])->get('email')->row_array();
                     $tmp = array();
                     $tmp['phone_number'] = $v['phone_number'];
                     $tmp['birth_date'] = $email['birth_day'] ? date('Y-m-d', strtotime($email['birth_day'])) : NULL;
                     $tmp['display_name'] = $v['display_name'];
                     $tmp['username'] = strtolower(preg_replace('/[^a-zA-Z0-9\_]/', '', $v['username']));
                     $tmp['birth_date'] = $v['birth_date'];
                     $tmp['created_instagram'] = $v['created_instagram'];
                     $tmp['password'] = $v['password'];
                     $tmp['cookies'] = $v['cookies'];
                     $tmp['followers'] = $v['followers'];
                     $tmp['info'] = $v['info'];
                     $tmp['status'] = $v['status'];

                     if($v['client_id'] && $v['client_id'] !== 0){
                        $client_id = $this->ci->db->where('id', $v['client_id'])->count_all_results('client');
                        if($client_id > 0){
                           $tmp['client_id'] = $v['client_id'];
                        }
                     }

                     if($v['proxy_id'] && $v['proxy_id'] !== 0){
                        $proxy_id = $this->ci->db->where('id', $v['proxy_id'])->count_all_results('proxy');
                        if($proxy_id > 0){
                           $tmp['proxy_id'] = $v['proxy_id'];
                        }
                     }

                     if($v['user_id'] && $v['user_id'] !== 0){
                        $user_id = $this->ci->db->where('id', $v['user_id'])->count_all_results('users');
                        if($user_id > 0){
                           $tmp['user_id'] = $v['user_id'];
                        }
                     }

                     if($this->ci->db->where('phone_number', $v['phone_number'])->get('instagram')->num_rows() > 0){
                        $tmp['updated_user_id'] = $params['user_id'];
                        $tmp['updated_date'] = date('Y-m-d H:i:s');
                        $update = $this->ci->db->update('instagram', $tmp, array('phone_number' => $v['phone_number']));
                        if($update){
                           $this->ci->db->update('simcard', array('registered_instagram' => 1), array('phone_number' => $v['phone_number']));
                           $update ? $count_update++ : false;
                        }
                     }else{
                        $insert = $this->ci->db->insert('instagram', $tmp);
                        if($insert){
                           $this->ci->db->update('simcard', array('registered_instagram' => 1), array('phone_number' => $v['phone_number']));
                           $insert ? $count_insert++ : false;
                        }
                     }
                  }
               }
            }else{
               $response = array(
                  'success' => FALSE,
                  'msg' => 'File yang Anda unggah bukan file asli aplikasi, silakan unduh format excel yang telah disediakan lagi',
               );
            }
         }
         $result = array(
            'success' => TRUE,
            'msg' => $count_insert.' data dibuat dan '.$count_update.' data diperbaharui'
         );
      }else{
         $result = array(
            'success' => FALSE,
            'msg' => $excel_reader
         );
      }
      unlink('./upload/'.$filename.'');
      return $result;
   }

   public function rawData($filename){
      $excel_reader = $this->ci->excel_reader->read(NULL, './upload/', ''.$filename);
      if ($excel_reader['status']) {
         $objPHPExcel = $excel_reader['result'];
         $count_update = 0;
         $count_insert = 0;
         $i = 0;
         $row = 1;
         $data = array();
         $objPHPExcel->setActiveSheetIndex(0);   
         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
         foreach ($worksheet as $value) { 
            if ($row != 1) {
               $phone_number = isset($value['A']) ? $this->check_character($value['A']) : NULL;
               if($phone_number){
                  $data[] = $phone_number;
               }
            }
            $row++;
            $i++;
         }
         
         if($data){
            $result = array(
               'success' => TRUE,
               'data' => $data
            );
         }else{
            $result = array(
               'success' => TRUE,
               'data' => NULL
            );
         }
      }else{
         $result = array(
            'success' => FALSE,
            'data' => NULL
         );
      }
      unlink('./upload/'.$filename.'');
      return $result;
   }
   public function check_character($phone_number){
      $phone = substr($phone_number, 0, 1);
      if($phone == 0){
         return $phone_number;
      }else{
         return '0'.$phone_number;
      }
   }

   public function compare_left_days($sdate, $edate){
      $datetime1 = new DateTime($sdate);
      $datetime2 = new DateTime($edate);
      $interval = $datetime1->diff($datetime2);
      $data['opr'] = $interval->format('%R');
      $data['digit'] = $interval->format('%a');
      return $data;
   }

   public function check_migration_master($table, $field, $value){
      $this->ci->db->where($field, $value);
      $rs = $this->ci->db->count_all_results($table);
      return $rs > 0 ? $value : NULL;
   }

}