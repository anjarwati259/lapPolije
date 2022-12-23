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

	public function insertanalis($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_analis', $data);

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

	public function listanalis(){
		$this->db->select('*');
		$this->db->from('tb_analis');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// untuk datatable
	public function getDataanalis(){
		$this->db->select('*');  
       	$this->db->from('tb_analis'); 
       	$this->db->where('status','1'); 
       	if(isset($_POST["search"]["value"]))  
       	{  
            $this->db->like("nama_analis", $_POST["search"]["value"]);  
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

	public function getanalis($id){
		$this->db->select('*');
		$this->db->from('tb_analis');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editanalis($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_analis',$data);

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

	public function delanalis($id){
		$this->db->where('id', $id);
		$this->db->update('tb_analis', array('status' => '0'));
	}
}