<?php 

/**
 * 
 */
class User_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//login user
	public function login($username, $password)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where(array(	'username'	=> $username,
								'password'	=> sha1($password)));
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}
}