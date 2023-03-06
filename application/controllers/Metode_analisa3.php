<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metode_analisa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//proteksi halaman
		$this->simple_login->cek_login();
		$this->load->model('metode_analisa_model');
		$this->load->model('jenis_analisa_model');
		$this->load->model('datatables_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$jenis_analisa = $this->jenis_analisa_model->listJenisanalisa();
		$data = array('title' => 'Data Metode Analisa',
					  'jenis_analisa' => $jenis_analisa,
                      'isi' => 'metode_analisa/data_metode_analisa' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function addMetodeanalisa(){
		$id = $this->input->post('id');
		$metode_analisa = $this->input->post('metode_analisa');

		if(empty($id)){
			// upload gambar
			$config['upload_path']="./upload"; //path folder file upload
	        $config['allowed_types']= 'gif|jpg|png|jpeg|pdf'; //type file yang boleh di upload
	        $config['encrypt_name'] = FALSE; //enkripsi file name upload
	        $config['max_size']			= '2024';//dalam kb
			$config['max_width']		= '2024';
			$config['max_height']		= '2024';

			$this->load->library('upload',$config);
			if($this->upload->do_upload("upload_file")){
				$file = array('upload_data' => $this->upload->data());

				$datafile = array('nama_file' => $file['upload_data']['file_name'],
									'created_at' => date('Y-m-d H:i:sa'),
									'status' => '1');
				
				$data = array('metode_analisa' => $metode_analisa, 
								'created_at' => date('Y-m-d H:i:sa'),
								'status' => '1');
				$result = $this->metode_analisa_model->insertmetode_analisa($data, $datafile);
			}else{
				$result = array('status' => 'error',
		    					'message' => $this->upload->display_errors(),
		    					'atribute' => '');
			}
		}else{
			echo 'edit';
		}

		echo json_encode($result);
	}

	// ambil data customer untuk datatable
	public function getDataMetodeanalisa(){
		$fetch_data = $this->metode_analisa_model->getDatametode_analisa();
        $data = array();  
        $no = 1;
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();     
            $sub_array[] = $no;  
            // $sub_array[] = $row->jenis_analisa;            
            $sub_array[] = $row->metode_analisa; 
            $sub_array[] = $row->nama_file; 
            // $sub_array[] = "Rp " . number_format($row->harga,2,',','.'); 
            $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" onclick="editmetode_analisa('.$row->id.')">Edit</button> <button type="button" class="btn btn-danger btn-sm" onclick="hapusmetode_analisa('.$row->id.')">Hapus</button>';
            $data[] = $sub_array;  
            $no++;
        }  
        $output = array(  
            "draw"				=> intval($_POST["draw"]),  
            "recordsTotal"		=> $this->datatables_model->get_all_data('tb_metode_analisa'),  
            "recordsFiltered"	=> count($data),
            "data"				=> $data  
        );  
        echo json_encode($output);
	}

	public function getMetodeanalisa(){
		
	}

	public function delMetodeanalisa(){
		
	}
}