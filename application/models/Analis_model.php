<?php 

/**
 * 
 */
class analis_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function listAnalist(){
		$this->db->select('tb_analist.*, tb_pegawai.nama_pegawai');
		$this->db->from('tb_analist');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->where('tb_analist.status', '1');
		$this->db->order_by('tb_analist.id','asc');
		$query = $this->db->get();
		return $query->result();
	}
	public function getBatasAnalist(){
		$this->db->select('*');
		$this->db->from('tb_batas_analist');
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}

	public function getIdAnalist($id_user){
		$this->db->select('tb_pegawai.*, tb_analist.id as id_analist');
		$this->db->from('tb_pegawai');
		$this->db->join('tb_analist','tb_analist.id_pegawai = tb_pegawai.id', 'left');
		$this->db->where('tb_pegawai.id', $id_user);
		$query = $this->db->get()->row();
		return $query->id_analist;
	}

	public function getDaftaranalisis($id_analist){
		$this->db->select('a.*, b.id_jenis_analisa, b.id_metode_analisa,b.id as id_detail, b.status as status_analist, c.jenis_analisa, d.metode_analisa, e.kode_sample');
		$this->db->from('tb_permohonan a');
		$this->db->join('tb_detail_permohonan b','b.id_permohonan = a.id', 'left');
		$this->db->join('tb_jenis_analisa c','c.id = b.id_jenis_analisa', 'left');
		$this->db->join('tb_metode_analisa d','d.id = b.id_metode_analisa', 'left');
		$this->db->join('tb_detail_sample e','e.id = b.id_sampel', 'left');
		$this->db->where('b.id_analist', $id_analist);
		$this->db->order_by('b.update_at','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function detailPermohonan($id){
		$this->db->select('tb_detail_permohonan.*, tb_detail_sample.kode_sample, tb_jenis_analisa.jenis_analisa, tb_metode_analisa.metode_analisa, tb_pegawai.nama_pegawai');
		$this->db->from('tb_detail_permohonan');
		$this->db->join('tb_jenis_analisa','tb_jenis_analisa.id = tb_detail_permohonan.id_jenis_analisa', 'left');
		$this->db->join('tb_metode_analisa','tb_metode_analisa.id = tb_detail_permohonan.id_metode_analisa', 'left');
		$this->db->join('tb_analist','tb_analist.id = tb_detail_permohonan.id_analist', 'left');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->join('tb_detail_sample','tb_detail_sample.id = tb_detail_permohonan.id_sampel', 'left');
		$this->db->where('tb_detail_permohonan.id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function upDetailPermohonan($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_detail_permohonan',$data);

	        $db_error = $this->db->error();
	        if (!empty($db_error['message'])) {
	            throw new Exception($db_error['message']);
	        }
	        $this->db->trans_commit();
	        $result = array('status' => 'success',
	    					'message' => 'Data Berhasil Disimpan',
	    					'atribute' => '');
	    }catch (Exception $e) {
	    	$this->db->trans_rollback();
	    	$result = array('status' => 'error',
	    					'message' => $e->getMessage(),
	    					'atribute' => '');
	    }
	    return $result;
	}

	public function updateMinAnalist($id){
		$this->db->set('jml_analist', 'jml_analist-1', FALSE);
		$this->db->where('id', $id);
		$this->db->update('tb_analist');
	}
	public function updateStatus($data){
		$this->db->select('count(*) as total');
		$this->db->from('tb_detail_permohonan');
		$this->db->where('id_permohonan', $data['id_permohonan']);
		$this->db->where('status', $data['status_detail']);
		$query = $this->db->get()->row();

		if($query->total == 0){
			$this->db->set('status', $data['status_up']);
			$this->db->set('tgl_selesai', $data['tgl_selesai']);
			$this->db->where('id', $data['id_permohonan']);
			$this->db->update('tb_permohonan');
			$result = true;
		}else{
			$result = false;
		}
		return $result;
	}

	public function getAnalistByID($id){
		$this->db->select('tb_analist.*, tb_pegawai.nama_pegawai, tb_pegawai.nip, tb_jabatan.nama_jabatan, tb_unit.nama_unit');
		$this->db->from('tb_analist');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->join('tb_jabatan','tb_jabatan.id = tb_pegawai.id_jabatan', 'left');
		$this->db->join('tb_unit','tb_unit.id = tb_pegawai.id_unit', 'left');
		$this->db->where('tb_analist.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function dataDetailByID($id){
		$this->db->select('*');
		$this->db->from('tb_detail_permohonan');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	// area data analist

	public function getDataAnalist(){
		$this->db->select('tb_analist.*, tb_pegawai.nip, tb_pegawai.nama_pegawai');
		$this->db->from('tb_analist');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->where('tb_analist.status', '1');
		$query = $this->db->get();
		return $query->result();
	}

	public function cekAnalist($id){
		$this->db->select('count(*) as total');
		$this->db->from('tb_analist');
		$this->db->where('id_pegawai', $id);
		$this->db->where('status', '1');
		$query = $this->db->get()->row();
		if($query->total > 0){
			return true;
		}else{
			return false;
		}
		// return $query;
	}

	public function insertAnalist($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_analist', $data);

	        $db_error = $this->db->error();
	        if (!empty($db_error['message'])) {
	            throw new Exception($db_error['message']);
	        }
	        $this->db->trans_commit();
	        $result = array('status' => 'success',
	    					'message' => 'Data Berhasil Disimpan',
	    					'atribute' => '');
	    }catch (Exception $e) {
	    	$this->db->trans_rollback();
	    	$result = array('status' => 'error',
	    					'message' => $e->getMessage(),
	    					'atribute' => '');
	    }
	    return $result;
	}

	public function getAnalistId($id){
		$this->db->select('tb_analist.*, tb_pegawai.nip, tb_pegawai.nama_pegawai');
		$this->db->from('tb_analist');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->where('tb_analist.id', $id);
		$query = $this->db->get()->row();
		return $query;
	}

	public function editAnalist($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_analist',$data);

	        $db_error = $this->db->error();
	        if (!empty($db_error['message'])) {
	            throw new Exception($db_error['message']);
	        }
	        $this->db->trans_commit();
	        $result = array('status' => 'success',
	    					'message' => 'Data Berhasil Disimpan',
	    					'atribute' => '');
	    }catch (Exception $e) {
	    	$this->db->trans_rollback();
	    	$result = array('status' => 'error',
	    					'message' => $e->getMessage(),
	    					'atribute' => '');
	    }
	    return $result;
	}

	public function delAnalist($id){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $id);
			$this->db->update('tb_analist', array('status' => '0'));;

	        $db_error = $this->db->error();
	        if (!empty($db_error['message'])) {
	            throw new Exception($db_error['message']);
	        }
	        $this->db->trans_commit();
	        $result = array('status' => 'success',
	    					'message' => 'Data Berhasil Dihapus',
	    					'atribute' => '');
	    }catch (Exception $e) {
	    	$this->db->trans_rollback();
	    	$result = array('status' => 'error',
	    					'message' => $e->getMessage(),
	    					'atribute' => '');
	    }
	    return $result;
	}

	public function cekAnalist2($id_pegawai){
		$this->db->select('*');
		$this->db->from('tb_analist');
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get()->row();

		return $query;

		// if($query){
		// 	return true;
		// }else{
		// 	return false;
		// }
	}

	public function delete($id){
		$this->db->delete('tb_analist', array('id' => $id));
	}
}