<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'base';
$route['login'] = 'auth';
$route['logout'] = 'auth/logout';
$route['upload'] = 'base/upload';
$route['upload/x20'] = 'base/x20';
$route['upload/chiperlab'] = 'base/chiperlab';
$route['laporan'] = 'base/laporan';
$route['laporan/diffx20'] = 'base/diffx20';
$route['laporan/laporandatauser'] = 'base/laporandatauser';
$route['laporan/laporandatahistoris'] = 'base/laporandatahistoris';
$route['laporan/rekapchiperlab'] = 'base/rekapchiperlab';
$route['laporan/laporanaudit'] = 'base/laporanaudit';
$route['laporan/laporanx20'] = 'base/laporanx20';
$route['closeaudit'] = 'base/closeaudit';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
