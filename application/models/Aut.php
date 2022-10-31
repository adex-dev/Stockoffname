<?php

use GuzzleHttp\Client;

class Aut extends CI_Model
{
    private $client;
    function __construct()
    {
        parent::__construct();
        $this->client  = new GuzzleHttp\Client(['base_uri' => 'http://ops.ptscu.net/api/']);
    }
    public function usercek($nik, $password)
    {
        $this->db->select('nama,level,nik');
        $this->db->where('nik', $nik);
        $this->db->where('password', $password);
        $this->db->where('status', 'aktif');
        return $this->db->get('users');
    }
    public function posauditor($store, $tanggal)
    {
        $response = $this->client->request('POST', 'auditor', [
            'form_params' => [
                'store' => $store,
                'tanggal' => $tanggal
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
    public function posstock($store, $tanggal)
    {
        $response = $this->client->request('POST', 'stockaudit', [
            'form_params' => [
                'store' => $store,
                'tanggal' => $tanggal
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
}
