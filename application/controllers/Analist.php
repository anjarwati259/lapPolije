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
            $id = base64_encode($row->id);
            $urlKode = urlencode($id);
            $class_color = ($row->status_analist == 0) ? ('bg-warning text-dark') : ('bg-success text-dark');
            $status_analist = ($row->status_analist == 0) ? ('Belum Selesai') : ('Selesai');
            // $disabled = ($row->status =='0') ? '' : 'disabled';
            $sub_array = array(); 
            $sub_array[] = $no;               
            $sub_array[] = '<a href="'.base_url('analist/detailPermohonan/').$urlKode.'/'.$row->id_detail.'">'.$row->no_pesanan.'</a>';               
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

    public function detailPermohonan($no_permohonan, $id_detail){
        $id_user = $this->session->userdata('id_user');
        $id_analist = $this->analis_model->getIdAnalist($id_user);
        $no_permohonan = base64_decode(urldecode($no_permohonan));
        $dataPermohonan = $this->permohonan_model->permohonanByID($no_permohonan);
        $detailPermohonan = $this->analis_model->detailPermohonan($id_detail);
        $data = array('title' => 'Detail Permohonan',
                      'dataPermohonan' => $dataPermohonan,
                      'detailPermohonan' => $detailPermohonan,
                      'dataAnalist'     =>array(),
                      'isi' => 'permohonan/detail_permohonan_analist');
        $this->load->view('layout/wrapper',$data, FALSE);
    }

    public function submitAnalisa(){
        $data = $this->input->post('data');
        $data['status'] = 1;
        // $id = $this->input->post('id');
        // $ulangan1 = $this->input->post('ulangan1');
        // $ulangan2 = $this->input->post('ulangan2');
        // $rata_rata = $this->input->post('rata_rata');
        // $id_analist = $this->input->post('id_analist');
        // $no_permohonan = $this->input->post('no_permohonan');
        // $data = array('id' => $id,
        //               'pengulangan_1' => (float)$ulangan1,
        //               'pengulangan_2' => (float)$ulangan2,
        //               'rata_rata' => (float)$rata_rata,
        //               'status'  => '1'
        //             );
        $result = $this->analis_model->upDetailPermohonan($data);

        if($result['status'] == 'success'){
            $dataUp = array('id' => $data['id'],
                            'id_permohonan' => $data['id_permohonan'],
                            'status_detail' => '0',
                            'status_up'     => '7'
                            );
            $this->analis_model->updateStatus($dataUp);
            $this->analis_model->updateMinAnalist($data['id_analist']);
        }
        echo json_encode($result);
    }

    public function ApprovedAnalisa(){
        $id = $this->input->post('id');
        $no_permohonan = $this->input->post('no_permohonan');
        $dataDetail = $this->analis_model->dataDetailByID($id);
        $kode_doc = generateKode('selesai_tugas', $dataDetail->no_surat);
        
        $data = array('id' => $id,
                      'selesai_tugas' => $kode_doc,
                      'status' => '3',
                    );
        $result = $this->analis_model->upDetailPermohonan($data);
        if($result['status'] == 'success'){
            $dataUp = array('id' => $id,
                            'id_permohonan' => $no_permohonan,
                            'tgl_selesai'   => date('Y-m-d'),
                            'status_detail' => '1',
                            'status_up'     => '8'
                            );
            // var_dump($dataUp);exit;
            $hasil = $this->analis_model->updateStatus($dataUp);
            if($hasil == true){
                $sertifikat = generateKode('sertifikat', $dataDetail->id_sampel);
                $dataDoc = array('id' => $dataDetail->id_sampel,
                                 'no_sertifikat' => $sertifikat,
                            );
                $this->permohonan_model->updateDetailSample($dataDoc);
            }
        }

        echo json_encode($result);
        // $result = $this->analis_model->upDetailPermohonan($data);

    }

    public function batasAnalist(){
        $id = $this->input->post('id_analist');
        
    }
}