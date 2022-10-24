<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= base_url() ?>src/bundle/favicon/favicon.ico" />
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/bt/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/sw/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/select2/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/bundle/icon/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>src/vendor/bttime/jquery.datetimepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/dist/css/style.css">
  <title><?= $title ?></title>
  <script>
    var hostname = '<?= base_url() ?>';
    var segment = '<?= $this->uri->segment('2') ?>';
    var segment1 = '<?= $this->uri->segment('1') ?>';
  </script>
  <script src="<?= base_url() ?>src/vendor/jquery/jquery-3.6.0.min.js"></script>
  <?php $uri = $this->uri->segment('1'); ?>

</head>
<?php 
 $class='';
switch ($uri) {
  case 'upload':
   $class = 'b4';
    break;
  
  case 'closeaudit':
   $class = 'b5';
    break;
  case 'laporan':
   $class = 'b6';
    break;
  
  default:
  $class = 'bg';
    break;
} ?>
<body class="<?= $class ?>">
  <nav id="navbar_top" class="navbar navbar-expand-lg bg-light" style="background: #9db4ddfa !IMPORTANT;">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <img src="<?= base_url() ?>src/bundle/logo/wp.png" alt="Jaygee Group" width="30" height="30" class="d-inline-block align-text-top">
        <span> <?= $store ?></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav  mb-2 mb-lg-0 ms-auto">
          <li class="nav-item">
            <a class="nav-link <?= $uri=='' ?'active' : '' ?>" aria-current="page" href="<?= base_url() ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $uri=='upload' ?'active' : '' ?>"href="<?= base_url('upload') ?>">Upload</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $uri=='laporan' ?'active' : '' ?>"href="<?= base_url('laporan') ?>">Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $uri=='closeaudit' ?'active' : '' ?>"href="<?= base_url('closeaudit') ?>">Close Audit</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container box">
  <?= $contents ?>
   </div>
  <script src="<?= base_url() ?>src/vendor/bt/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>src/vendor/sw/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>src/vendor/select2/select2.min.js"></script>
    <script src="<?= base_url() ?>src/vendor/bttime/jquery.datetimepicker.full.js"></script>
  <script src="<?= base_url() ?>src/dist/app/sandbox.js"></script>
</body>

</html>