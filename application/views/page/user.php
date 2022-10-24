   <div class="row mt-2 d-flex justify-content-center">
     <div class="col-4">
       <div class="card">
         <div class="card-header">
           <h1><?= $description ?></h1>
         </div>
         <div class="card-body">
           <form class="mb-3">
             <div class="mb-3">
               <label for="" class="form-label">Periode Audit</label>
               <input type="text" readonly name="tanggal" class="form-control tgl">
             </div>
             <div class="mb-3">
               <label for="" class="form-label">Staff Audit</label>
               <input type="text" name="nama" readonly value="<?= $this->session->userdata('nama'); ?>" class="form-control">
             </div>
                <div class="mb-3">
               <label for="staffstore" class="form-label">Staff Store</label>
               <input type="text" required autocomplete="empty" name="staffstore" class="form-control" placeholder="Masukan Nama Staff Toko">
             </div>
             <button type="button" class="btn btn-primary w-100 d-flex align-items-center justify-content-center closeaudit"><i class='bx bx-save mx-2 text-white' ></i> Simpan Tanda Tangan</button>
           </form>
            <button type="button" class="btn btn-warning w-100 d-flex align-items-center justify-content-center kirmdataonline d-none"><i class='bx bx-upload mx-2 text-white' ></i> Post Ke Server Online</button>
         </div>
       </div>
     </div>
   </div>