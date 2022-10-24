<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit</title>
  <link rel="shortcut icon" href="<?= base_url() ?>src/bundle/favicon/favicon.ico" />
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/bt/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/sw/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/select2/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/bundle/icon/css/boxicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>src/vendor/bttime/jquery.datetimepicker.css">
  <script src="<?= base_url() ?>src/vendor/jquery/jquery-3.6.0.min.js"></script>
  <script>
    var hostname = "<?= base_url() ?>"
  </script>
</head>
<style>
  .bgroundhome {
    background-image: url('./src/bundle/img/bg2.webp');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
  }
</style>

<body class="bgroundhome">
  <div class="container">
    <div class="row d-md-flex align-content-md-center align-items-md-center min-vh-100">
      <div class="col-md-6 d-none d-md-block">
        <div class="card">
          <div class="card-header bg-none">
            <h1 class="font-interbold">Jaygee Group</h1>
          </div>
          <div class="card-body">
            <video class="w-100" playsinline="" autoplay="" muted="" loop="" __idm_id__="3555329">
              <source src="<?= base_url() ?>src/bundle/video/bg.mp4" type="video/mp4">
            </video>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body d-flex justify-content-center">
            <img src='<?= base_url() ?>src/bundle/img/bg.webp' alt='icon bg' class='w-100 loginbg position-relative' loading='lazy'>
            <div class="position-absolute w-50" style="bottom: 25%;">
              <div class="row">
                <div class="col-12">
                  <form class="formlogin">
                    <div class="form-floating mb-3">
                     <input type="text" class="form-control clock" value="<?= date('Y-m-d') ?>" name="tanggallogin" placeholder="Tanggal Audit" readonly>
                      <label for="tanggallogin">Tanggal Audit</label>
                    </div>
                    <div class="mb-3">
                      <select required name="storelogin" class="form-control form-control-sm visitor" id="">
                        <option value="">Choose</option>
                        <?php foreach ($store as $value) : ?>
                          <option value="<?= $value->kode_store ?>"><?= $value->nama_store ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <input autocomplete="empty" name="niklogin" autofocus required type="text" class="form-control font-interitalic" placeholder="Nik">
                    </div>
                    <div class="mb-3">
                      <input autocomplete="empty" name="passwordlogin" required type="password" class="form-control font-interitalic" placeholder="Password">
                    </div>
                    <div class="mb-3">
                      <button type="submit" class="btn btn-success btn-sm w-100 font-interbold">Login</button>
                    </div>
                  </form>
                    <div class="mb-3">
                      <button type="button" class="btn btn-warning btn-sm w-100 font-interbold btnsyncron">Syncronize Data</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="<?= base_url() ?>src/vendor/bt/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>src/vendor/sw/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>src/vendor/select2/select2.min.js"></script>
  <script src="<?= base_url() ?>src/vendor/bttime/jquery.datetimepicker.full.js"></script>
  <script src="<?= base_url() ?>src/dist/js/login.js"></script>
</body>

</html>