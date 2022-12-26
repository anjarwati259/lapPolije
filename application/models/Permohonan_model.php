<?php 

/**
 * 
 */
class Permohonan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function keterangan_sample(){
		$this->db->select('*');
		$this->db->from('tb_keterangan_sample');
		$this->db->where('status', '1');
		$this->db->order_by('keterangan_sample','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function penyimpanan_sample(){
		$this->db->select('*');
		$this->db->from('tb_penyimpanan_sample');
		$this->db->where('status', '1');
		$this->db->order_by('nama_penyimpanan','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTempNomor($jenis){
		$this->db->select('*');
		$this->db->from('tb_temp_nomor');
		$this->db->where('jenis_nomor', $jenis);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}
}