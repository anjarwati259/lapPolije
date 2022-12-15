<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('customer_model');
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
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();                  
            $sub_array[] = $row->nama_customer;  
            $sub_array[] = $row->alamat;
            $sub_array[] = $row->no_telp;
            $sub_array[] = $row->email;  
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editcustomer('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapuscustomer('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
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
		// $customer = $this->customer_model->listCustomer();
		$data = array('title' => 'Data Customer',
					  // 'customer' => $customer,
                      'isi' => 'admin/data_customer' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}