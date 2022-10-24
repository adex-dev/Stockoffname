<?php
function cheknologin()
{
  $ci = &get_instance();
  $user_sesi = $ci->session->userdata('nama');
  if ($user_sesi == null) {
    redirect('logout');
  }
}
function login()
{
  $ci = &get_instance();
  $user_sesi = $ci->session->userdata('nama');
  if ($user_sesi) {
    redirect('');
  }
}
