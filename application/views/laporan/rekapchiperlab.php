<div class="row">
     <div class="col-12">
       <h1 class="text-center mt-2 bg-light rounded text-capitalize description"><?= $description ?></h1>
     </div>
     <div class="col-12">
       <div class="card">
         <div class="card-header">
         <div class="d-flex justify-content-between">
           <form class="row g-3">
              <div class="col-auto">
                <button type="button" class="btn btn-success mb-3 btndownloadlaporan d-flex align-items-center" data-names="rekapchiperlab"><i class='bx bx-download mx-2 text-white'></i> Download</button>
              </div>
            </form>
            <div>
            <input type="search" autocomplete="empty" class="form-control form-control-sm Search" placeholder="search....">
          </div>
         </div>
          <div class="d-flex justify-content-between mt-2">
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
               <table class="table table-striped tablerekapchiperlab table-hover table-bordered" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ean</th>
                    <th>Artikel ID</th>
                    <th>Rak Store</th>
                    <th>Onhan Scan</th>
                    <th>User</th>
                  </tr>
                </thead>
                <tbody style="height: 60vh;overflow-y: scroll;">
                </tbody>
              </table>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>