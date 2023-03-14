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
		$this->load->model('user_model');
		$this->load->model('pegawai_model');
		$this->load->model('permohonan_model');
		$this->load->model('analis_model');
		$this->load->model('datatables_model');
		$this->load->model('Variabel_content_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$dashboard = $this->Variabel_content_model->getContent('dashboard_admin');
		$data = array('title' => 'Dashboard Admin',
						'dashboard' => $dashboard,
                      'isi' => 'admin/dashboard' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
	public function permohonan()
	{
		$data = array('title' => 'Data Permohonan',
						'dataAnalist' => array(),
                      'isi' => 'permohonan/data_permohonan' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
	public function penawaran($id)
	{
		$id = base64_decode(urldecode($id));
		$dataPermohonan = $this->permohonan_model->permohonanByID($id);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($id);
		$totalHarga = $this->permohonan_model->getTotal($id);
		$noPenawaran = generateKode('penawaran', $id);
		$data = array('title' => 'Form Penawaran',
					  'dataPermohonan' => $dataPermohonan,
					  'detailPermohonan' => $detailPermohonan,
					  'totalHarga' => $totalHarga->total,
					  'noPenawaran' => $noPenawaran,
                      'isi' => 'penawaran/form_penawaran' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function loaddatapmn(){
		$data = array('title' => 'Data Permohonan',
						'dataAnalist' => array());
        $this->load->view('permohonan/permintaan_permohonan',$data, FALSE);
	}

	public function loaddatapwn(){
		$data = array('title' => 'Data Permohonan',
						'dataAnalist' => array());
        $this->load->view('penawaran/data_penawaran',$data, FALSE);
	}
	public function loaddatapsn(){
		$data = array('title' => 'Data Permohonan',
						'dataAnalist' => array());
        $this->load->view('permohonan/data_pesanan',$data, FALSE);
	}
	public function detailPermohonan($no_permohonan)
	{
		$no_permohonan = base64_decode(urldecode($no_permohonan));
		$dataPermohonan = $this->permohonan_model->permohonanByID($no_permohonan);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($no_permohonan);
		$dataAnalist = $this->analis_model->listAnalist();
		$batasAnalist = $this->analis_model->getBatasAnalist();
		$daftarDocument = $this->permohonan_model->getDaftarDocument($no_permohonan);
		$status = (int) $dataPermohonan->status;

		if($status == 4){
			$isi = 'permohonan/viewAction/detail_terima_sample';
		}else if($status == 7){
			$isi = 'permohonan/viewAction/detail_selesai_analisa';
		}else if($dataPermohonan->status <= 4){
			$isi = 'permohonan/detail_permohonan';
		}else{
			$isi = 'permohonan/detail_permohonan_admin';
		}
		// var_dump($isi);exit;
		// $batas_analist = $batasAnalist->batas_analist; 
		// $lastKode = $this->permohonan_model->getLastId();

		// if(!empty($lastKode->kode_sample)){
		// 	$kode_sample = (int) $lastKode->kode_sample + 1;
		// 	$kode_order = generateKode('nomor_permohonan', $kode_sample);
		// }else{
		// 	$kode_sample = 1;
		// 	$kode_order = generateKode('nomor_permohonan', $kode_sample);
		// }

		$data = array('title' => 'Data Permohonan',
					  'dataPermohonan' => $dataPermohonan,
					  'detailPermohonan' => $detailPermohonan,
					  'daftarDocument'	=> $daftarDocument,
					  // 'kode_sample'		=> $kode_sample,
					  // 'kode_order'		=> $kode_order,
					  'dataAnalist'		=> $dataAnalist,
					  'batas_analist'	=> $batasAnalist->batas_analist,
                      'isi' => $isi );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function konfirmBayar($id){
		$id = base64_decode(urldecode($id));
		$dataPermohonan = $this->permohonan_model->permohonanByID($id);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($id);
		$dataBayar = $this->permohonan_model->dataBayar($id);
		$dokument = $this->permohonan_model->dataBayar($id);
		$data = array('title' => 'Detail Pembayaran',
					  'dataPermohonan' => $dataPermohonan,
					  'detailPermohonan' => $detailPermohonan,
					  'dataBayar'		=> $dataBayar,
                      'isi' => 'permohonan/detail_pembayaran');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function managementUser(){
		$role = $this->user_model->getRole();
		$data = array('title' => 'Management User',
						'role' => $role,
                      'isi' => 'admin/management_user');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getManagementUser(){
		$fetch_data = $this->user_model->getManagementUser();
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = $row->nip;               
            $sub_array[] = $row->nama_pegawai;  
            $sub_array[] = $row->username;
            $sub_array[] = ($row->hak_akses) ? ($row->role_name) : ('-');
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="edituser('.$row->id.')">Edit</button>';
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

	public function getUserById(){
		$id = $this->input->post('id');
		$dataUser = $this->user_model->getUserById($id);
		echo json_encode($dataUser);
	}

	public function submitManagementUser(){
		$id = $this->input->post('id');
		$dataUser = $this->user_model->getUserById($id);
		$hak_akses = $this->input->post('hak_akses');
		if($hak_akses == '2'){
			$cekAnalist = $this->analis_model->cekAnalist2($dataUser->pegawai_id);
			
			if(empty($cekAnalist)){
				$dataAnalist = array('id_pegawai' => $dataUser->pegawai_id, 'jml_analist' => '0', 'status' => '1', 'created_at' => date('Y-m-d H:i:sa'));
				$result = $this->analis_model->insertAnalist($dataAnalist);
			}
		}else{
			$cekAnalist = $this->analis_model->cekAnalist2($dataUser->pegawai_id);

			if(!empty($cekAnalist)){
				$result = $this->analis_model->delete($cekAnalist->id);
			}
		}
		$data = array('id' => $id, 'hak_akses' => $hak_akses);
		$result = $this->user_model->editUser($data);

		echo json_encode($result);
	}
}