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