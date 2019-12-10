<?php
error_reporting(E_ALL);
ini_set('memory_limit', '1G');
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
$this->load->library('PHPExcel');
$phpexcel = new PHPExcel();

$phpexcel->setActiveSheetIndex(0);
$cell = $phpexcel->getActiveSheet();

foreach ($this->mapping_report->excelColumnRange('A', 'D') as $column) {
	$cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:D1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:D1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
    	)
	)
);


$cell->setCellValue('A1', 'No');
$cell->setCellValue('B1', 'Alias');
$cell->setCellValue('C1', 'Master');
$cell->setCellValue('D1', 'PIC');

$i = 2;
$no = 1;
if($alias){
   foreach ($alias as $vv) {
   	$cell->setCellValue('A'.$i, $no);
   	$cell->setCellValue('B'.$i, str_replace('+', ' ', $vv['alias']));
   	$cell->setCellValue('C'.$i, $vv['master'] ? str_replace('+', ' ', $vv['master']) : '');
    $cell->setCellValue('D'.$i, $vv['username'] ? $vv['username'] : '');
   	$no++;
   	$i++;
   }
}

$cell->setTitle('Alias');

/////////////////////////////////////////////////////////
$phpexcel->createSheet();
$phpexcel->setActiveSheetIndex(1);
$cell = $phpexcel->getActiveSheet();

foreach ($this->mapping_report->excelColumnRange('A', 'B') as $column) {
    $cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:B1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:B1')->applyFromArray(
    array(
        'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
        )
    )
);


$cell->setCellValue('A1', 'No');
$cell->setCellValue('B1', 'Alias');

$i = 2;
$no = 1;
if($no_alias){
   foreach ($no_alias as $vv) {
      $cell->setCellValue('A'.$i, $no);
      $cell->setCellValue('B'.$i, str_replace('+', ' ', $vv['alias']));
      $no++;
      $i++;
   }
}

$cell->setTitle('Un-done');

/////////////////////////////////////////////////////////
$phpexcel->createSheet();
$phpexcel->setActiveSheetIndex(2);
$cell = $phpexcel->getActiveSheet();

foreach ($this->mapping_report->excelColumnRange('A', 'C') as $column) {
	$cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:C1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:C1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
    	)
	)
);


$cell->setCellValue('A1', 'No');
$cell->setCellValue('B1', 'Alias');
$cell->setCellValue('C1', 'PIC');

$i = 2;
$no = 1;
if($master_alias){
   foreach ($master_alias as $vv) {
   	$cell->setCellValue('A'.$i, $no);
   	$cell->setCellValue('B'.$i, str_replace('+', ' ', $vv['alias']));
    $cell->setCellValue('C'.$i, $vv['username'] ? $vv['username'] : '');
   	$no++;
   	$i++;
   }
}

$cell->setTitle('Master');

/////////////////////////////////////////////////////////
$phpexcel->createSheet();
$phpexcel->setActiveSheetIndex(3);
$cell = $phpexcel->getActiveSheet();

foreach ($this->mapping_report->excelColumnRange('A', 'B') as $column) {
    $cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:B1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:B1')->applyFromArray(
    array(
        'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
        )
    )
);


$cell->setCellValue('A1', 'No');
$cell->setCellValue('B1', 'Name');

$i = 2;
$no = 1;
if($common_name){
   foreach ($common_name as $vv) {
      $cell->setCellValue('A'.$i, $no);
      $cell->setCellValue('B'.$i, str_replace('+', ' ', $vv['alias']));
      $no++;
      $i++;
   }
}

$cell->setTitle('Common');

/////////////////////////////////////////////////////////
$phpexcel->createSheet();
$phpexcel->setActiveSheetIndex(4);
$cell = $phpexcel->getActiveSheet();

foreach ($this->mapping_report->excelColumnRange('A', 'B') as $column) {
    $cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:B1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:B1')->applyFromArray(
    array(
        'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
        )
    )
);


$cell->setCellValue('A1', 'No');
$cell->setCellValue('B1', 'Name');

$i = 2;
$no = 1;
if($blacklist_name){
   foreach ($blacklist_name as $vv) {
      $cell->setCellValue('A'.$i, $no);
      $cell->setCellValue('B'.$i, str_replace('+', ' ', $vv['alias']));
      $no++;
      $i++;
   }
}


$cell->setTitle('Blacklist');

$fname = $filename.'.xlsx';
$filepath = './download/'.$fname;
$writer = PHPExcel_IOFactory::createWriter($phpexcel,'Excel2007');
$mode = isset($mode) ? $mode : 'download';

switch ($mode) {
 	case 'download':
     	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     	header('Content-Disposition: attachment;filename="'.$fname.'"');
     	header('Cache-Control: max-age=0');
     	header('Cache-Control: max-age=1');
     	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
     	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
     	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
     	header('Pragma: public'); // HTTP/1.0
     	$writer->save('php://output');
     	exit;
     	break;
 	case 'save':
     	$writer->save($filepath);
     	echo $filepath;
     	break;
}