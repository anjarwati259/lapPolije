<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('permohonan_model');
		$this->load->model('customer_model');
		$this->load->model('jenis_analisa_model');
		$this->load->model('metode_analisa_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$id_user = $this->session->userdata('id_user');
		$ket_sample = $this->permohonan_model->keterangan_sample();
		$penyimpanan_sample = $this->permohonan_model->penyimpanan_sample();
		$customer = $this->customer_model->getCustomerByUser($id_user);
		$kode_registrasi = getKodeRegistrasi();
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();

		$data = array('title' => 'Form Permohonan',
					  'ket_sample' => $ket_sample,
					  'penyimpanan_sample' =>$penyimpanan_sample,
					  'customer' => $customer,
					  'kode_registrasi' => $kode_registrasi,
					  'jenis_analisa' => $jenis_analisa,
                      'isi' => 'permohonan/form_permohonan');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getMetodeanalisa(){
		$id 	= $this->input->post('id');
		$type	= $this->input->post('type');
		$metode_analisa = $this->metode_analisa_model->getMetodeByid($id);
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();

		if($type == 'analisa'){
			foreach ($metode_analisa as $key => $value) {
				$dataMetode = "<option value='$value->id'>$value->metode_analisa</option>";
				echo $dataMetode;
			}
		}else if($type == 'add'){
			$index	= $this->input->post('index');
			$dataHtml = '<select name="jenis_analisa'.$index.'" id="jenis_analisa'.$index.'" class="form-select" onchange="setMetode('.$index.')">';
			foreach ($jenis_analisa as $key => $value) {
				$dataHtml .= "<option value='$value->id'>$value->jenis_analisa</option>";
			}
			$dataHtml .="</select>";
			echo $dataHtml;
		}
	}
}