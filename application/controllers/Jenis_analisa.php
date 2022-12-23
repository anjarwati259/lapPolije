<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_analisa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('jenis_analisa_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array('title' => 'Data Jenis Analisa',
                      'isi' => 'jenis_analisa/data_jenis_analisa' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addJenisanalisa(){
		$jenis_analisa = $this->input->post('jenis_analisa');
		$id = $this->input->post('id');

		// validation form
		$this->form_validation->set_rules('jenis_analisa', 'Nama Jenisanalisa', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'jenis_analisa' => $jenis_analisa,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->jenis_analisa_model->insertjenis_analisa($data);
			}else{
				$data = array(	'jenis_analisa' => $jenis_analisa,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->jenis_analisa_model->editjenis_analisa($data);
			}
		}else{
			$atribute = array(
			    'jenis_analisa' => form_error('jenis_analisa'),
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataJenisanalisa(){
		$fetch_data = $this->jenis_analisa_model->getDatajenis_analisa();  
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;             
            $sub_array[] = $row->jenis_analisa; 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editjenis_analisa('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusjenis_analisa('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_jenis_analisa'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getJenisanalisa(){
		$id 	= $this->input->post('id');
		$jenis_analisa = $this->jenis_analisa_model->getJenisanalisa($id);

		echo json_encode($jenis_analisa);
	}

	public function delJenisanalisa(){
		$id 	= $this->input->post('id');
		$this->jenis_analisa_model->delJenisanalisa($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}