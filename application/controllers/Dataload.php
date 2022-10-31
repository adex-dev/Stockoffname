<?php
class Dataload extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('upload');
    cheknologin();
    $this->load->model(array('datarest', 'aut'));
    $this->load->library('ftp');
  }
  public function datax20()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);;
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cektada = $this->datarest->diffrent($tgl, $store, $search);
    $respon = '';
    $totalonhanqty = 0;
    if ($cektada->num_rows() > 0) {
      foreach ($cektada->result() as $value) {
        $totalonhanqty += $value->onhand_qty;
        $respon .= ' <tr>
                <td>' . $value->ean . '</td>
                <td>' . $value->item_description . '</td>
                <td>' . $value->item_id . '</td>
                <td>' . $value->waist . '</td>
                <td>' . $value->inseam . '</td>
                <td>' . $value->onhand_qty . '</td>
              </tr>';
      }
    } else {
      $respon = ' <tr><td colspan="8" class="text-center">Tidak Ada data</td></tr>';
    }
    $total = ' <tr><td colspan="5">Total</td><td>' . $totalonhanqty . '</td></tr>';
    $msg = ['respon' => $respon, 'Total' => $total];
    echo json_encode($msg);
  }
  public function cekstatus()
  {
    if ($this->input->post()) {
      header('Content-Type: application/json');
      $tgl = $this->input->post('tgl', true);
      $store = $this->input->post('store', true);
      $a = $this->db->select('status_audit,pihak_2')->where(['periode_audit' => $tgl, 'kode_store' => $store])->get('prm_auditor');
      $status = '';
      $b = '';
      if ($a->num_rows() > 0) {
        $status = $a->row()->status_audit;
        if ($a->row()->status_audit == 'BELUM SELESAI') {
          $b = $a->row()->status_audit;
        } else {
          $b = $a->row()->pihak_2;
        }
      } else {
        $status = 'Belum Di Audit';
        $b = 'Belum Di Audit';
      }
      $msg = ['respon' => $status, 'pengaudit' => $b];
      echo json_encode($msg);
    }
  }
  public function datalaporanaudit()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);;
    $store = $this->input->post('store', true);;
    $cektada =  $search = $this->input->post('search', true);
    $cektada = $this->datarest->diffrent($tgl, $store, $search);
    $respon = '';
    $totalonhanqty = 0;
    $totalonhanscan = 0;
    $totaldiff = 0;
    if ($cektada->num_rows() > 0) {
      foreach ($cektada->result() as $value) {
        $diffrent = (int) $value->onhand_scan - (int) $value->onhand_qty;
        $totalonhanqty += $value->onhand_qty;
        $totalonhanscan += $value->onhand_scan;
        $totaldiff += $diffrent;
        $respon .= ' <tr>
                <td>' . $value->ean . '</td>
                <td>' . $value->item_description . '</td>
                <td>' . $value->item_id . '</td>
                <td>' . $value->waist . '</td>
                <td>' . $value->inseam . '</td>
                <td>' . $value->onhand_qty . '</td>
                <td>' . $value->onhand_scan . '</td>
                <td>' . $diffrent . '</td>
              </tr>';
      }
    } else {
      $respon = ' <tr><td colspan="8" class="text-center">Tidak Ada data</td></tr>';
    }
    $total = '<tr><td colspan="5">Total</td><td>' . $totalonhanqty . '</td><td>' . $totalonhanscan . '</td><td>' . $totaldiff . '</td></tr>';
    $msg = ['respon' => $respon, 'Total' => $total];
    echo json_encode($msg);
  }
  public function datadummychiperlab()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $cektada = $this->db->select('ean,flor,onhand_scan')->where(['tanggal' => $tgl, 'kode_store' => $store])->order_by('ean', 'ASC')->get('dummydata')->result();
    $respon = '';
    $totaldiff = 0;
    $No = 1;
    foreach ($cektada as $value) {
      $totaldiff += $value->onhand_scan;
      $respon .= ' <tr>
                <td>' . $No++ . '</td>
                <td>' . $value->ean . '</td>
                <td>' . $value->onhand_scan . '</td>
                <td>' . $value->flor . '</td>
              </tr>';
    }
    $total = '<tr><td colspan="2">Total</td><td>' . $totaldiff . '</td><td></td></tr>';
    $msg = ['respon' => $respon, 'Total' => $total];
    echo json_encode($msg);
  }
  public function suminventoris()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $totalsemuadata = $this->db->select_sum('onganscan')->where(['tanggal' => $tgl, 'kode_store' => $store])->get('inventorisdata')->row()->onganscan;
    $msg = ['respon' => $totalsemuadata];
    echo json_encode($msg);
  }
  public function datalaporandiffrent()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cektada = $this->datarest->diffrent($tgl, $store, $search);
    $respon = '';
    $totalonhanqty = 0;
    $totalonhanscan = 0;
    $totaldiff = 0;
    if ($cektada->num_rows() > 0) {
      foreach ($cektada->result() as $value) {
        $diffrent = (int) $value->onhand_scan - (int) $value->onhand_qty;
        if ($diffrent != 0) {
          $totalonhanqty += $value->onhand_qty;
          $totalonhanscan += $value->onhand_scan;
          $totaldiff += $diffrent;
          $respon .= ' <tr>
                <td>' . $value->ean . '</td>
                <td>' . $value->item_description . '</td>
                <td>' . $value->item_id . '</td>
                <td>' . $value->waist . '</td>
                <td>' . $value->inseam . '</td>
                <td>' . $value->onhand_qty . '</td>
                <td>' . $value->onhand_scan . '</td>
                <td>' . $diffrent . '</td>
              </tr>';
        }
      }
    } else {
      $respon = ' <tr><td colspan="8" class="text-center">Tidak Ada data</td></tr>';
    }
    $total = '<tr><td colspan="5">Total</td><td>' . $totalonhanqty . '</td><td>' . $totalonhanscan . '</td><td>' . $totaldiff . '</td></tr>';
    $msg = ['respon' => $respon, 'Total' => $total];
    echo json_encode($msg);
  }
  public function laporanchiperlab()
  {
    header('Content-Type: application/json');
    $tgl = $this->input->post('tgl', true);
    $store = $this->input->post('store', true);
    $search = $this->input->post('search', true);
    $cektada = $this->datarest->datachiperlab($tgl, $store, $search)->result();
    $respon = '';
    $no = 1;
    foreach ($cektada as $value) {
      $respon .= ' <tr>
                <td>' . $no++ . '</td>
                <td>' . $value->ean . '</td>
                <td>' . $value->item_id . '</td>
                <td>' . strtoupper($value->flor) . '</td>
                <td>' . $value->onganscan . '</td>
                <td>' . $value->nama . '</td>
              </tr>';
    }
    $msg = ['respon' => $respon, 'Total' => '.'];
    echo json_encode($msg);
  }
  public function laporanuser()
  {
    if ($this->input->post()) :
      header('Content-Type: application/json');
      $cektada = $this->datarest->datauser()->result();
      $respon = '';
      $no = 1;
      foreach ($cektada as $value) {
        $respon .= ' <tr>
                <td>' . $no++ . '</td>
                <td>' . $value->nik . '</td>
                <td>' . strtoupper($value->nama) . '</td>
                <td>' . $value->level . '</td>
                <td>' . $value->status . '</td>
              </tr>';
      }
      $msg = ['respon' => $respon, 'Total' => '.'];
      echo json_encode($msg);
    endif;
  }
  public function laporanhistoris()
  {
    if ($this->input->post()) :
      header('Content-Type: application/json');
      $search = $this->input->post('search', true);
      $cektada = $this->datarest->datahistoris($search)->result();
      $respon = '';
      $no = 1;
      foreach ($cektada as $value) {
        $respon .= ' <tr>
                <td>' . $no++ . '</td>
                <td>' . $value->periode_audit . '</td>
                <td>' . $value->nama_store . '</td>
                <td>' . strtoupper($value->nama) . '</td>
                <td>' . strtoupper($value->pihak_2) . '</td>
                <td>' . $value->status_audit . '</td>
              </tr>';
      }
      $msg = ['respon' => $respon, 'Total' => '.'];
      echo json_encode($msg);
    endif;
  }
  public function downloadsampel()
  {
    switch ($this->input->post('request', true)) {
      case "download":

        // Get parameters
        $file = $this->input->post('download', true);
        $filepath = "src/bundle/sampel/" . $file;

        if (file_exists($filepath)) {
          $msg = ['respon' => 'File Berhasil ' . $file . ' Di download'];
        } else {
          $msg = ['respon' => 'No file data'];
        }
        echo json_encode($msg);
        break;
      default:
        echo "No request was made";
    }
  }
  public function uploadfilex20()
  {
    if ($this->input->post()) {
      $tanggal = $this->input->post('tanggal', true);
      $store = $this->input->post('store', true);
      $cek = $this->db->get_where('prm_auditor', ['periode_audit' => $tanggal, 'kode_store' => $store]);
      if ($cek->num_rows() > 0) {
        $msg = ['gagal' => 'Sudah Pernah Diupload'];
      } else {
        $config['upload_path'] = './src/bundle/upload/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 10000;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('namafile')) {
          $error = array('error' => $this->upload->display_errors());
          $cek = implode('', $error);
          $msg = ['gagal' => $cek];
        } else {
          $sukses = '';
          $images = $this->upload->data();
          $imagess = $images['file_name'];
          $file_data = fopen("./src/bundle/upload/" . $imagess, 'r');
          fgetcsv($file_data);
          while (($row = fgetcsv($file_data, 1000, ",")) !== FALSE) {
            $insert_data = array(
              'periode' => $tanggal,
              'kode_store' => trim($row['0']),
              'nama_store' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['1'])),
              'item_id' => trim($row['2']),
              'waist' => trim($row['3']),
              'inseam' => trim($row['4']),
              'item_description' => preg_replace('/[@\.\;\'\?\™\|\®\©\™\®\"\/\,\(\)\']+/', '', trim($row['5'])),
              'ean' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['6'])),
              'brand' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['7'])),
              'category' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['8'])),
              'kelas' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['9'])),
              'subkelas' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['10'])),
              'bin' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['11'])),
              'onhand_qty' => preg_replace('/[@\.\;\'\"\/\,\(\)\']+/', '', trim($row['12'])),
              'onhand_scan' => '0',
              'status' => 'BELUM',
            );
            $datawhere = [
              'periode' => $tanggal,
              'ean' => trim($row['6']),
              'kode_store' => trim($row['0'])
            ];
            $datawhere2 = [
              'periode' => $tanggal,
              'kode_store' => trim($row['0']),
              'item_id' => trim($row['2']),
            ];
            if (trim($row['0']) == $store) {
              if (empty(trim($row['6']))) {
                $cek1 = $this->db->get_where('prm_stock', $datawhere2);
                if ($cek1->num_rows() > 0) {
                  $qty1 = (int) $cek1->row()->onhand_qty + (int) trim($row['12']);
                  $this->db->update('prm_stock', ['onhand_qty' => $qty1], $datawhere2);
                } else {
                  $this->db->insert('prm_stock', $insert_data);
                  $sukses = 'Berhasil Di Upload';
                }
              } else {
                $cek2 = $this->db->get_where('prm_stock', $datawhere);
                if ($cek2->num_rows() > 0) {
                  $qty2 = (int) $cek2->row()->onhand_qty + (int) trim($row['12']);
                  $this->db->update('prm_stock', ['onhand_qty' => $qty2], $datawhere);
                } else {
                  $this->db->insert('prm_stock', $insert_data);
                  $sukses = 'Berhasil Di Upload';
                }
              }
            } else {
              $gagal = 'Store Tidak sama dengan Data';
            }
          }
          if ($sukses) {
            $connected = @fsockopen('www.inventory.ptscu.net', 80);
            if ($connected) {
              $apikey = file_get_contents("http://ops.ptscu.net/api/getaudit");
              $apikeystore = json_decode($apikey);
              foreach ($apikeystore as $value) {
                $cek = $this->db->get_where('prm_auditor', ['kode_store' => $value->kode_store, 'periode_audit' => $value->periode_audit, 'status_audit' == 'SELESAI']);
                if ($cek->num_rows() > 0) {
                  $this->db->update('prm_auditor', ['kode_store' => $value->kode_store, 'periode_audit' => $value->periode_audit, 'pihak_1' => $value->pihak_1, 'pihak_2' => $value->pihak_2, 'status_audit' => $value->status_audit], ['kode_store' => $value->kode_store, 'periode_audit' => $value->periode_audit, 'status_audit' => 'SELESAI']);
                } else {
                  $this->db->insert('prm_auditor', ['kode_store' => $value->kode_store, 'periode_audit' => $value->periode_audit, 'pihak_1' => $value->pihak_1, 'pihak_2' => $value->pihak_2, 'status_audit' => $value->status_audit]);
                }
              }
              fclose($connected);
            }

            $cek = $this->db->get_where('prm_auditor', ['periode_audit' => $tanggal, 'kode_store' => $store]);
            if ($cek->num_rows() > 0) {
            } else {
              $this->db->insert('prm_auditor', ['periode_audit' => $tanggal, 'kode_store' => $store, 'pihak_1' => $this->session->userdata('nik'), 'pihak_2' => '', 'status_audit' => 'BELUM SELESAI']);
            }
            $msg = ['sukses' => $sukses];
          } else if ($gagal) {
            $msg = ['gagal' => $gagal];
          } else {
            $msg = ['sukses' => $sukses];
          }
        }
      }
      echo json_encode($msg);
    }
  }
  public function uploadchiperlab()
  {
    if ($this->input->post()) {
      $tanggal = $this->input->post('tanggal', true);
      $store = $this->input->post('store', true);
      $flor = $this->input->post('namaflor', true);
      $nik = $this->session->userdata('nik');
      if (empty($flor)) {
        $msg = ['gagal' => 'Anda Harus Memilih Rak Terlebih dahulu'];
      } else {
        $config['upload_path'] = './src/bundle/upload/';
        $config['allowed_types'] = 'txt';
        $config['max_size'] = 10000;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('namafile')) {
          $error = array('error' => $this->upload->display_errors());
          $cek = implode('', $error);
          $msg = ['gagal' => 'Only Accepts txt Files'];
        } else {
          $ceki = $this->db->get_where('prm_auditor', ['periode_audit' => $tanggal, 'kode_store' => $store]);
          if ($ceki->num_rows() > 0) {
            if ($ceki->row()->status_audit == 'BELUM SELESAI') {
              $images = $this->upload->data();
              $imagess = $images['file_name'];
              $file_data = fopen("./src/bundle/upload/" . $imagess, 'r');
              $this->db->delete('dummydata', ['kode_store' => $store]);
              while (!feof($file_data)) {
                $content = fgets($file_data);
                $row = explode(',', $content);
                if (!empty($row[0])) {
                  $where = ['tanggal' => $tanggal, 'kode_store' => $store, 'nik' => $nik, 'flor' => $flor, 'ean' => trim($row[0])];
                  $wherestok = ['periode' => $tanggal, 'kode_store' => $store, 'ean' => trim($row[0])];
                  $cek = $this->db->get_where('dummydata', $where);
                  $cek2 = $this->db->get_where('inventorisdata', $where);
                  $stok = $this->db->get_where('prm_stock', $wherestok);
                  // inventoris
                  if ($cek2->num_rows() > 0) {
                    $b = $cek2->row()->onganscan + 1;
                    $this->db->update('inventorisdata', ['onganscan' => $b], $where);
                  } else {
                    $insert_data2 = ['tanggal' => $tanggal, 'kode_store' => $store, 'nik' => $nik, 'flor' => $flor, 'ean' => trim($row[0]), 'onganscan' => '1'];
                    $this->db->insert('inventorisdata', $insert_data2);
                  };
                  //prm stok
                  if ($stok->num_rows() > 0) {
                    $b = (int) $stok->row()->onhand_scan + 1;
                    $this->db->update('prm_stock', ['onhand_scan' => $b], ['periode' => $tanggal, 'kode_store' => $store, 'ean' => trim($row[0])]);
                  } else {
                    $this->db->insert('prm_stock', ['periode' => $tanggal, 'kode_store' => $store, 'ean' => trim($row[0]), 'nama_store' => $this->session->userdata('storename'), 'onhand_scan' => '1']);
                  };
                  // dummy data
                  if ($cek->num_rows() > 0) {
                    $a = $cek->row()->onhand_scan + 1;
                    $sukses = $this->db->update('dummydata', ['onhand_scan' => $a], $where);
                  } else {
                    $sukses = $this->db->insert('dummydata', ['tanggal' => $tanggal, 'nik' => $nik, 'kode_store' => $store, 'ean' => trim($row[0]), 'flor' => $flor, 'onhand_scan' => '1']);
                  }
                }
              }
              if ($sukses) {
                $msg = ['sukses' => 'Success Added Data'];
              }
            } else {
              $msg = ['gagal' => 'Data Sudah Pernah Di audit'];
            }
          } else {
            $msg = ['gagal' => 'Anda Harus Membuat Data Audit Terlebih Dahulu'];
          }
        }
      }
      echo json_encode($msg);
    }
  }

  public function hapusfile()
  {
    $dir = './src/bundle/upload/';
    array_map('unlink', glob("{$dir}*.*"));
    $msg = 'ok';
    echo json_encode($msg);
  }
  public function closeaudit()
  {
    if ($this->input->post()) {
      $tgl = $this->input->post('tgl', true);
      $store = $this->input->post('store', true);
      $staf = strtoupper($this->input->post('staf', true));
      $nik = $this->session->userdata('nik');
      $cek =  $this->datarest->cekcloseaudit($tgl, $store);
      if ($cek->num_rows() > 0) {
        if ($cek->row()->status_audit == 'BELUM SELESAI') {
          $this->datarest->updateclosaudit($tgl, $store, $staf, $nik);
          $sukses = $this->datarest->closestok($tgl, $store);
          if ($sukses) {
            $result = $this->db->get_where('prm_auditor', ['periode_audit' => $tgl, 'status_audit' => 'SELESAI', 'kode_store' => $store]);
            $number = $result->num_rows();
            $return = "\\n";
            if ($number > 0) {
              foreach ($result->result() as $value) {
                $return .=  'INSERT INTO prm_auditor  VALUES ' . '("' . $value->periode_audit . '","' . $value->kode_store . '","' . $value->pihak_1 . '","' . $value->pihak_2 . '","' . $value->status_audit . '"); \\n';
              }
            }
            $inventorisdata = $this->db->get_where('inventorisdata', ['tanggal' => $tgl, 'kode_store' => $store]);
            if ($inventorisdata->num_rows() > 0) {
              foreach ($inventorisdata->result() as $value) {
                $return .=  'INSERT INTO inventorisdata  VALUES ' . '("' . $value->ean . '","' . $value->tanggal . '","' . $value->kode_store . '","' . $value->flor . '","' . $value->onganscan . '","' . $value->nik . '"); \\n';
              }
            }

            $prm_stock = $this->db->get_where('prm_stock', ['periode' => $tgl, 'kode_store' => $store]);
            if ($prm_stock->num_rows() > 0) {
              foreach ($prm_stock->result() as $value) {
                $return .=  'INSERT INTO prm_stock  VALUES ' . '("' . $value->periode . '","' . $value->ean . '","' . $value->kode_store . '","' . $value->nama_store . '","' . $value->item_id . '","' . $value->waist . '","' . $value->inseam . '","' . $value->item_description . '","' . $value->brand . '","' . $value->category . '","' . $value->kelas . '","' . $value->subkelas . '","' . $value->bin . '","' . $value->onhand_qty . '","' . $value->onhand_scan . '","' . $value->status . '"); \\n';
              }
            }
            $data = str_replace("\\n", "\r", $return);
            $fileName = './src/bundle/upload/' . $store . $tgl . '.sql';
            $handle = fopen($fileName, 'w+');
            fwrite($handle, $data);
            if (fclose($handle)) {
              $msg = ['sukses' => 'Audit Periode ' . $tgl . ' Berhasil DI selesaikan'];
            }
          }
        } else {
          $msg = ['gagal' => 'Audit Periode ' . $tgl . ' Sudah DI selesaikan'];
        }
      } else {
        $msg = ['gagal' => 'Anda Belum Membuat Jadwal Audit Periode ' . $tgl];
      }
      echo json_encode($msg);
    }
  }
  public function postserveronline()
  {
    header('Content-Type: application/json');
    if ($this->input->post()) {
      $store = $this->input->post('store', true);
      $tanggal = $this->input->post('tanggal', true);
      $rs = $this->db->get_where('prm_auditor', ['periode_audit' => $tanggal, 'kode_store' => $store]);
      if ($rs->num_rows() > 0) {
        $pihak_1 = $rs->row()->pihak_1;
        $pihak_2 = $rs->row()->pihak_2;
        $status = $rs->row()->status_audit;
        $cek = $this->aut->posauditor($store,$tanggal, $pihak_1,$pihak_2,$status);
        if ($cek['respon'] == '404') {
          $msg = ['respon' => '404', 'messages' => $cek['message']];
        } else if ($cek['respon'] == '200') {
          // $ftp_config['hostname'] = 'ftp.ptscu.net';
          // $ftp_config['username'] = 'adex@ptscu.net';
          // $ftp_config['password'] = '@qaz741852963';
          $ftp_config['port']     = 21;
          $ftp_config['passive']  = FALSE;
          $ftp_config['debug']    = TRUE;
          //cycle through
          $newImageName =$store.$tanggal.'.sql';
          $source = 'src/bundle/upload/' . $newImageName;
          $this->ftp->connect($ftp_config);
          $destination = '/ops.ptscu.net/content/upload/'.$newImageName;
          $sukses = $this->ftp->upload($source,$destination, 'ascii', 0775);
          if ($sukses) {
            $this->ftp->close();
            $cek2 = $this->aut->posstock($store,$tanggal);
            if ($cek2['respon'] == '404') {
              $msg = ['respon' => '404', 'messages' => $cek2['message']];
            } else if ($cek2['respon'] == '200') {
              $filename =$store.$tanggal.'.sql';
              if (file_exists("./src/bundle/upload/" . $filename)) {
                unlink("./src/bundle/upload/" . $filename);
              }
              $msg = ['respon' => '200', 'messages' => 'Berhasil Di Kirim'];
              $this->ftp->close();
            }
          }
        }
      } else {
        $msg = ['respon' => '404', 'messages' => 'Sudah Di Audit !'];
      }
    } else {
      $msg = "access denied";
    }
    echo json_encode($msg);
  }
}
