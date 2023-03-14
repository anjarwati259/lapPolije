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
		$this->db->select('user.*, tb_customer.nama_customer, tb_pegawai.nama_pegawai, tb_pegawai.id as id_pegawai, tb_customer.id as id_customer');
		$this->db->from('user');
		$this->db->join('tb_customer','tb_customer.id_user = user.id', 'left');
		$this->db->join('tb_pegawai','tb_pegawai.id_user = user.id', 'left');
		$this->db->where('user.id',$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();

		if($query->hak_akses == '1' || $query->hak_akses == '2' || $query->hak_akses == '4' || $query->hak_akses == '5' || $query->hak_akses == '6'){
			$data = array('status' => 'success',
						  'id_user' => $query->id_pegawai, 
						  'nama' => $query->nama_pegawai,
						  'username' => $query->username,
						  'id' => $query->id_pegawai,
						  'hak_akses' => $query->hak_akses
						);
		}else if($query->hak_akses == '3'){
			$data = array('status' => 'success',
						  'id_user' => $query->id_customer, 
						  'nama' => $query->nama_customer,
						  'username' => $query->username,
						  'id' => $query->id_customer,
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

	public function getProfileAdmin($id){
		$this->db->select('tb_pegawai.*, user.username, tb_jabatan.nama_jabatan, tb_unit.nama_unit');
		$this->db->from('tb_pegawai');
		$this->db->join('user','user.id = tb_pegawai.id_user', 'left');
		$this->db->join('tb_jabatan','tb_jabatan.id = tb_pegawai.id_jabatan', 'left');
		$this->db->join('tb_unit','tb_unit.id = tb_pegawai.id_unit', 'left');
		$this->db->where('tb_pegawai.id',$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();
		return $query;
	}

	public function getManagementUser(){
		$this->db->select('user.*, tb_pegawai.nip, tb_pegawai.nama_pegawai, tb_role.role_name');
		$this->db->from('user');
		$this->db->join('tb_pegawai','tb_pegawai.id_user = user.id', 'left');
		$this->db->join('tb_role','tb_role.id = user.hak_akses', 'left');
		$this->db->where('user.hak_akses !=','3');
		$this->db->order_by('user.updated_at','desc');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getRole(){
		$this->db->select('*');
		$this->db->from('tb_role');
		$this->db->where('status', '1');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getUserById($id){
		$this->db->select('user.*, tb_pegawai.nama_pegawai, tb_pegawai.nip, tb_pegawai.id as pegawai_id');
		$this->db->from('user');
		$this->db->join('tb_pegawai','tb_pegawai.id_user = user.id', 'left');
		$this->db->where('user.id', $id);
		$this->db->order_by('user.id','asc');
		$query = $this->db->get();
		return $query->row();
	}

	public function editUser($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('user',$data);

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
}