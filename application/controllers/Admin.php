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

	// ================================ area master data =========================
	public function customer(){
		$customer = $this->customer_model->listCustomer();
		$data = array('title' => 'Data Customer',
					  'customer' => $customer,
                      'isi' => 'admin/data_customer' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	// ambil data customer untuk datatable
	public function getDataCustomer(){
		$fetch_data = $this->customer_model->getDatacustomer();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = $row->nama_customer;  
            $sub_array[] = $row->alamat;
            $sub_array[] = $row->no_telp;
            $sub_array[] = $row->email;  
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editcustomer('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapuscustomer('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_customer'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function addCustomer(){
		$nama_customer = $this->input->post('nama_customer');
		$alamat = $this->input->post('alamat');
		$no_telp = $this->input->post('no_telp');
		$id = $this->input->post('id');
		$email = $this->input->post('email');

		// validation form
		$this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');

		if($this->form_validation->run()){
			if(empty($id)){
				$data = array(	'nama_customer' => $nama_customer,
								'alamat'		=> $alamat,
								'no_telp'		=> $no_telp,
								'email'			=> $email,
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->customer_model->insertcustomer($data);
			}else{
				$data = array(	'nama_customer' => $nama_customer,
								'alamat'		=> $alamat,
								'no_telp'		=> $no_telp,
								'email'			=> $email,
								'id'			=> $id
						);
				$result = $this->customer_model->editcustomer($data);
			}
		}else{
			$atribute = array(
			    'nama_customer' => form_error('nama_customer'),
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

	public function getCustomer(){
		$id 	= $this->input->post('id');
		$customer = $this->customer_model->getCustomer($id);

		echo json_encode($customer);
	}

	public function delCustomer(){
		$id 	= $this->input->post('id');
		$this->customer_model->delCustomer($id);
		$result = array('status' => 'success',
    					'message' => 'Data Berhasil Dihapus',
    					'atribute' => '');
		echo json_encode($result);
	}

	public function pegawai(){
		$jabatan = $this->jabatan_model->listJabatan();
		$unit = $this->unit_model->listUnit();
		$data = array('title' => 'Data Pegawai',
                      'isi' => 'admin/data_pegawai',
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

	public function jabatan(){
		$data = array('title' => 'Data Jabatan',
                      'isi' => 'admin/data_jabatan' );
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
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->jabatan_model->insertjabatan($data);
			}else{
				$data = array(	'nama_jabatan' => $nama_jabatan,
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

	public function unit(){
		$data = array('title' => 'Data Unit',
                      'isi' => 'admin/data_unit' );
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
								'created_at'	=> date('Y-m-d H:i:sa')
						);
				$result = $this->unit_model->insertunit($data);
			}else{
				$data = array(	'nama_unit' => $nama_unit,
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