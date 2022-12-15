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

	// untuk datatable
	public function getDatacustomer(){
		$this->db->select('id, nama_customer, alamat, no_telp, email');  
       	$this->db->from('tb_customer');  
       	if(isset($_POST["search"]["value"]))  
       	{  
            $this->db->like("nama_customer", $_POST["search"]["value"]);  
            $this->db->or_like("alamat", $_POST["search"]["value"]);  
            $this->db->or_like("no_telp", $_POST["search"]["value"]);
            $this->db->or_like("email", $_POST["search"]["value"]);
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