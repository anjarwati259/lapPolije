<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('unit_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array('title' => 'Data Unit',
                      'isi' => 'unit/data_unit' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addUnit(){
		$nama_unit = $this->input->post('nama_unit');
		$id = $this->input->post('id');

		// validation form
		$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'nama_unit' => $nama_unit,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->unit_model->insertunit($data);
			}else{
				$data = array(	'nama_unit' => $nama_unit,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->unit_model->editunit($data);
			}
		}else{
			$atribute = array(
			    'nama_unit' => form_error('nama_unit'),
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataUnit(){
		$fetch_data = $this->unit_model->getDataunit();  
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;             
            $sub_array[] = $row->nama_unit; 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editunit('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusunit('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_unit'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getUnit(){
		$id 	= $this->input->post('id');
		$unit = $this->unit_model->getUnit($id);

		echo json_encode($unit);
	}

	public function delUnit(){
		$id 	= $this->input->post('id');
		$this->unit_model->delUnit($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}