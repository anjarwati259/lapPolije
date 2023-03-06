<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
  	{
	    parent::__construct();
	    $this->load->model('user_model');
	    $this->load->model('customer_model');
	    $this->load->model('pegawai_model');
	    $this->load->library('Ciqrcode');
  	}

	public function index()
	{
		//validasi
	    $this->form_validation->set_rules('username','Username','required',
	        array(  'required'  => '%s harus diisi'));
	    $this->form_validation->set_rules('password','Password','required',
	        array(  'required'  => '%s harus diisi'));

	    if($this->form_validation->run())
	    {
	      $username   = $this->input->post('username');
	      $password   = $this->input->post('password');
	      //proses ke simple login
	      $this->simple_login->login($username,$password);
	    }
	    //end validasi
	    $this->load->view('login/formLogin');
	}

	public function register(){
		$this->load->view('login/formRegister');
	}

	public function Addregister(){
		$nama_customer = $this->input->post('nama_customer');
		$alamat = $this->input->post('alamat');
		$no_telp = $this->input->post('no_telp');
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$instansi = $this->input->post('instansi');

		$dataUser = array('username' => $username,
						  'password' => sha1($password),
						  'hak_akses' => '3',
						  'created_at' => date('Y-m-d H:i:sa')
						);
		$userId = $this->user_model->register($dataUser);
		if($userId){
			$dataCus = array(	'nama_customer' => $nama_customer,
								'id_user'		=> $userId,
								'alamat'		=> $alamat,
								'no_telp'		=> $no_telp,
								'email'			=> $email,
								'instansi'		=> $instansi,
								'status'		=> '1',
								'created_at'	=> date('Y-m-d H:i:sa')
							);
			$result = $this->customer_model->insertcustomer($dataCus);
			$user = $this->user_model->getUser($userId);
			if($result['status'] == 'success' && $user['status'] == 'success'){
				$this->session->set_userdata('id_user',$user['id_user']);
				$this->session->set_userdata('nama_user',$user['nama']);
				$this->session->set_userdata('username',$user['username']);
      			$this->session->set_userdata('hak_akses',$user['hak_akses']);
      			redirect(base_url('customer'),'refresh');
			}else{
				$this->session->set_flashdata('error','Registrasi Tidak Berhasil Silahkan Hubungi Layanan Administrator');
      			redirect(base_url('register'),'refresh');
			}
		}
	}

	//fungsi logout
	public function logout()
	{
		//ambil fungsi logout dari simple_login
	    $this->simple_login->logout();
	}

	public function profile(){
		$id = $this->session->userdata('id');
		$dataProfile = $this->user_model->getProfileAdmin($id);

		if(empty($dataProfile->qrcode)){
			
			$filename = 'qr_'.$id.'.png';
			$params['data'] = $dataProfile->nama_pegawai;
			$params['level'] = 'H';
			$params['size'] = 2;
			$params['savename'] = FCPATH.'qrcode/qr_'.$id.'.png';
			$this->ciqrcode->generate($params);

			$data = array('id' => $id,
							'qrcode' => $filename);

			$result = $this->pegawai_model->editpegawai($data);
			$dataProfile = $this->user_model->getProfileAdmin($id);
		}

		$data = array('title' => 'Profile',
					  'dataProfile' => $dataProfile,
                      'isi' => 'login/profile' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}