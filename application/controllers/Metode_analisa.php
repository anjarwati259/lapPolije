<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metode_analisa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('metode_analisa_model');
		$this->load->model('jenis_analisa_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();
		$data = array('title' => 'Data Metode Analisa',
					  'jenis_analisa' => $jenis_analisa,
                      'isi' => 'metode_analisa/data_metode_analisa' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addMetodeanalisa(){
		$id_jenis_analisa = $this->input->post('id_jenis_analisa');
		$metode_analisa = $this->input->post('metode_analisa');
		$harga = $this->input->post('harga');
		$id = $this->input->post('id');

		// validation form
		$this->form_validation->set_rules('metode_analisa', 'Harga Analisa', 'required');
		$this->form_validation->set_rules('harga', 'Harga Analisa', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'metode_analisa' => $metode_analisa,
								'id_jenis_analisa' => $id_jenis_analisa,
								'harga'			=> $harga,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->metode_analisa_model->insertmetode_analisa($data);
			}else{
				$data = array(	'metode_analisa' => $metode_analisa,
								'id_jenis_analisa' => $id_jenis_analisa,
								'harga'			=> $harga,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->metode_analisa_model->editmetode_analisa($data);
			}
		}else{
			$atribute = array(
			    'metode_analisa' => form_error('metode_analisa'),
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataMetodeanalisa(){
		$fetch_data = $this->metode_analisa_model->getDatametode_analisa();  
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;  
            $sub_array[] = $row->jenis_analisa;            
            $sub_array[] = $row->metode_analisa; 
            $sub_array[] = "Rp " . number_format($row->harga,2,',','.'); 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editmetode_analisa('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusmetode_analisa('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_metode_analisa'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getMetodeanalisa(){
		$id 	= $this->input->post('id');
		$metode_analisa = $this->metode_analisa_model->getMetodeanalisa($id);

		echo json_encode($metode_analisa);
	}

	public function delMetodeanalisa(){
		$id 	= $this->input->post('id');
		$this->metode_analisa_model->delMetodeanalisa($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}