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
		$this->load->model('permohonan_model');
		$this->load->model('analis_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array('title' => 'Dashboard Admin',
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

		if($dataPermohonan->status == '5'){
			$isi = 'permohonan/viewAction/detail_terima_sample';
		}else{
			$isi = 'permohonan/detail_permohonan_admin';
		}
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
}