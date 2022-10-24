<?php
class Datarest extends CI_Model
{
  var $chiperlabrekap = 'inventorisdata';
  var $user = 'users';
  var $audit = 'prm_auditor';

  public function datachiperlab($tgl, $store,$search=null)
  {
    $this->db->select('prm_stock.item_id,prm_stock.ean,users.nama,inventorisdata.flor,inventorisdata.onganscan');
    $this->db->join('prm_stock', 'prm_stock.ean=inventorisdata.ean');
    $this->db->join('users', 'users.nik=inventorisdata.nik');
    if ($search != null) {
      $this->db->like('prm_stock.ean', $search);
      $this->db->or_like('prm_stock.item_id', $search);
      $this->db->or_like('inventorisdata.flor', $search);
    };
    $this->db->where('inventorisdata.tanggal', $tgl);
    $this->db->where('inventorisdata.kode_store', $store);
    $this->db->order_by('prm_stock.item_id', 'DESC');
    return $this->db->get($this->chiperlabrekap);
  }
  public function datauser()
  {
    $this->db->select('nik,nama,status,level');
    $this->db->order_by('level', 'ASC');
    return $this->db->get($this->user);
  }
  public function datahistoris($search=null)
  {
    $this->db->select('prm_auditor.periode_audit,prm_auditor.pihak_2,prm_auditor.status_audit,users.nama,prm_store.nama_store');
     if ($search != null) {
      $this->db->like('prm_auditor.periode_audit', $search);
      $this->db->or_like('users.nama', $search);
      $this->db->or_like('prm_store.nama_store', $search);
    };
    $this->db->join('prm_store', 'prm_store.kode_store=prm_auditor.kode_store');
    $this->db->join('users', 'users.nik=prm_auditor.pihak_1');
    $this->db->order_by('prm_auditor.periode_audit','ASC');
    return $this->db->get($this->audit);
  }
  public function cekaudit($tgl, $store)
  { 
    $this->db->select('prm_auditor.pihak_2,prm_auditor.status_audit,users.nama');
    $this->db->join('users','users.nik=prm_auditor.pihak_1');
    $this->db->where(['prm_auditor.periode_audit'=>$tgl,'prm_auditor.kode_store'=>$store]);
    return $this->db->get('prm_auditor');
   }
  public function exceldifrent($tgl,$store,$search=null)
  {
    $this->db->select('ean,item_description,item_id,waist,inseam,onhand_qty,onhand_scan,status');
    if ($search != null) {
      $this->db->like('ean', $search);
      $this->db->or_like('item_id', $search);
    };
    $this->db->where(['periode' => $tgl, 'kode_store' => $store]);
    $this->db->order_by('item_id', 'ASC');
    return $this->db->get('prm_stock');
  }
  public function diffrent($tgl, $store, $search = null)
  {
    $this->db->select('ean,item_description,item_id,waist,inseam,onhand_qty,onhand_scan,status');
    if ($search != null) {
      $this->db->like('ean', $search);
      $this->db->or_like('item_id', $search);
    };
    $this->db->where(['periode' => $tgl, 'kode_store' => $store]);
    $this->db->order_by('item_id', 'ASC');
    return $this->db->get('prm_stock');
  }
  public function cekcloseaudit($tgl,$store){ 
    $this->db->where(['periode_audit'=>$tgl,'kode_store'=>$store]);
    return $this->db->get('prm_auditor');
   }
   public function updateclosaudit($tgl,$store,$staf,$nik){ 
    return $this->db->update('prm_auditor',['pihak_2'=>$staf,'pihak_1'=>$nik,'status_audit'=>'SELESAI'],['periode_audit'=>$tgl,'kode_store'=>$store]);
    }
   public function closestok($tgl,$store){ 
    return $this->db->update('prm_stock',['status'=>'SELESAI'],['periode'=>$tgl,'kode_store'=>$store]);
    }
}
