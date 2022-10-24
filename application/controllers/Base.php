<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Base extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    cheknologin();
    $this->load->library('template');
  }
  public function index()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Home Base';
    $this->template->load('layouts/layout','page/index',$data);
  }
  public function upload()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Upload';
    $this->template->load('layouts/layout','page/upload',$data);
  }
  public function x20()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Upload';
    $this->template->load('layouts/layout','page/x20',$data);
  }
  public function chiperlab()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Upload';
    $this->template->load('layouts/layout','page/chiperlab',$data);
  }
  public function laporan()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
    $this->template->load('layouts/layout','page/laporan',$data);
  }
  public function rekapchiperlab()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
    $data['description'] = 'Laporan Rekap Chiperlab';
    $this->template->load('layouts/layout','laporan/rekapchiperlab',$data);
  }
  public function laporanx20()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
    $data['description'] = 'Laporan Hasil Upload X-20';
    $this->template->load('layouts/layout','laporan/laporanx20',$data);
  }
  public function diffx20()
  {
   
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
     $data['description'] = 'Laporan Diffrent Audit';
    $this->template->load('layouts/layout','laporan/diffx20',$data);
  }
  public function laporandatauser()
  {
   
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
     $data['description'] = 'Laporan Data User';
    $this->template->load('layouts/layout','laporan/laporandatauser',$data);
  }
  public function laporandatahistoris()
  {
   
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
     $data['description'] = 'Laporan Data Historis';
    $this->template->load('layouts/layout','laporan/laporandatahistoris',$data);
  }
  public function laporanaudit()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Laporan';
    $this->template->load('layouts/layout','laporan/laporanaudit',$data);
  }
  public function closeaudit()
  {
    $data['store'] =  $this->session->userdata('storename');
    $data['title'] = 'Close Audit';
    $data['description'] = 'Close Audit / Tanda Tangan Digital';
    $this->template->load('layouts/layout','page/user',$data);
  }
}
