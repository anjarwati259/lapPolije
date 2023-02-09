<?php 

/**
 * 
 */
class Permohonan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function keterangan_sample(){
		$this->db->select('*');
		$this->db->from('tb_keterangan_sample');
		$this->db->where('status', '1');
		$this->db->order_by('keterangan_sample','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function penyimpanan_sample(){
		$this->db->select('*');
		$this->db->from('tb_penyimpanan_sample');
		$this->db->where('status', '1');
		$this->db->order_by('nama_penyimpanan','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTempNomor($jenis){
		$this->db->select('*');
		$this->db->from('tb_temp_nomor');
		$this->db->where('jenis_nomor', $jenis);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}

	public function getIdPermohonan(){
		$this->db->select('*');
		$this->db->from('tb_permohonan');
		$this->db->order_by('id', 'DESC'); 
		$query = $this->db->get()->row();
		$idPermohonan = (empty($query->id)) ? (1) : ($query->id);
		return $idPermohonan;
	}

	private function getKodeRegistrasi($id){
		$this->db->select('*');
		$this->db->from('tb_permohonan');
		$this->db->where('no_permohonan', $kode);
		$query = $this->db->get()->row();
		return $query->no_permohonan;
	}

	public function insertPermohonan($data){
		$this->db->insert('tb_permohonan', $data);
		// $no_permohonan = $this->getKodeRegistrasi($data['no_permohonan']);
		return $this->db->insert_id();
	}

	public function insertcatatan($data){
		$this->db->insert('tb_detail_sample', $data);
		return $this->db->insert_id();
	}

	public function updateDetailSample($data){
		$this->db->where('id', $data['id']);
		$this->db->update('tb_detail_sample',$data);
	}

	public function insertDetailpermohonan($data){
		$this->db->insert_batch('tb_detail_permohonan', $data);
	}

	public function getDatapermohonan(){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer');  
       	$this->db->from('tb_permohonan');
       	$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
       	$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
       	// $this->db->where('tb_permohonan.status !=','7');  
       	$this->db->or_where('tb_permohonan.status =','0');  
       	$this->db->or_where('tb_permohonan.status =','1');  
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("tb_permohonan.no_permohonan", $_POST["search"]["value"]);  
            $this->db->like("tb_permohonan.jenis_sample", $_POST["search"]["value"]); 
       	}  
       	if(!empty($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']); 
            $this->db->order_by('tb_permohonan.update_at', 'DESC'); 
       	}  
       	else  
       	{  
            $this->db->order_by('tb_permohonan.update_at', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function getRiwayatPermohonan(){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer');  
       	$this->db->from('tb_permohonan');
       	$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
       	$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
       	// $this->db->where('tb_permohonan.status !=','7'); 
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("tb_permohonan.no_permohonan", $_POST["search"]["value"]);  
            $this->db->like("tb_permohonan.jenis_sample", $_POST["search"]["value"]); 
       	}  
       	if(!empty($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']); 
            $this->db->order_by('tb_permohonan.update_at', 'DESC'); 
       	}  
       	else  
       	{  
            $this->db->order_by('tb_permohonan.update_at', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function editpermohonan($data){
		try {
	        $this->db->trans_begin();
	        $this->db->where('id', $data['id']);
			$this->db->update('tb_permohonan',$data);

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

	public function saveBatchPermohonan($data){
		try {
	        $this->db->trans_begin();
	        $this->db->update_batch('tb_detail_permohonan',$data['dataAnalist'], 'id');
	        $this->db->update_batch('tb_detail_sample',$data['dataSample'], 'id');

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

	public function permohonanByID($id){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer, tb_customer.no_telp, tb_customer.email, tb_customer.alamat');
		$this->db->from('tb_permohonan');
		$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
		$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
		$this->db->where('tb_permohonan.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function detailPermohonanByID($id, $id_sampel=null){
		$this->db->select('tb_detail_permohonan.*,tb_detail_sample.kode_sample, tb_jenis_analisa.jenis_analisa, tb_metode_analisa.metode_analisa, tb_pegawai.nama_pegawai, tb_metode_analisa.harga, tb_detail_sample.no_sample, tb_detail_sample.catatan');
		$this->db->from('tb_detail_permohonan');
		$this->db->join('tb_jenis_analisa','tb_jenis_analisa.id = tb_detail_permohonan.id_jenis_analisa', 'left');
		$this->db->join('tb_metode_analisa','tb_metode_analisa.id = tb_detail_permohonan.id_metode_analisa', 'left');
		$this->db->join('tb_analist','tb_analist.id = tb_detail_permohonan.id_analist', 'left');
		$this->db->join('tb_pegawai','tb_pegawai.id = tb_analist.id_pegawai', 'left');
		$this->db->join('tb_detail_sample','tb_detail_sample.id = tb_detail_permohonan.id_sampel', 'left');
		$this->db->where('tb_detail_permohonan.id_permohonan', $id);
		$this->db->like('tb_detail_permohonan.id_sampel',$id_sampel);
		$query = $this->db->get();
		return $query->result();
	}

	public function getLastId(){
		$this->db->order_by('kode_sample', 'DESC');

		$query = $this->db->get("tb_permohonan",1,0);
		return $query->row();
	}

	public function editDetailpermohonan($data){
		$this->db->where('id', $data['id']);
		$this->db->update('tb_detail_permohonan',$data);
	}

	public function addJmlAnalist($id){
		$this->db->set('jml_analist', 'jml_analist+1', FALSE);
		$this->db->where('id', $id);
		$this->db->update('tb_analist');
	}
	public function lastNoSurat(){
		$this->db->order_by('no_surat', 'DESC');
		$query = $this->db->get("tb_detail_permohonan",1,0);
		return $query->row();
	}

	public function saveDokumen($data){
		$this->db->insert('tb_daftar_dokumen', $data);
	}

	public function getKodeSample($no_permohonan){
		$this->db->select('*');
		$this->db->from('tb_permohonan');
		$this->db->where('no_permohonan', $no_permohonan);
		$query = $this->db->get()->row();
		return $query->kode_sample;
	}

	public function getTemplateSurat($key){
		$this->db->select('*');
		$this->db->from('tb_temp_surat');
		$this->db->where('key', $key);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}

	public function getPermohonanBYorder($kode_order){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer, tb_customer.no_telp, tb_customer.alamat, tb_customer.email, tb_customer.alamat');
		$this->db->from('tb_permohonan');
		$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
		$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
		$this->db->where('kode_order', $kode_order);
		$query = $this->db->get();
		return $query->row();
	}

	public function getKalab(){
		$this->db->select('tb_pegawai.*, tb_jabatan.nama_jabatan, tb_unit.nama_unit');
		$this->db->from('tb_pegawai');
		$this->db->join('tb_jabatan','tb_jabatan.id = tb_pegawai.id_jabatan', 'left');
		$this->db->join('tb_unit','tb_unit.id = tb_pegawai.id_unit', 'left');
		$this->db->where('tb_jabatan.kode', 'KALAB');
		$query = $this->db->get();
		return $query->row();
	}

	public function getDetail($kode_surat){
		$this->db->select('a.*,b.jenis_sample, b.jml_sample, c.jenis_analisa, d.metode_analisa');
		$this->db->from('tb_detail_permohonan a');
		$this->db->join('tb_permohonan b','b.id = a.id_permohonan', 'left');
		$this->db->join('tb_jenis_analisa c','c.id = a.id_jenis_analisa', 'left');
		$this->db->join('tb_metode_analisa d','d.id = a.id_metode_analisa', 'left');
		$this->db->where('a.surat_tugas', $kode_surat);
		$query = $this->db->get();
		return $query->row();
	}

	public function getDetailByNomor($nomor){
		$this->db->select('a.*,b.jenis_sample, b.jml_sample, c.jenis_analisa, d.metode_analisa');
		$this->db->from('tb_detail_permohonan a');
		$this->db->join('tb_permohonan b','b.id = a.id_permohonan', 'left');
		$this->db->join('tb_jenis_analisa c','c.id = a.id_jenis_analisa', 'left');
		$this->db->join('tb_metode_analisa d','d.id = a.id_metode_analisa', 'left');
		$this->db->where('a.selesai_tugas', $nomor);
		$query = $this->db->get();
		return $query->row();
	}

	public function getTotal($id){
		$this->db->select('SUM(tb_metode_analisa.harga) as total');
		$this->db->from('tb_detail_permohonan');
		$this->db->join('tb_metode_analisa','tb_metode_analisa.id = tb_detail_permohonan.id_metode_analisa', 'left');
		$this->db->where('tb_detail_permohonan.id_permohonan', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function updateBatchDetailPermohonan($data){
		
		try {
	        $this->db->trans_begin();
	        $this->db->update_batch('tb_detail_permohonan',$data, 'id');

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

	public function getDatapenawaran(){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer');  
       	$this->db->from('tb_permohonan');
       	$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
       	$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
       	// $this->db->where('tb_permohonan.status !=','7');  
       	$this->db->or_where('tb_permohonan.status =','2');  
       	$this->db->or_where('tb_permohonan.status =','3');  
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("tb_permohonan.no_permohonan", $_POST["search"]["value"]);  
            $this->db->like("tb_permohonan.jenis_sample", $_POST["search"]["value"]); 
       	}  
       	if(!empty($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']); 
            $this->db->order_by('tb_permohonan.update_at', 'DESC'); 
       	}  
       	else  
       	{  
            $this->db->order_by('tb_permohonan.update_at', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function getDatapesanan(){
		$this->db->select('tb_permohonan.*, tb_status.keterangan, tb_status.class_color, tb_customer.nama_customer');  
       	$this->db->from('tb_permohonan');
       	$this->db->join('tb_status','tb_status.status = tb_permohonan.status', 'left');
       	$this->db->join('tb_customer','tb_customer.id = tb_permohonan.id_customer', 'left');
       	// $this->db->where('tb_permohonan.status !=','7');  
       	$this->db->where('tb_permohonan.status >=','4');  
       	// $this->db->or_where('tb_permohonan.status =','3');  
       	if(!empty($_POST["search"]["value"]))  
       	{  
            $this->db->like("tb_permohonan.no_permohonan", $_POST["search"]["value"]);  
            $this->db->like("tb_permohonan.jenis_sample", $_POST["search"]["value"]); 
       	}  
       	if(!empty($_POST["order"]))  
       	{  
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']); 
            $this->db->order_by('tb_permohonan.update_at', 'DESC'); 
       	}  
       	else  
       	{  
            $this->db->order_by('tb_permohonan.update_at', 'DESC');  
       	}  
       	if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();
	}

	public function simpanBayar($data){
		try {
	        $this->db->trans_begin();
			$this->db->insert('tb_pembayaran',$data);
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

	public function dataBayar($id){
		$this->db->select('*');
		$this->db->from('tb_pembayaran');
		$this->db->where('id_permohonan', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getEkspedisi(){
		$this->db->select('*');
		$this->db->from('tb_ekspedisi');
		$query = $this->db->get()->result();
		return $query;
	}

	public function detailSample($id_permohonan, $no_sample){
		$this->db->select('tb_detail_sample.*');  
       	$this->db->from('tb_detail_sample');
       	$this->db->join('tb_detail_permohonan','tb_detail_permohonan.id_sampel = tb_detail_sample.id', 'left');
       	$this->db->where('tb_detail_permohonan.id_permohonan',$id_permohonan); 
       	$this->db->where('tb_detail_sample.no_sample',$no_sample); 
       	$this->db->group_by('tb_detail_permohonan.id_sampel');
       	$query = $this->db->get()->row();
		return $query;
	}

	public function getPermohonanID($no_blanko){
		$this->db->select('tb_detail_permohonan.*');  
       	$this->db->from('tb_detail_permohonan');
       	$this->db->join('tb_detail_sample','tb_detail_sample.id = tb_detail_permohonan.id_sampel', 'left');
       	$this->db->where('tb_detail_sample.no_blanko',$no_blanko); 
       	$this->db->group_by('tb_detail_sample.no_blanko');
       	$query = $this->db->get()->row();
		return $query;
	}

	public function getDaftarDocument($id){
		$this->db->select('*');
		$this->db->from('tb_daftar_dokumen');
		$this->db->where('id_permohonan', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function getDaftarDocByID($kode_document){
		$this->db->select('*');
		$this->db->from('tb_daftar_dokumen');
		$this->db->where('kode_dokumen', $kode_document);
		$query = $this->db->get();
		return $query->row();
	}
}