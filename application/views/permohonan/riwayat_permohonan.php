<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-title"></h5>
          <div class="card-body">
            <table class="table" id="riwayat_permohonan-data">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Kode Registrasi</th>
                      <th scope="col">Tanggal Kirim</th>
                      <th scope="col">Jenis Sample</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                </table>
          </div>
      </div>

       <div class="modal fade" id="largeModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="judul-kode">Kode #</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
      	        <form class="row g-3" id="form-tgl_kirim">
      	            <div class="col-md-12">
                      <input type="hidden" name="kode_registrasi" id="kode_registrasi">
      	              <label for="tgl_kirim" class="form-label">Tanggal Kirim</label>
      	              <input type="date" class="form-control" name="tgl_kirim" id="tgl_kirim" required>
      	            </div>
                    <div class="col-md-12">
                      <label for="no_resi" class="form-label">No Resi</label>
                      <input type="text" class="form-control" name="no_resi" id="no_resi" required>
                    </div>
      	        </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="kirimResi()">Simpan</button>
              </div>
            </div>
          </div>
      </div><!-- End Large Modal-->
    </div>
  </div>
</section>
<?php include('permohonan_ajax.php'); ?>