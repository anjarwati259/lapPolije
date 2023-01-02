<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analist extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('analis_model');
        $this->load->model('permohonan_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data = array('title' => 'Dashboard Analist',
                      'isi' => 'analist/dashboard');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function daftarAnalist(){
		$data = array('title' => 'Dashboard Analist',
                      'isi' => 'analist/daftar_analisis');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getDatapermohonan(){
		$fetch_data = $this->permohonan_model->getDatapermohonan();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
        	$kode_registrasi = base64_encode($row->kode_registrasi);
        	$urlKode = urlencode($kode_registrasi);
        	$disabled = ($row->status =='0') ? '' : 'disabled';
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('permohonan/detailPermohonan/').$urlKode.'">'.$row->kode_registrasi.'</a>';               
            $sub_array[] = $row->tgl_kirim;  
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = '<span class="badge '.$row->class_color.'target="_blank"">'.$row->keterangan.'</span>';
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" '.$disabled.' data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.$kode_registrasi.'\')">Kirim Sample</button>';
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

    public function daftarAnalisis(){
        $id_user = $this->session->userdata('id_user');
        $id_analist = $this->analis_model->getIdAnalist($id_user);
        $fetch_data = $this->analis_model->getDaftaranalisis($id_analist); 
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $kode_registrasi = base64_encode($row->kode_registrasi);
            $urlKode = urlencode($kode_registrasi);
            $class_color = ($row->status_analist == 0) ? ('bg-warning text-dark') : ('bg-success text-dark');
            $status_analist = ($row->status_analist == 0) ? ('Belum Selesai') : ('Selesai');
            // $disabled = ($row->status =='0') ? '' : 'disabled';
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('analist/detailPermohonan/').$urlKode.'/'.$row->id_jenis_analisa.'/'.$row->id_metode_analisa.'">'.$row->kode_registrasi.'</a>';               
            $sub_array[] = $row->kode_sample;  
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->jenis_analisa;
            $sub_array[] = $row->metode_analisa;
            // $sub_array[] = $row->status_analist;
            $sub_array[] = '<span class="badge '.$class_color.'target="_blank"">'.$status_analist.'</span>';
            // $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" '.$disabled.' data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.$kode_registrasi.'\')">Kirim Sample</button>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->datatables_model->get_all_data('tb_detail_permohonan'),  
            "recordsFiltered"   => count($data),
            "data"              => $data  
        );  
        echo json_encode($output);
    }

    public function detailPermohonan($kode_registrasi, $jenis_analisa, $metode_analisa){
        $kode_registrasi = base64_decode(urldecode($kode_registrasi));
        $dataPermohonan = $this->permohonan_model->permohonanByID($kode_registrasi);
        $detailPermohonan = $this->analis_model->detailPermohonan($kode_registrasi, $metode_analisa, $jenis_analisa);
        $data = array('title' => 'Detail Permohonan',
                      'dataPermohonan' => $dataPermohonan,
                      'detailPermohonan' => $detailPermohonan,
                      'dataAnalist'     =>array(),
                      'isi' => 'permohonan/detail_permohonan_analist');
        $this->load->view('layout/wrapper',$data, FALSE);
    }

    public function submitAnalisa(){
        $id = $this->input->post('id');
        $ulangan1 = $this->input->post('ulangan1');
        $ulangan2 = $this->input->post('ulangan2');
        $rata_rata = $this->input->post('rata_rata');
        $data = array('id' => $id,
                      'pengulangan_1' => (float)$ulangan1,
                      'pengulangan_2' => (float)$ulangan2,
                      'rata_rata' => (float)$rata_rata,
                      'status'  => '1'
                    );
        $result = $this->analis_model->saveHasilAnalisa($data);

        if($result['status'] == 'success'){
            
        }
        echo json_encode($result);
    }
}