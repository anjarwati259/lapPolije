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

	public function Register($data){
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	public function getUser($id){
		$this->db->select('user.*, tb_customer.nama_customer, tb_pegawai.nama_pegawai');
		$this->db->from('user');
		$this->db->join('tb_customer','tb_customer.id_user = user.id', 'left');
		$this->db->join('tb_pegawai','tb_pegawai.id_user = user.id', 'left');
		$this->db->where('user.id',$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();

		if($query->hak_akses == '1' || $query->hak_akses == '2'){
			$data = array('status' => 'success',
						  'id_user' => $query->id, 
						  'nama' => $query->nama_pegawai,
						  'username' => $query->username,
						  'hak_akses' => $query->hak_akses
						);
		}else if($query->hak_akses == '3'){
			$data = array('status' => 'success',
						  'id_user' => $query->id, 
						  'nama' => $query->nama_customer,
						  'username' => $query->username,
						  'hak_akses' => $query->hak_akses
						);
		}else{
			$data = array('status' => 'error',
						  'id_user' => '', 
						  'nama' => '',
						  'username' => '',
						  'hak_akses' => ''
						);
		}

		return $data;
	}

	public function getMenu($role){
		$this->db->select('*');
		$this->db->from('tb_menu');
		$this->db->where('role_id', $role);
		$this->db->where('status', '1');
		$this->db->order_by('order','asc');
		$query = $this->db->get();
		return $query->result();
	}
}