<div class="row">
  <div class="col-12">
    <h1 class="text-center mt-2 bg-light rounded description"><?= $description ?></h1>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between mt-2">
          <form class="row g-3">
              <div class="col-auto">
                 <button type="button" class="btn btn-success mb-3 btndownloadlaporan d-flex align-items-center" data-names="laporanuser"><i class='bx bx-download mx-2 text-white'></i> Download</button>
              </div>
            </form>
             <div>
            <input type="search" autocomplete="empty" class="form-control form-control-sm Search" placeholder="search....">
          </div>
        </div>
      </div>
      <div class="card-body" style="height: 60vh;overflow-y: scroll;">
        <div class="row">
          <div class="col-12">
            <table class="table table-striped table-hover tballaporanhistoris table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Periode</th>
                  <th>Store Name</th>
                  <th>Staff Audit</th>
                  <th>Staff Store</th>
                  <th>Status Audit</th>
                </tr>
              </thead>
              <tbody style="height: 60vh;overflow-y: scroll;">
                <tr>
                  <td colspan="6">Tidak Ada data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>