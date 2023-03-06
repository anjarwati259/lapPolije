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
        $user = $this->CI->user_model->getUser($check->id);
        if($user['status'] == 'success'){
          $this->CI->session->set_userdata('id_user',$user['id_user']);
          $this->CI->session->set_userdata('nama_user',$user['nama']);
          $this->CI->session->set_userdata('id',$user['id']);
          $this->CI->session->set_userdata('username',$user['username']);
          $this->CI->session->set_userdata('hak_akses',$user['hak_akses']);
        }else{
          $this->CI->session->set_flashdata('error','Anda Tidak Memiliki Akses');
          redirect(base_url('login'),'refresh');
        }
      //redirect ke halaman admin yang diproteksi
      if($user['hak_akses']=='1'){
        redirect(base_url('admin'),'refresh');
      }else  if($user['hak_akses']=='2'){
        redirect(base_url('analist'),'refresh');
      }else  if($user['hak_akses']=='3'){
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