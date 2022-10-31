   <div class="row">
     <div class="col-12">
       <h1 class="text-center mt-2 bg-light rounded">Upload ChiperLab</h1>
     </div>
     <div class="col-12">
       <div class="card">
         <div class="card-header">
           <div class="d-flex justify-content-between">
             <h6>Chiperlab Upload File Only txt</h6>
             <div>
               <div class="d-flex justify-content-between">
                 <h6>Auditor :</h6><span><?= $this->session->userdata('nama'); ?></span>
               </div>
               <div class="d-flex justify-content-between">
               <h6>Periode :</h6> <span class="tglg"></span>
               </div>
             </div>
           </div>
         </div>
         <div class="card-body" style="min-height: 80vh;">
           <div class="row">
             <div class="col-6">
               <h5>Total : </h5>
               <h1 class="fw-bold totalsumchiper"></h1>
               <table class="table table-striped tabledummy table-hover table-bordered">
                 <thead>
                   <tr>
                     <th>#</th>
                     <th>Ean</th>
                     <th>QTY</th>
                     <th>Tempat</th>
                   </tr>
                 </thead>
                 <tbody style="min-height: 80vh;overflow-y: scroll;">
                   <tr>
                     <td class="text-center" colspan="4">Tdiak Ada Data</td>
                   </tr>
                 </tbody>
                 <tfoot class="table-success">
                   <tr>
                     <td colspan="2">Total</td>
                     <td>0</td>
                     <td></td>
                   </tr>
                 </tfoot>
               </table>
             </div>
             <div class="col-6">
               <form enctype="multipart/form-data">
                 <div class="input-group mb-3">
                   <label class="input-group-text" for="">Rak Store</label>
                   <select required name="floor" class="form-select" aria-label="Default select example">
                     <option value="">Pilih Rak</option>
                     <?php for ($i = 1; $i <= 100; $i++) : ?>
                       <option value="rak-<?= $i ?>">Rak-<?= $i ?></option>
                     <?php endfor ?>
                   </select>
                 </div>
                 <div class="input-group mb-3">
                   <input type="file" name="filesname" accept=".txt" class="form-control" id="inputGroupFile02">
                   <label class="input-group-text" for="inputGroupFile02">Upload</label>
                 </div>
                 <div class="input-group mb-3">
                   <button type="button" data-konteks="chiperlab" class="btn btn-primary w-100 btnupload">Upload</button>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>