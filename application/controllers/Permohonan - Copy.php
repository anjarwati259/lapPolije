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
		$this->load->model('analis_model');
		$this->load->library('form_validation');
		$this->load->model('datatables_model');
	}

	public function index(){
		$id_user = $this->session->userdata('id_user');
		$ket_sample = $this->permohonan_model->keterangan_sample();
		$penyimpanan_sample = $this->permohonan_model->penyimpanan_sample();
		$customer = $this->customer_model->getCustomerByUser($id_user);
		$no_permohonan = getKodeRegistrasi();
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();

		$data = array('title' => 'Form Permohonan',
					  'ket_sample' => $ket_sample,
					  'dataAnalist' => array(),
					  'penyimpanan_sample' =>$penyimpanan_sample,
					  'customer' => $customer,
					  'no_permohonan' => $no_permohonan,
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
		$no_permohonan = $this->input->post('0[no_permohonan]');
		$id_customer = $this->input->post('0[id_customer]');
		$tgl_kirim = $this->input->post('0[tgl_kirim]');
		$jenis_sample = $this->input->post('0[jenis_sample]');
		$jml_sample = $this->input->post('0[jml_sample]');
		$penyimpanan = $this->input->post('0[penyimpanan]');
		$keterangan_sample = $this->input->post('0[keterangan_sample]');

		$data = array('no_permohonan' => $no_permohonan,
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
				$dataDetail[] = array('no_permohonan' 	=> $no_permohonan,
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
        	$no_permohonan = base64_encode($row->no_permohonan);
        	$urlKode = urlencode($no_permohonan);
        	$disabled = ($row->status =='0') ? '' : 'disabled';
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('permohonan/detailPermohonan/').$urlKode.'">'.$row->no_permohonan.'</a>';               
            $sub_array[] = $row->tgl_kirim;  
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = '<span class="badge '.$row->class_color.'target="_blank"">'.$row->keterangan.'</span>';
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" '.$disabled.' data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.$no_permohonan.'\')">Kirim Sample</button>';
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
		$no_permohonan = $this->input->post('no_permohonan');
		$tgl_kirim = $this->input->post('tgl_kirim');
		$no_resi = $this->input->post('no_resi');

		$data = array('no_permohonan' => base64_decode($no_permohonan),
					  'tgl_kirim' 		=> $tgl_kirim,
					  'no_resi'			=> $no_resi,
					  'status'			=> '1'
					);
		$result = $this->permohonan_model->editpermohonan($data);
		echo json_encode($result);
	}

	public function detailPermohonan($no_permohonan){
		$no_permohonan = base64_decode(urldecode($no_permohonan));
		$dataPermohonan = $this->permohonan_model->permohonanByID($no_permohonan);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($no_permohonan);
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
            $sub_array[] = '<a href="'.base_url('admin/detailPermohonan/').generateUrl($row->no_permohonan).'">'.$row->no_permohonan.'</a>';
            $sub_array[] = '<a href="'.base_url('permohonan/cetakKode/').$row->kode_sample.'">'.$row->kode_sample.'</a>';; 
            $sub_array[] = dateDefault($row->tgl_kirim); 
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->nama_customer;
            $sub_array[] = '<span class="badge '.$row->class_color.'">'.$row->keterangan.'</span>';
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.generateUrl($row->no_permohonan).'\')">Invoice</button>';
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
		$no_permohonan = $this->input->post('0[no_permohonan]');
		$tgl_terima_sample = $this->input->post('0[tgl_terima_sample]');
		$tgl_perkiraan_selesai = $this->input->post('0[tgl_perkiraan_selesai]');
		$kode_sample = $this->input->post('0[kode_sample]');
		$kode_order = $this->input->post('0[kode_order]');

		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($no_permohonan);

		$data = array('no_permohonan' 	=> $no_permohonan,
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

	public function blankoPermohonan($kode_order){
		$kode_order = base64_decode(urldecode($kode_order));
		$tempSurat = $this->permohonan_model->getTemplateSurat('surat_permohonan');
		$suratPermohonan = str_replace(['{base_url}', '{title}','{date}'],[base_url(),'Blanko Permohonan', dateDefault(date('Y-m-d'))],$tempSurat->template_surat);

		$data = $this->permohonan_model->getPermohonanBYorder($kode_order);
		$detail = $this->permohonan_model->detailPermohonanByID($data->no_permohonan);
		$dataKalab = $this->permohonan_model->getKalab();

		$find = ['{kode_order}','{tgl_terima_sample}','{tgl_perkiraan_selesai}','{nama_pemohon}','{alamat}','{no_telp}','{jenis_sample}','{kode_sample}','{jml_sample}','{penyimpanan}','{keterangan_sample}','{nip}', '{kalab}'];
		$replace = [$kode_order, dateDefault($data->tgl_terima_sample), dateDefault($data->tgl_perkiraan_selesai), $data->nama_customer, $data->alamat, $data->no_telp, $data->jenis_sample, $data->kode_sample, $data->jml_sample, $data->penyimpanan, $data->keterangan_sample,$dataKalab->nip, $dataKalab->nama_pegawai];
		$suratPermohonan = str_replace($find,$replace,$suratPermohonan);

		// $total = count($detail);
		for ($index=0; $index < 10 ; $index++) { 
			$no = '{no'.$index.'}';
			$analisa = '{analisa'.$index.'}';
			$metode = '{metode'.$index.'}';
			$find = [$no, $analisa, $metode];
			if($index < count($detail)){
				$replace = [$index+1, $detail[$index]->jenis_analisa, $detail[$index]->metode_analisa];
			}else{
				$replace = ['', '', ''];
			}

			$suratPermohonan = str_replace($find,$replace,$suratPermohonan);
		}
		$data = array('title' => 'Blanko Permohonan',
						'isi' => $suratPermohonan
					);
        $this->load->view('permohonan/blanko_permohonan',$data, FALSE);
	}

	public function suratTugas($surat_tugas){
		$kode_surat = base64_decode(urldecode($surat_tugas));
		$tempSurat = $this->permohonan_model->getTemplateSurat('surat_tugas');
		$surat_tugas = str_replace(['{base_url}', '{title}','{date}'],[base_url(),'Surat Tugas', dateDefault(date('Y-m-d'))],$tempSurat->template_surat);

		$data = $this->permohonan_model->getDetail($kode_surat);
		$analist = $this->analis_model->getAnalistByID($data->id_analist);
		$dataKalab = $this->permohonan_model->getKalab();

		$find = ['{nomor_tugas}','{nama_analist}','{nip_analist}','{jabatan_analist}','{unit_analist}','{nama_kalab}','{nip_kalab}','{jabatan_kalab}','{unit_kalab}','{analisa}','{sample}','{jml_sample}'];
		$replace = [$kode_surat, $analist->nama_pegawai, $analist->nip, $analist->nama_jabatan, $analist->nama_unit, $dataKalab->nama_pegawai, $dataKalab->nip, $dataKalab->nama_jabatan, $dataKalab->nama_unit, $data->jenis_analisa, $data->jenis_sample, $data->jml_sample];
		$surat_tugas = str_replace($find,$replace,$surat_tugas);

		$data = array('title' => 'Surat Tugas',
						'isi' => $surat_tugas
					);
        $this->load->view('permohonan/blanko_permohonan',$data, FALSE);
	}
}