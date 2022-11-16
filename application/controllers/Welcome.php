<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\ElseIf_;

class Welcome extends CI_Controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('form');
		$this->load->model('Persona');
		
	}

	public function index(){
		$data['personas'] = $this->Persona->select_all();
 		$this->load->view('welcome_message', $data);
	
	}
	
	public function agregar(){
		$persona['nombre'] = $this->input->post('nombre');
		$persona['apellidos'] = $this->input->post('apellidos');
		$persona['fecha_nac'] = $this->input->post('fecha_nac');
		$persona['genero'] = $this->input->post('genero');
		$this->Persona->agregar($persona);
		redirect('welcome');
	}

	public function eliminar($id_persona){
		$this->Persona->eliminar($id_persona);
		redirect('welcome');	
	}

	public function editar($id_persona){
		$persona['nombre'] = $this->input->post('nombre');
		$persona['apellidos'] = $this->input->post('apellidos');
		$persona['fecha_nac'] = $this->input->post('fecha_nac');
		$persona['genero'] = $this->input->post('genero');
		$this->Persona->actualizar($persona, $id_persona);
		redirect('welcome');
	}

		
	public function spreadsheet_download_format(){
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="hello_world.xlsx"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Nombre');
		$sheet->setCellValue('B1', 'Apellidos');
		$sheet->setCellValue('C1', 'Fecha de nacimiento');
		$sheet->setCellValue('D1', 'Genero');
		
		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
	}

	public function spreadsheet_import(){
		$upload_file=$_FILES['upload_file']['name'];
		$extension=pathinfo($upload_file,PATHINFO_EXTENSION);
		if($extension=='csv'){
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		}elseif ($extension=='xls') {
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		}else{
			$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet=$reader->load($_FILES['upload_file']['tmp_name']);
		$sheetdata=$spreadsheet->getActiveSheet()->toArray();
		$sheetcount=count($sheetdata);
		if($sheetcount>1){
			$data=array();
			for ($i=1; $i < $sheetcount; $i++) { 
				$persona['nombre'] = $sheetdata[$i][1];	
				$persona['apellidos'] = $sheetdata[$i][2];	
				$persona['fecha_nac'] = $sheetdata[$i][3];	
				$persona['genero'] = $sheetdata[$i][4];
				$data[]=array(
					'nombre' => $persona['nombre'],
					'apellidos' => $persona['apellidos'],
					'fecha_nac' => $persona['fecha_nac'],
					'genero' => $persona['genero'],
				);	
					
			} 
			$insertdata=$this->Persona->insert_batch($data);
			if ($insertdata) {
				$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully Added.</div>');
			
			}else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Data not uploaded. Please try again.</div>');
			}
		}
	}
}
