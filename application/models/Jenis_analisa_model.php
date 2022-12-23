<?php 

/**
 * 
 */
class Jenis_analisa_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertjenis_analisa($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_jenis_analisa', $data);

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

	public function listJenisanalisa(){
		$this->db->select('*');
		$this->db->from('tb_jenis_analisa');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// untuk datatable
	public function getDatajenis_analisa(){
		$this->db->select('*');  
       	$this->db->from('tb_jenis_analisa');
       	$this->db->where('status','1');  
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("jenis_analisa", $_POST["search"]["value"]);  
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

	public function getJenisanalisa($id){
		$this->db->select('*');
		$this->db->from('tb_jenis_analisa');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editjenis_analisa($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_jenis_analisa',$data);

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

	public function delJenisanalisa($id){
		$this->db->where('id', $id);
		$this->db->update('tb_jenis_analisa', array('status' => '0'));
	}
}