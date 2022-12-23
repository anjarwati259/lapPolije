<?php 

/**
 * 
 */
class Pegawai_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertpegawai($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_pegawai', $data);

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

	public function listPegawai(){
		$this->db->select('*');
		$this->db->from('tb_pegawai');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// untuk datatable
	public function getDatapegawai(){
		$this->db->select('tb_pegawai.*, tb_jabatan.nama_jabatan, tb_unit.nama_unit');  
       	$this->db->from('tb_pegawai');  
       	$this->db->join('tb_unit','tb_unit.id = tb_pegawai.id_unit', 'left');
       	$this->db->join('tb_jabatan','tb_jabatan.id = tb_pegawai.id_jabatan', 'left');
       	$this->db->where('tb_pegawai.status','1');
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("nama_pegawai", $_POST["search"]["value"]); 
            $this->db->like("nip", $_POST["search"]["value"]); 
       	}  
       	if(isset($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
       	}  
       	else  
       	{  
            $this->db->order_by('id', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function getPegawai($id){
		$this->db->select('*');
		$this->db->from('tb_pegawai');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editpegawai($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_pegawai',$data);

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

	public function delPegawai($id){
		$this->db->where('id', $id);
		$this->db->update('tb_pegawai', array('status' => '0'));
	}
}