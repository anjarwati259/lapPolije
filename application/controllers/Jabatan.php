<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('jabatan_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array('title' => 'Data Jabatan',
                      'isi' => 'jabatan/data_jabatan' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addJabatan(){
		$nama_jabatan = $this->input->post('nama_jabatan');
		$id = $this->input->post('id');

		// validation form
		$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'nama_jabatan' => $nama_jabatan,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->jabatan_model->insertjabatan($data);
			}else{
				$data = array(	'nama_jabatan' => $nama_jabatan,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->jabatan_model->editjabatan($data);
			}
		}else{
			$atribute = array(
			    'nama_jabatan' => form_error('nama_jabatan'),
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataJabatan(){
		$fetch_data = $this->jabatan_model->getDatajabatan();  
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;             
            $sub_array[] = $row->nama_jabatan; 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editjabatan('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusjabatan('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_jabatan'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getJabatan(){
		$id 	= $this->input->post('id');
		$jabatan = $this->jabatan_model->getJabatan($id);

		echo json_encode($jabatan);
	}

	public function delJabatan(){
		$id 	= $this->input->post('id');
		$this->jabatan_model->delJabatan($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}