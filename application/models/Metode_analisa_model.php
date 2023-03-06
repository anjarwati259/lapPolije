<?php 

/**
 * 
 */
class Metode_analisa_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertmetode_analisa1($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_metode_analisa', $data);

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

	public function insertmetode_analisa($data, $datafile){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_metode_analisa', $data);
	        $datafile['id_metode_analisa'] = $this->db->insert_id();
	        $this->db->insert('tb_file', $datafile);

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

	public function listMetodeanalisa(){
		$this->db->select('*');
		$this->db->from('tb_metode_analisa');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// untuk datatable
	public function getDatametode_analisa(){
		$this->db->select('tb_metode_analisa.*, tb_jenis_analisa.jenis_analisa, tb_file.nama_file');  
       	$this->db->from('tb_metode_analisa');
       	$this->db->join('tb_jenis_analisa','tb_jenis_analisa.id = tb_metode_analisa.id_jenis_analisa', 'left');
       	$this->db->join('tb_file','tb_file.id_metode_analisa = tb_metode_analisa.id', 'left');
       	$this->db->where('tb_metode_analisa.status','1');  
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("tb_metode_analisa.metode_analisa", $_POST["search"]["value"]);  
       	}  
       	if(isset($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
       	}  
       	else  
       	{  
            $this->db->order_by('tb_metode_analisa.id', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function getMetodeanalisa($id){
		$this->db->select('*');
		$this->db->from('tb_metode_analisa');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editmetode_analisa($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_metode_analisa',$data);

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

	public function delMetodeanalisa($id){
		$this->db->where('id', $id);
		$this->db->update('tb_metode_analisa', array('status' => '0'));
	}

	public function getMetodeByid($id){
		$this->db->select('*');
		$this->db->from('tb_metode_analisa');
		$this->db->where('id_jenis_analisa',$id);
		$query = $this->db->get();
		return $query->result();
	}
}