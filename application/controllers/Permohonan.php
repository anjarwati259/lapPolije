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
			$idtable = $this->input->post('idtable');
			$dataHtml = '<select name="jenis_analisa'.$index.'" id="jenis_analisa'.$index.'" class="form-select" onchange="setMetode('.$idtable.','.$index.')">';
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
		$no_permohonan = $this->input->post('0[no_permohonan]');
		$id_customer = $this->input->post('0[id_customer]');
		$tgl_kirim = $this->input->post('0[tgl_kirim]');
		$jenis_sample = $this->input->post('0[jenis_sample]');
		$jml_sample = $this->input->post('0[jml_sample]');
		$penyimpanan = $this->input->post('0[penyimpanan]');
		$keterangan_sample = $this->input->post('0[keterangan_sample]');

		$data = array('no_permohonan' => $no_permohonan,
					  'created_by'			=> $this->session->userdata('id_user'),
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
			for ($i=1; $i <= $jml_sample ; $i++) { 
				// var_dump($this->input->post('catatan['.$i.']'));
				$catatan = array('no_sample' => $i,
								 'catatan' => $this->input->post('catatan['.$i.']'),
								 'created_at' => date('Y-m-d H:i:sa')
								);
				$id = $this->permohonan_model->insertcatatan($catatan);
				$data = $this->input->post($i);
				foreach ($data as $key => $value) {
					$dataDetail[] = array('id_jenis_analisa' => $value['jenis_analisa'],
										'id_metode_analisa' => $value['metode_analisa'],
										'id_user' => $this->session->userdata('id_user'),
										'id_sampel' => $id,
										'id_permohonan' 	=> $result,
										'created_at' 		=> date('Y-m-d H:i:sa')
									);
				}
			}
			$this->permohonan_model->insertDetailpermohonan($dataDetail);
			$return = array('status' => 'success',
							'message' => 'Data Permohoan Berhasil Disimpan');
		}else{
			$return = array('status' => 'error',
							'message' => 'Data Permohoan Tidak Berhasil Disimpan');
		}
		echo json_encode($return);exit;
	}

	// public function simpanPermohonan1(){
	// 	$action = $this->input->post('action');
	// 	$status = ($action == 'submit') ? '0' : '5';
	// 	$totalIndex = $this->input->post('0[totalIndex]');
	// 	$no_permohonan = $this->input->post('0[no_permohonan]');
	// 	$id_customer = $this->input->post('0[id_customer]');
	// 	$tgl_kirim = $this->input->post('0[tgl_kirim]');
	// 	$jenis_sample = $this->input->post('0[jenis_sample]');
	// 	$jml_sample = $this->input->post('0[jml_sample]');
	// 	$penyimpanan = $this->input->post('0[penyimpanan]');
	// 	$keterangan_sample = $this->input->post('0[keterangan_sample]');

	// 	$data = array('no_permohonan' => $no_permohonan,
	// 				  'id_user'			=> $this->session->userdata('id_user'),
	// 				  'id_customer'		=> $id_customer,
	// 				  'tgl_kirim'		=> $tgl_kirim,
	// 				  'jenis_sample'	=> $jenis_sample,
	// 				  'jml_sample'		=> $jml_sample,
	// 				  'penyimpanan'		=> $penyimpanan,
	// 				  'keterangan_sample' => $keterangan_sample,
	// 				  'status'			=> $status
	// 				);
	// 	$result = $this->permohonan_model->insertPermohonan($data);
	// 	if(!empty($result)){
	// 		$dataDetail =[];
	// 		for ($index=1; $index <= $totalIndex; $index++) { 
	// 			$jenis_analisa = $index.'[jenis_analisa]';
	// 			$metode_analisa = $index.'[metode_analisa]';
	// 			$dataDetail[] = array('no_permohonan' 	=> $no_permohonan,
	// 								'id_user'			=> $this->session->userdata('id_user'),
	// 								'id_jenis_analisa' 	=> $this->input->post($jenis_analisa),
	// 								'id_metode_analisa'	=> $this->input->post($metode_analisa),
	// 								'created_at' 		=> date('Y-m-d H:i:sa')
	// 							);

	// 		}
	// 		$this->permohonan_model->insertDetailpermohonan($dataDetail);
	// 		$return = array('status' => 'success',
	// 						'message' => 'Data Permohoan Berhasil Disimpan');

	// 	}else{
	// 		$return = array('status' => 'error',
	// 						'message' => 'Data Permohoan Tidak Berhasil Disimpan');
	// 	}
	// 	echo json_encode($return);
	// }

	public function riwayatPermohonan(){
		$ekspedisi = $this->permohonan_model->getEkspedisi();
		$data = array('title' => 'Riwayat Permohonan',
					  'ekspedisi' => $ekspedisi,
						'dataAnalist' => array(),
                      'isi' => 'permohonan/riwayat_permohonan');
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getDatapermohonan(){
		$fetch_data = $this->permohonan_model->getRiwayatPermohonan();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
        	$id = base64_encode($row->id);
        	$urlKode = urlencode($id);
        	// $disabled = ($row->status =='0') ? '' : 'disabled';
        	$action = $this->buttonAction($row->status);
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('permohonan/detailPermohonan/').$urlKode.'">'.$row->no_permohonan.'</a>';               
            $sub_array[] = dateDefault($row->tgl_kirim);  
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = '<span class="badge '.$row->class_color.'target="_blank"">'.$row->keterangan.'</span>';
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" '.$action['disabled'].' data-bs-toggle="modal" data-bs-target="#'.$action['modal'].'" onclick="action(\''.$urlKode.'\',\''.$action['action'].'\')">'.$action['label'].'</button>';
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

	private function buttonAction($status){
		// largeModal
		if($status == '0'){
			$result = array('action' => 'konfirmApproved',
							'label' => 'Konfirmasi Penawaran',
							'disabled' => 'disabled',
							'modal' =>'default',
							'invoice' =>'0'
						);
		}else if($status =='1'){
			$result = array('action' => 'konfirmApproved',
							'label' => 'Konfirmasi Penawaran',
							'disabled' => '',
							'modal' =>'default',
							'invoice' =>'0'
						);
		}else if($status == '2'){
			$result = array('action' => 'konfirmBayar',
							'label' => 'Konfirmasi Bayar',
							'disabled' => '',
							'modal' =>'konfirmBayar',
							'invoice' =>'1'
						);
		}else if($status == '4'){
			$result = array('action' => 'kirimSample',
							'label' => 'Kirim Sample',
							'disabled' => '',
							'modal' =>'largeModal',
							'invoice' =>'1'
						);
		}else if($status == '21'){
			$result = array('action' => 'batal',
							'label' => 'Konfirmasi Bayar',
							'disabled' => 'disabled',
							'modal' =>'default',
							'invoice' =>'0'
						);
		}else{
			$result = array('action' => 'batal',
							'label' => 'Konfirmasi Bayar',
							'disabled' => 'disabled',
							'modal' =>'default',
							'invoice' =>'0'
						);
		}
		return $result;
	}

	public function appPenawaran(){
		$id = $this->input->post('id');
		$action = $this->input->post('action');
		$status = ($action == 'approved') ? ('2') : ('20');
		$invoice = generateKode('invoice',$id);
		$dokument = array('id_permohonan' => $id,
						  'type'		=> 'invoice',
						  'kode_dokumen' => $invoice,
						  'status'		=> '1',
						  'created_at'	=> date('Y-m-d H:i:sa')
						);
		$this->permohonan_model->saveDokumen($dokument);
		$data = array('id' => $id,
					  'status' 	=> $status);
		$result = $this->permohonan_model->editpermohonan($data);
		
		echo json_encode($result);
	}

	public function kirimResi(){
		$no_permohonan = $this->input->post('no_permohonan');
		$tgl_kirim = $this->input->post('tgl_kirim');
		$no_resi = $this->input->post('no_resi');
		$ekspedisi = $this->input->post('ekspedisi');

		$data = array('id'			=> base64_decode(urldecode($no_permohonan)),
					  'tgl_kirim' 	=> $tgl_kirim,
					  'no_resi'		=> $no_resi,
					  'ekspedisi'	=> $ekspedisi,
					  'status'		=> '5'
					);
		$result = $this->permohonan_model->editpermohonan($data);
		echo json_encode($result);
	}

	public function detailPermohonan($id){
		$id = base64_decode(urldecode($id));
		$dataPermohonan = $this->permohonan_model->permohonanByID($id);
		$detailPermohonan = $this->permohonan_model->detailPermohonanByID($id);
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
        	$disabled = ($row->status == '0') ? ('') :('disabled');  
            $sub_array = array();
            $sub_array[] = $no;                
            $sub_array[] = '<a href="'.base_url('admin/detailPermohonan/').generateUrl($row->no_permohonan).'">'.$row->no_permohonan.'</a>'; 
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->jml_sample;
            $sub_array[] = $row->nama_customer;
            $sub_array[] = '<span class="badge '.$row->class_color.'">'.$row->keterangan.'</span>';
            $sub_array[] = '<a href="'.base_url('admin/penawaran/').generateUrl($row->id).'" class="btn btn-primary btn-sm '.$disabled.'">Penawaran</a>';
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

	public function dataPenawaran(){
		$fetch_data = $this->permohonan_model->getDatapenawaran();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {
        	$disabled = ($row->status == '3') ? ('') :('disabled');  
            $sub_array = array();
            $sub_array[] = $no;                
            $sub_array[] = '<a href="'.base_url('admin/detailPermohonan/').generateUrl($row->no_penawaran).'">'.$row->no_penawaran.'</a>'; 
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->jml_sample;
            $sub_array[] = $row->nama_customer;
            $sub_array[] = '<span class="badge '.$row->class_color.'">'.$row->keterangan.'</span>';
            $sub_array[] = '<a href="'.base_url('admin/konfirmBayar/').generateUrl($row->id).'" class="btn btn-primary btn-sm '.$disabled.'">Konfirmasi Bayar</a>';
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

	public function dataPesanan(){
		$fetch_data = $this->permohonan_model->getDatapesanan();  
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {
        	$disabled = ($row->status == '3') ? ('') :('disabled');  
            $sub_array = array();
            $sub_array[] = $no;                
            $sub_array[] = '<a href="'.base_url('admin/detailPermohonan/').generateUrl($row->id).'">'.$row->no_pesanan.'</a>'; 
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->jml_sample;
            $sub_array[] = $row->nama_customer;
            $sub_array[] = '<span class="badge '.$row->class_color.'">'.$row->keterangan.'</span>';
            $sub_array[] = '<a href="'.base_url('admin/konfirmBayar/').generateUrl($row->id).'" class="btn btn-primary btn-sm '.$disabled.'">Konfirmasi Bayar</a>';
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
		$dataAnalist = $this->input->post('data');
		$dataPermohonan = $this->input->post('dataPermohonan');
		$sample = $this->input->post('sample');
		$dataPermohonan['status'] = '6';
		foreach ($sample as $key => $value) {
			$no_blanko = generateKode('no_blanko',$value['id']);
			$sample[$key]['no_blanko'] = $no_blanko;
		}

		$data = array('dataAnalist' => $dataAnalist,
					  'dataSample' => $sample
					);
		$result = $this->permohonan_model->saveBatchPermohonan($data);
		if($result['status'] == 'success'){
			$result = $this->permohonan_model->editpermohonan($dataPermohonan);
		}
		echo json_encode($result);
		// var_dump($result);
	}

	public function blankoPermohonan($no_blanko){
		$no_blanko = base64_decode(urldecode($no_blanko));
		$tempSurat = $this->permohonan_model->getTemplateSurat('surat_permohonan');
		$suratPermohonan = str_replace(['{base_url}', '{title}','{date}'],[base_url(),'Blanko Permohonan', dateDefault(date('Y-m-d'))],$tempSurat->template_surat);
		$detailSample = $this->permohonan_model->getPermohonanID($no_blanko);
		$data = $this->permohonan_model->permohonanByID($detailSample->id_permohonan);
		$detail = $this->permohonan_model->detailPermohonanByID($detailSample->id_permohonan, $detailSample->id_sampel);
		$dataKalab = $this->permohonan_model->getKalab();

		$find = ['{kode_order}','{tgl_terima_sample}','{tgl_perkiraan_selesai}','{nama_pemohon}','{alamat}','{no_telp}','{jenis_sample}','{kode_sample}','{jml_sample}','{penyimpanan}','{keterangan_sample}','{nip}', '{kalab}'];
		$replace = [$no_blanko, dateDefault($data->tgl_terima_sample), dateDefault($data->tgl_perkiraan_selesai), $data->nama_customer, $data->alamat, $data->no_telp, $data->jenis_sample, $detail[0]->kode_sample, $data->jml_sample, $data->penyimpanan, $data->keterangan_sample,$dataKalab->nip, $dataKalab->nama_pegawai];
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

	public function tambahFormAnalisa(){
		$jml_sample = $this->input->post('jml_sample');
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();
		$data = array('jenis_analisa' => $jenis_analisa,
					  'jml_sample' => $jml_sample
					);
		$this->load->view('permohonan/form_analisa',$data, FALSE);
	}

	public function simpanPenawaran(){
		$id_permohonan = $this->input->post('id');
		$noPenawaran = generateKode('penawaran', $id_permohonan);
		$total_harga = $this->input->post('total_harga');
		$total_harga = (int) str_replace('.', '', $total_harga);
		$data = $this->input->post('data');

		$updatePermohonan = array('id' => $id_permohonan,
								  'no_penawaran' => $noPenawaran,
								  'total_harga'	=> $total_harga,
								  'status'		=> '1'
								);
		$dataUpdate = array();
		foreach ($data as $key => $value) {
			$harga = str_replace('.', '', $value['harga']);
			$dataUpdate[] = array('id' => $value['id'],
								  'harga_satuan' => (int) $harga
							);
		}
		$result = $this->permohonan_model->updateBatchDetailPermohonan($dataUpdate);

		if($result['status'] == 'success'){
			$result = $this->permohonan_model->editpermohonan($updatePermohonan);
		}
		echo json_encode($result);
	}

	public function getDataBayar(){
		$id_permohonan = $this->input->post('id');
		$id = base64_decode(urldecode($id_permohonan));
		$dataPermohonan = $this->permohonan_model->permohonanByID($id);
		echo json_encode($dataPermohonan);
	}

	public function kirimBuktiBayar(){
		$jml_bayar = $this->input->post('jml_bayar');
		$tgl_bayar = $this->input->post('tgl_bayar');
		$rekening = $this->input->post('rekening');
		$id = $this->input->post('id');
		$atas_nama = $this->input->post('atas_nama');
		// upload gambar
		$config['upload_path']="./upload"; //path folder file upload
        $config['allowed_types']= 'gif|jpg|png|jpeg'; //type file yang boleh di upload
        $config['encrypt_name'] = FALSE; //enkripsi file name upload
        $config['max_size']			= '1000';//dalam kb
		$config['max_width']		= '2024';
		$config['max_height']		= '2024';
        // var_dump($config);exit;
         
        $this->load->library('upload',$config); //call library upload 
        if($this->upload->do_upload("bukti_bayar")){ //upload file
            $data = array('upload_data' => $this->upload->data()); //ambil file name yang diupload
 
            $judul= $this->input->post('judul'); //get judul image
            $image= $data['upload_data']['file_name']; //set file name ke variable image
            // $result= $this->m_upload->simpan_upload($judul,$image); //kirim value ke model m_upload
            $data = array('id_permohonan' => $id,
        				  'tgl_bayar' => $tgl_bayar,
        				  'atas_nama' => $atas_nama,
        				  'jml_bayar' => $jml_bayar,
        				  'rekening' => $rekening,
        				  'bukti_bayar' => $image,
        				  'created_by'	=> $this->session->userdata('id_user'),
        				  'created_at' => date('Y-m-d H:i:sa')

        				);
            $hasil = $this->permohonan_model->simpanBayar($data);
            if($hasil['status'] == 'success'){
            	$result = $this->permohonan_model->editpermohonan(array('id' =>$id, 'status' => '3'));
            }else{
            	$result = $hasil;
            }
        }else{
        	$error = $this->upload->display_errors();
        	$result = array('status' => 'error',
        					'message' => $error);
        }
        echo json_encode($result);
	}

	public function bukti_bayar($bukti){
		$bukti_bayar = base64_decode(urldecode($bukti));
		$html = '<img style="display: block; margin-left: auto; margin-right: auto; max-height: 700px; max-width: 500px;" src="'.base_url().'upload/'.$bukti_bayar.'">';
		echo $html;
	}

	public function appBayar(){
		$id = $this->input->post('id');
		$action = $this->input->post('action');

		$no_pesanan = generateKode('pesanan', $id);
		$status = ($action == 'approved') ? ('4') : ('22');
		$data = array('id' => $id,
					  'no_pesanan' => $no_pesanan,
					  'status' => $status);

		$kwitansi = generateKode('kwitansi', $id);
		$dokument = array('id_permohonan' => $id,
						  'type'	=> 'kwitansi',
						  'kode_dokumen' => $kwitansi,
						  'status'	=> '1',
						  'created_at' => date('Y-m-d H:i:sa')
						);
		$this->permohonan_model->saveDokumen($dokument);
		$result = $this->permohonan_model->editpermohonan($data);
		echo json_encode($result);
	}
}