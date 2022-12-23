<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('jabatan_model');
		$this->load->model('unit_model');
		$this->load->model('pegawai_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$jabatan = $this->jabatan_model->listJabatan();
		$unit = $this->unit_model->listUnit();
		$data = array('title' => 'Data Pegawai',
                      'isi' => 'pegawai/data_pegawai',
                      'jabatan' => $jabatan,
                      'unit' => $unit );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addPegawai(){
		$nama_pegawai = $this->input->post('nama_pegawai');
		$alamat = $this->input->post('alamat');
		$id_jabatan = $this->input->post('id_jabatan');
		$id_unit = $this->input->post('id_unit');
		$no_telp = $this->input->post('no_telp');
		$id = $this->input->post('id');
		$nip = $this->input->post('nip');
		$email = $this->input->post('email');

		// validation form
		$this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
		$this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required');
		$this->form_validation->set_rules('nip', 'NIP', 'required');
		$this->form_validation->set_rules('id_unit', 'Unit', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'nama_pegawai' => $nama_pegawai,
								'id_jabatan'	=> $id_jabatan,
								'nip'	=> $nip,
								'id_unit'		=> $id_unit,
								'alamat'		=> $alamat,
								'no_telp'		=> $no_telp,
								'email'			=> $email,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->pegawai_model->insertpegawai($data);
			}else{
				$data = array(	'nama_pegawai' => $nama_pegawai,
								'alamat'		=> $alamat,
								'id_jabatan'	=> $id_jabatan,
								'id_unit'		=> $id_unit,
								'no_telp'		=> $no_telp,
								'email'			=> $email,
								'status'		=> '1',
								'id'			=> $id
						);
				$result = $this->pegawai_model->editpegawai($data);
			}
		}else{
			$atribute = array(
			    'nama_pegawai' => form_error('nama_pegawai'),
			    'email' => form_error('email'),
			    'no_telp' => form_error('no_telp'),
			    'alamat' => form_error('alamat')
			);

			$result = array('status' => 'error',
							'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
							'atribute' => $atribute
			);
		}
		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataPegawai(){
		$fetch_data = $this->pegawai_model->getDatapegawai();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = $row->nip;               
            $sub_array[] = $row->nama_pegawai;  
            $sub_array[] = $row->nama_jabatan;
            $sub_array[] = $row->nama_unit;  
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editpegawai('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapuspegawai('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_pegawai'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getPegawai(){
		$id 	= $this->input->post('id');
		$pegawai = $this->pegawai_model->getPegawai($id);

		echo json_encode($pegawai);
	}

	public function delPegawai(){
		$id 	= $this->input->post('id');
		$this->pegawai_model->delPegawai($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}
}