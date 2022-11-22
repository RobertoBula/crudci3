<?php 
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends CI_Controller{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('excel_model');   
    }
    
    public function index()
    {
        $this->load->view('spreadsheet');
    }

    public function spreadsheet_format_download()
	{	
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="hello_world.xlsx"');
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'id_persona');
		$sheet->setCellValue('B1', 'nombre_persona');
		$sheet->setCellValue('C1', 'apellidos_persona');
		$sheet->setCellValue('D1', 'fecha_persona');
		$sheet->setCellValue('E1', 'genero_persona');

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
	}

	public function spreadsheet_import()
	{
		$upload_file=$_FILES['upload_file']['name'];
		$extension=pathinfo($upload_file,PATHINFO_EXTENSION);
		if ($extension== 'csv')
		{
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		}elseif ($extension== 'xls') 
		{
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xls();

		}else {
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		}
		$spreadsheet=$reader->load($_FILES['upload_file']['tmp_name']); 
		$sheetdata=$spreadsheet->getActiveSheet()->toArray();
		$sheetcount=count($sheetdata);
		if ($sheetcount>1)
		{
			$data= array(); 
			for ($i=1; $i < $sheetcount ; $i++) { 
 				
			
				$nombre=$sheetdata[$i][1];
 				$apellidos=$sheetdata[$i][2];
 				$fecha_nac=$sheetdata[$i][3];
 				$genero=$sheetdata[$i][4];
				$data[]=array(
					'nombre' => $nombre, 
					'apellidos' => $apellidos, 
					'fecha_nac' => $fecha_nac, 
					'genero' => $genero
				);
			}
			$insertdata=$this->excel_model->insert_batch($data);
			if($insertdata)
			{
				$this->session->set_flashdata('message','<div class="alert alert-success">Successfully Added.</div>');
				redirect('welcome');
			}else
			{
				$this->session->set_flashdata('message','<div class="alert alert-danger">Data Nor Uploaded. Please Try Again.</div>');
				redirect('welcome');
			}
		}
	}

	public function spreadsheet_export()
	{
		//fetch my data
		$listpersons=$this->excel_model->list_persons();

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="personas.xlsx"');
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'id_persona');
		$sheet->setCellValue('B1', 'nombre_persona');
		$sheet->setCellValue('C1', 'apellidos_persona');
		$sheet->setCellValue('D1', 'fecha_persona');
		$sheet->setCellValue('E1', 'genero_persona');

		$sn=2;
		foreach ($listpersons as $list) {
			// echo $list->nombre;
			$sheet->setCellValue('A'.$sn, $list->id);
			$sheet->setCellValue('B'.$sn, $list->nombre);
			$sheet->setCellValue('C'.$sn, $list->apellidos);
			$sheet->setCellValue('D'.$sn, $list->fecha_nac);
			$sheet->setCellValue('E'.$sn, $list->genero);
			$sn++;
		}	

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
	}

}

?>