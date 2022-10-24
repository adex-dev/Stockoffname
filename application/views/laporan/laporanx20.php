<div class="row">
  <div class="col-12">
    <h1 class="text-center mt-2 bg-light rounded text-capitalize description"><?= $description ?></h1>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h6></h6>
          <div>
            <input type="search" autocomplete="empty" class="form-control form-control-sm Search" placeholder="search....">
          </div>
        </div>
        <div class="d-flex justify-content-between">
         <h6>Periode Dipilih : <span class="tglg"></span></h6>
        <h6>Status Audit : <span class="statuss"></span></h6>
        </div>
        <div class="d-flex justify-content-between">
          <h6>Staff Audit : <?= $this->session->userdata('nama'); ?></h6>
          <h6>Staff Store : <span class="pengaudit"></span></h6>
        </div>
      </div>
      <div class="card-body" style="height: 60vh;overflow-y: scroll;">
        <div class="row">
          <div class="col-12">
            <table class="table table-striped tablex20 table-hover table-bordered">
              <thead>
                <tr>
                  <th>Ean</th>
                  <th>Item Description</th>
                  <th>Article ID</th>
                  <th>Waist</th>
                  <th>Inseam</th>
                  <th>Onhand Qty</th>
                </tr>
              </thead>
              <tbody style="height: 60vh;overflow-y: scroll;">
              </tbody>
              <tfoot class="table-success">

              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>