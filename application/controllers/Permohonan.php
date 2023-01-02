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
		$this->load->model('datatables_model');
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
					  'dataAnalist' => array(),
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

	public function simpanPermohonan(){
		$action = $this->input->post('action');
		$status = ($action == 'submit') ? '0' : '5';
		$totalIndex = $this->input->post('0[totalIndex]');
		$kode_registrasi = $this->input->post('0[kode_registrasi]');
		$id_customer = $this->input->post('0[id_customer]');
		$tgl_kirim = $this->input->post('0[tgl_kirim]');
		$jenis_sample = $this->input->post('0[jenis_sample]');
		$jml_sample = $this->input->post('0[jml_sample]');
		$penyimpanan = $this->input->post('0[penyimpanan]');
		$keterangan_sample = $this->input->post('0[keterangan_sample]');

		$data = array('kode_registrasi' => $kode_registrasi,
					  'id_user'			=> $this->session->userdata('id_user'),
					  'id_customer'		=> $id_customer,
					  'tgl_kirim'		=> $tgl_kirim,
					  'jenis_sample'	=> $jenis_sample,
					  'jml_sample'		=> $jml_sample,
					  'penyimpanan'		=> $penyimpanan,
					  'keterangan_sample' => $keterangan_sample,
					  'status'			=> $status
					);
		$result = $this->permohonan_model->insertPermohonan($data);
		if(!empty($result)){
			$dataDetail =[];
			for ($index=1; $index <= $totalIndex; $index++) { 
				$jenis_analisa = $index.'[jenis_analisa]';
				$metode_analisa = $index.'[metode_analisa]';
				$dataDetail[] = array('kode_registrasi' 	=> $kode_registrasi,
									'id_user'			=> $this->session->userdata('id_user'),
									'id_jenis_analisa' 	=> $this->input->post($jenis_analisa),
									'id_metode_analisa'	=> $this->input->post($metode_analisa),
									'created_at' 		=> date('Y-m-d H:i:sa')
								);

			}
			$this->permohonan_model->insertDetailpermohonan($dataDetail);
			$return = array('status' => 'success',
							'message' => 'Data Permohoan Berhasil Disimpan');

		}else{
			$return = array('status' => 'error',
							'message' => 'Data Permohoan Tidak Berhasil Disimpan');
		}
		echo json_encode($return);
	}

	public function riwayatPermohonan(){
		$data = array('title' => 'Riwayat Permohonan',
						'dataAnalist' => array(),
                      'isi' => 'permohonan/riwayat_permohonan');
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

	public function kirimResi(){
		$kode_registrasi = $this->input->post('kode_registrasi');
		$tgl_kirim = $this->input->post('tgl_kirim');
		$no_resi = $this->input->post('no_resi');

		$data = array('kode_registrasi' => base64_decode($kode_registrasi),
					  'tgl_kirim' 		=> $tgl_kirim,
					  'no_resi'			=> $no_resi,
					  'status'			=> '1'
					);
		$result = $this->permohonan_model->editpermohonan($data);
		echo json_encode($result);
	}

	public function detailPermohonan($kode_registrasi){
		$kode_registrasi = base64_decode(urldecode($kode_registrasi));
		$dataPermohonan = $this->permohonan_model->permohonanByID($kode_registrasi);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($kode_registrasi);
		$data = array('title' => 'Detail Permohonan',
					  'dataPermohonan' => $dataPermohonan,
					  'detailPermohonan' => $detailPermohonan,
                      'isi' => 'permohonan/detail_permohonan');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function dataPermohonanAdmin(){
		$fetch_data = $this->permohonan_model->getDatapermohonan();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $no;                
            $sub_array[] = '<a href="'.base_url('admin/detailPermohonan/').generateUrl($row->kode_registrasi).'">'.$row->kode_registrasi.'</a>';
            $sub_array[] = '<a href="'.base_url('permohonan/cetakKode/').$row->kode_sample.'">'.$row->kode_sample.'</a>';; 
            $sub_array[] = dateDefault($row->tgl_kirim); 
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->nama_customer;
            $sub_array[] = '<span class="badge '.$row->class_color.'">'.$row->keterangan.'</span>';
            // $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.generateUrl($row->kode_registrasi).'\')">Terima Sample</button>';
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

	public function saveAnalist(){
		$kode_registrasi = $this->input->post('0[kode_registrasi]');
		$tgl_terima_sample = $this->input->post('0[tgl_terima_sample]');
		$tgl_perkiraan_selesai = $this->input->post('0[tgl_perkiraan_selesai]');
		$kode_sample = $this->input->post('0[kode_sample]');
		$kode_order = $this->input->post('0[kode_order]');

		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($kode_registrasi);

		$data = array('kode_registrasi' 	=> $kode_registrasi,
					  'tgl_terima_sample'	=> $tgl_terima_sample,
					  'tgl_perkiraan_selesai' => $tgl_perkiraan_selesai,
					  'kode_sample'			=> $kode_sample,
					  'kode_order'			=> $kode_order,
					  'status'				=> '2'
					);
		$result = $this->permohonan_model->editpermohonan($data);
		if($result['status'] == 'success'){
			foreach ($detailPermohonan as $key => $value) {
				$index = $key+1;
				$id_detail = $index.'[id]';
				$id_analist = $index.'[id_analist]';
				$surat_tugas = generateSuratTugas();
				$dataDetail = array('id' => $this->input->post($id_detail),
									'id_analist' => $this->input->post($id_analist),
									'no_surat'	=> $surat_tugas['no_surat'],
									'surat_tugas' => $surat_tugas['surat_tugas']
									);
				$this->permohonan_model->addJmlAnalist($this->input->post($id_analist));
				$this->permohonan_model->editDetailpermohonan($dataDetail);
			}
			$return = array('status' => 'success',
							'message' => 'Data Permohoan Berhasil Disimpan');

		}else{
			$return = array('status' => 'error',
							'message' => 'Data Permohoan Tidak Berhasil Disimpan');
		}
		echo json_encode($return);
	}
}