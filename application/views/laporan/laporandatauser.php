<div class="row">
  <div class="col-12">
    <h1 class="text-center mt-2 bg-light rounded description"><?= $description ?></h1>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <form class="row g-3">
              <div class="col-auto">
                 <button type="button" class="btn btn-success mb-3 btndownloadlaporan d-flex align-items-center" data-names="laporanuser"><i class='bx bx-download mx-2 text-white'></i> Download</button>
              </div>
            </form>
        </div>
      </div>
      <div class="card-body" style="height: 60vh;overflow-y: scroll;">
        <div class="row">
          <div class="col-12">
            <table class="table table-striped table-hover tablalaporanuser table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nik</th>
                  <th>Nama</th>
                  <th>level</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody style="height: 60vh;overflow-y: scroll;">
                <tr>
                  <td colspan="5">Tidak Ada data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>