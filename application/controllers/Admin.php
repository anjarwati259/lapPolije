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
	public function detailPermohonan($kode_registrasi)
	{
		$kode_registrasi = base64_decode(urldecode($kode_registrasi));
		$dataPermohonan = $this->permohonan_model->permohonanByID($kode_registrasi);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($kode_registrasi);
		$dataAnalist = $this->analis_model->listAnalist();
		$batasAnalist = $this->analis_model->getBatasAnalist();
		// $batas_analist = $batasAnalist->batas_analist; 
		$lastKode = $this->permohonan_model->getLastId();

		if(!empty($lastKode->kode_sample)){
			$kode_sample = (int) $lastKode->kode_sample + 1;
			$kode_order = generateKode('nomor_permohonan', $kode_sample);
		}else{
			$kode_sample = 1;
			$kode_order = generateKode('nomor_permohonan', $kode_sample);
		}

		$data = array('title' => 'Data Permohonan',
					  'dataPermohonan' => $dataPermohonan,
					  'detailPermohonan' => $detailPermohonan,
					  'kode_sample'		=> $kode_sample,
					  'kode_order'		=> $kode_order,
					  'dataAnalist'		=> $dataAnalist,
					  'batas_analist'	=> $batasAnalist->batas_analist,
                      'isi' => 'permohonan/detail_permohonan_admin' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}