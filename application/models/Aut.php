<?php 
use GuzzleHttp\Client;
class Aut extends CI_Model { 
   private $client;
    function __construct(){
    parent::__construct();
    $this->client  = new GuzzleHttp\Client(['base_uri' => 'http://ops.ptscu.net/api/']);
    }
  public function usercek ($nik,$password){ 
    $this->db->select('nama,level,nik');
    $this->db->where('nik',$nik);
    $this->db->where('password',$password);
    $this->db->where('status','aktif');
    return $this->db->get('users');
   }
    public function posauditor($store,$tanggal,$pihak1,$pihak2,$status){ 
        $response = $this->client->request('POST','auditor',[
            'form_params'=>[
                'store'=>$store,
                'tanggal'=>$tanggal,
                'pihak_1'=>$pihak1,
                'pihak_2'=>$pihak2,
                'status'=>$status
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
       return $result;
     }
    public function posstock($store,$tanggal,$ean,$nama_store,$item_id,$waist,$inseam,$item_description,$category,$kelas,$subkelas,$bin,$onhand_qty,$onhand_scan,$status){ 
        $response = $this->client->request('POST','stockaudit',[
            'form_params'=>[
                'store'=>$store,
                'tanggal'=>$tanggal,
                'ean'=>$ean,
                'nama_store'=>$nama_store,
                'item_id'=>$item_id,
                'waist'=>$waist,
                'inseam'=>$inseam,
                'item_description'=>$item_description,
                'category'=>$category,
                'kelas'=>$kelas,
                'subkelas'=>$subkelas,
                'bin'=>$bin,
                'onhand_qty'=>$onhand_qty,
                'onhand_scan'=>$onhand_scan,
                'status'=>$status,
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
       return $result;
     }
 } 