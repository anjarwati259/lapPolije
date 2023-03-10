<?php 

/**
 * 
 */
class Variabel_content_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getContent($key){
		$this->db->select('*');
		$this->db->from('variabel_content');
		$this->db->where('key', $key);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}
}