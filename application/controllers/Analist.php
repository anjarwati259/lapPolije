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

    public function daftarAnalisis(){
        $id_user = $this->session->userdata('id_user');
        $id_analist = $this->analis_model->getIdAnalist($id_user);
        $fetch_data = $this->analis_model->getDaftaranalisis($id_analist); 
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $no_permohonan = base64_encode($row->no_permohonan);
            $urlKode = urlencode($no_permohonan);
            $class_color = ($row->status_analist == 0) ? ('bg-warning text-dark') : ('bg-success text-dark');
            $status_analist = ($row->status_analist == 0) ? ('Belum Selesai') : ('Selesai');
            // $disabled = ($row->status =='0') ? '' : 'disabled';
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('analist/detailPermohonan/').$urlKode.'/'.$row->id_jenis_analisa.'/'.$row->id_metode_analisa.'">'.$row->no_permohonan.'</a>';               
            $sub_array[] = $row->kode_sample;  
            $sub_array[] = $row->jenis_sample;
            $sub_array[] = $row->jenis_analisa;
            $sub_array[] = $row->metode_analisa;
            // $sub_array[] = $row->status_analist;
            $sub_array[] = '<span class="badge '.$class_color.'target="_blank"">'.$status_analist.'</span>';
            // $sub_array[] = '<button type="button" class="btn btn-primary btn-sm" '.$disabled.' data-bs-toggle="modal" data-bs-target="#largeModal" onclick="kirimSampel(\''.$no_permohonan.'\')">Kirim Sample</button>';
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

    public function detailPermohonan($no_permohonan, $jenis_analisa, $metode_analisa){
        $no_permohonan = base64_decode(urldecode($no_permohonan));
        $dataPermohonan = $this->permohonan_model->permohonanByID($no_permohonan);
        $detailPermohonan = $this->analis_model->detailPermohonan($no_permohonan, $metode_analisa, $jenis_analisa);
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
        $id_analist = $this->input->post('id_analist');
        $no_permohonan = $this->input->post('no_permohonan');
        $data = array('id' => $id,
                      'pengulangan_1' => (float)$ulangan1,
                      'pengulangan_2' => (float)$ulangan2,
                      'rata_rata' => (float)$rata_rata,
                      'status'  => '1'
                    );
        $result = $this->analis_model->upDetailPermohonan($data);

        if($result['status'] == 'success'){
            $dataUp = array('id' => $id,
                            'no_permohonan' => $no_permohonan,
                            'status_detail' => '0',
                            'status_up'     => '3'
                            );
            $this->analis_model->updateStatus($dataUp);
            $this->analis_model->updateMinAnalist($id_analist);
        }
        echo json_encode($result);
    }

    public function ApprovedAnalisa(){
        $id = $this->input->post('id');
        $no_permohonan = $this->input->post('no_permohonan');
        $data = array('id' => $id,
                      'status' => '3',
                    );
        $result = $this->analis_model->upDetailPermohonan($data);
        if($result['status'] == 'success'){
            $dataUp = array('id' => $id,
                            'no_permohonan' => $no_permohonan,
                            'status_detail' => '1',
                            'status_up'     => '4'
                            );
            $hasil = $this->analis_model->updateStatus($dataUp);
            $kode_sample = $this->permohonan_model->getKodeSample($no_permohonan);
            $kode_doc = generateKode('selesai_tugas', $id);
            $dataDoc = array('id_detail_permohonan' => $id,
                             'no_permohonan' => $no_permohonan,
                             'type' => 'selesai_tugas',
                             'kode_dokumen' => $kode_doc,
                             'status'   => '1',
                             'created_at' => date('Y-m-d H:i:sa')
                            );
            $this->permohonan_model->saveDokumen($dataDoc);

            if($hasil == true){
                $kode_doc = generateKode('sertifikat', $kode_sample);
                $dataDoc = array('no_permohonan' => $no_permohonan,
                                'type' => 'sertifikat',
                                'kode_dokumen' => $kode_doc,
                                'status' => '1',
                                'created_at' => date('Y-m-d H:i:sa')
                            );
                $this->permohonan_model->saveDokumen($dataDoc);
            }
        }
        echo json_encode($result);
    }
}