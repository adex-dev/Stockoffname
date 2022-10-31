<?php
class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array('aut'));
  }
  public function index()
  {
    $data['store'] = $this->db->order_by('nama_store', 'ASC')->get('prm_store')->result();
    $this->load->view('login', $data);
  }
  public function loginproses()
  {
    if ($this->input->post()) {
      $storelogin = $this->input->post('storelogin', true);
      $nik = $this->input->post('niklogin', true);
      $password = md5($this->input->post('passwordlogin', true));
      $cek = $this->aut->usercek($nik, $password);
      if ($cek->num_rows() > 0) {
        $storename = $this->db->select('nama_store')->where('kode_store', $storelogin)->get('prm_store')->row()->nama_store;
        $seslog = ['nama' => $cek->row()->nama, 'level' => $cek->row()->level, 'storename' => $storename, 'nik' => $nik];
        $this->session->set_userdata($seslog);
        $msg = ['sukses' => 'Login Berhasil'];
      } else {
        $msg = ['gagal' => 'Nik atau Password Salah atau User Sudah tidak aktif'];
      }
      echo json_encode($msg);
    }
  }
  public function logout()
  {
    $this->session->sess_destroy();
    $this->load->view('logout');
  }
  public function syncronizeuser()
  {
    $connected = @fsockopen('www.inventory.ptscu.net', 80);
    $is_conn = '';
    if ($connected) {
      $apikey = file_get_contents("http://ops.ptscu.net/api/alluser");

      $apikeyuser = json_decode($apikey);
      foreach ($apikeyuser as $value) {
        if ($this->db->get_where('users', ['nik' => $value->nik])->num_rows() > 0) {
          $sukses = $this->db->update('users', ['nik' => $value->nik, 'nama' => $value->nama, 'password' => $value->password, 'status' => $value->status, 'level' => $value->level], ['nik' => $value->nik]);
        } else {
          $sukses = $this->db->insert('users', ['nik' => $value->nik, 'nama' => $value->nama, 'password' => $value->password, 'status' => $value->status, 'level' => $value->level]);
        }
      }
      if ($sukses) {
        $msg = ['sukses' => 'Success Added User'];
      } else {
        $msg = ['gagal' => 'Failed Added User'];
      }
      fclose($connected);
    } else {
      $msg = ['gagal' => 'Please Check Your Internet Connection'];
      $is_conn = false;
    }
    echo json_encode($msg);
    return $is_conn;
  }
  public function ambildataserverstore()
  {
    $connected = @fsockopen('www.inventory.ptscu.net', 80);
    $is_conn = '';
    if ($connected) {
      $apikey = file_get_contents("http://ops.ptscu.net/api/allstore");

      $apikeystore = json_decode($apikey);
      foreach ($apikeystore as $value) {
        if ($this->db->get_where('prm_store', ['kode_store' => $value->kode_store])->num_rows() > 0) {
          $sukses = $this->db->update('prm_store', ['kode_store' => $value->kode_store, 'nama_store' => $value->nama_store], ['kode_store' => $value->kode_store]);
        } else {
          $sukses = $this->db->insert('prm_store', ['kode_store' => $value->kode_store, 'nama_store' => $value->nama_store]);
        }
      }
      if ($sukses) {
        $msg = ['sukses' => 'Success Added Store'];
      } else {
        $msg = ['gagal' => 'Failed Added Store'];
      }
      fclose($connected);
    } else {
      $msg = ['gagal' => 'Please Check Your Internet Connection'];
      $is_conn = false;
    }
    echo json_encode($msg);
    return $is_conn;
  }
  function tes()
  {
    $this->load->library('ftp');
    $ftp_config['hostname'] = 'ftp.ptscu.net';
    $ftp_config['username'] = 'adex@ptscu.net';
    $ftp_config['password'] = '@qaz741852963';
    $ftp_config['port']     = 21;
    $ftp_config['passive']  = TRUE;
    $ftp_config['debug']    = TRUE;
    //cycle through
    $newImageName = 'uploadBackup.sql';
    $source = 'src/bundle/upload/' . $newImageName;
    $this->ftp->connect($ftp_config);
    $destination = '/ops.ptscu.net/content/upload/' . $newImageName;
    $sukses = $this->ftp->upload($source, $destination, 'ascii', 0775);
    if ($sukses) {
      echo "<script>alert('DATA BERHASIL DIBUAT')</script>";
      // $msg = ['respon' => '200', 'messages' => 'Berhasil Di Kirim'];
      $this->ftp->close();
    }
  }
}
