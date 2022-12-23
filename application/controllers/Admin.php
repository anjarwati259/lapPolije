<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('customer_model');
		$this->load->model('jabatan_model');
		$this->load->model('unit_model');
		$this->load->model('pegawai_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array('title' => 'Dashboard Admin',
                      'isi' => 'admin/dashboard' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function jenis_analis(){
		$data = array('title' => 'Data Unit',
                      'isi' => 'admin/data_analis' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addAnalis(){
		$nama_analis = $this->input->post('nama_analis');
		$id = $this->input->post('id');

		// validation form
		$this->form_validation->set_rules('nama_analis', 'Nama Analis', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'nama_analis' => $nama_analis,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->unit_model->insertanalis($data);
			}else{
				$data = array(	'nama_analis' => $nama_analis,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->unit_model->editanalis($data);
			}
		}else{
			$atribute = array(
			    'nama_analis' => form_error('nama_analis'),
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataAnalis(){
		$fetch_data = $this->analis_model->getDataanalis();  
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;             
            $sub_array[] = $row->nama_analis; 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editunit('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusunit('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_analis'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getAnalis(){
		$id 	= $this->input->post('id');
		$analis = $this->analis_model->getAnalis($id);

		echo json_encode($analis);
	}

	public function delAnalis(){
		$id 	= $this->input->post('id');
		$this->analis_model->delAnalis($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}