<?php 

/**
 * 
 */
class Customer_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertcustomer($data){
		try {
	        $this->db->trans_begin();
	        $this->db->insert('tb_customer', $data);

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

	public function listCustomer(){
		$this->db->select('*');
		$this->db->from('tb_customer');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCustomer($id){
		$this->db->select('*');
		$this->db->from('tb_customer');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editcustomer($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_customer',$data);

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

	public function delCustomer($id){
		$this->db->where('id', $id);
		$this->db->delete('tb_customer');
	}
}