<?php 
/**
 * 
 */
class Simple_login
{
  protected $CI;

  public function __construct()
  {
    $this->CI =& get_instance();
    //load data model user
    $this->CI->load->model('user_model');
  }

  //fungsi login
  public function login($username, $password)
  {
      $check = $this->CI->user_model->login($username, $password);
      //jika ada data user, maka create session login
      if($check){
    
      $id_user  = $check->id;
      // $nama_user  = $check->nama;
      // $nip  = $check->nip;
      $hak_akses  = $check->hak_akses;
      //create session
      $this->CI->session->set_userdata('id_user',$id_user);
      // $this->CI->session->set_userdata('nama',$nama_user);
      // $this->CI->session->set_userdata('nip',$nip);
      $this->CI->session->set_userdata('username',$username);
      $this->CI->session->set_userdata('hak_akses',$hak_akses);
      //redirect ke halaman admin yang diproteksi
      if($hak_akses=='1'){
        redirect(base_url('admin'),'refresh');
      }else  if($hak_akses=='2'){
        redirect(base_url('analist'),'refresh');
      }else  if($hak_akses=='3'){
        redirect(base_url('customer'),'refresh');
      }
    }else{
      //kalau tidak ada, maka suruh login lagi
      $this->CI->session->set_flashdata('error','Username atau password salah');
      redirect(base_url('login'),'refresh');
    }
  }

  //fungsi cek login
  public function cek_login()
  {
    //memeriksa apakah session sudah atau belum, jika belum alihkan ke halaman login
    if($this->CI->session->userdata('username')==""){
      $this->CI->session->set_flashdata('error','Anda belum login');
      redirect(base_url('login'),'refresh');
    }
  }
  //fungsi cek hak akses
  public function admin()
  {
    //memeriksa apakah session sudah atau belum, jika belum alihkan ke halaman login
    if($this->CI->session->userdata('hak_akses')!="1"){
      $this->CI->session->set_flashdata('warning','Anda Tidak Memiliki Akses');
      redirect(base_url('login'),'refresh');
      //echo "anda tidak memiliki akses";
    }
  }
  //fungsi logout
  public function logout()
  {
    //membuang semua session yang telah diset pada saat login
    $this->CI->session->unset_userdata('id_user');
    $this->CI->session->unset_userdata('nama');
    $this->CI->session->unset_userdata('username');
    $this->CI->session->unset_userdata('akses_level');
    //setelah session dibuang, maka redirect ke login
    $this->CI->session->set_flashdata('sukses','Anda berhasil logout');
    redirect(base_url('login'),'refresh');
  }
}