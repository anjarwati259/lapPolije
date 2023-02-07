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
      <!-- modal kirim resi -->
       <div class="modal fade" id="largeModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="judul-kode">Kode #</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
      	        <form class="row g-3" id="form-kirim-resi">
      	            <div class="col-md-12">
                      <input type="hidden" name="no_permohonan" id="no_permohonan">
      	              <label for="tgl_kirim" class="form-label">Tanggal Kirim</label>
      	              <input type="date" class="form-control" name="tgl_kirim" id="tgl_kirim" required>
      	            </div>
                    <div class="col-md-12">
                      <label for="no_resi" class="form-label">Ekspedisi</label>
                      <select class="form-select" name="ekspedisi" id="ekspedisi">
                        <option disabled selected>-- Pilih Ekspedisi</option>
                        <?php foreach ($ekspedisi as $key => $value) {?>
                          <option value="<?= $value->nama_expedisi ?>"><?= $value->nama_expedisi ?></option>
                        <?php } ?>
                      </select>
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

      <!-- modal konfirmasi bayar -->
      <div class="modal fade" id="konfirmBayar" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="judul-kode">Konfirmasi Bayar</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="row g-3" id="form-konfirmBayar">
                <input type="hidden" name="id" id="id">
                <label for="no_resi" class="col-sm-4 col-form-label">No. Penawaran</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="no_penawaran" id="no_penawaran" readonly>
                </div>
                <label for="tgl_kirim" class="col-sm-4 col-form-label">Tanggal Bayar</label>
                <div class="col-md-8">
                  <input type="date" class="form-control" name="tgl_bayar" id="tgl_bayar" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <label for="no_resi" class="col-sm-4 col-form-label">Atas Nama</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="atas_nama" id="atas_nama" >
                </div>
                <label for="no_resi" class="col-sm-4 col-form-label">Transfer Ke Rekening</label>
                <div class="col-md-8">
                  <select class="form-select" name="rekening" id="rekening">
                    <option selected disabled>-- Pilih Rekening --</option>
                    <option>BNI</option>
                    <option>BRI</option>
                  </select>
                </div>
                <label for="no_resi" class="col-sm-4 col-form-label">Jumlah Transfer</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="jml_bayar" id="jml_bayar" >
                </div>
                <div class="col-md-12">
                  <label for="formFile" class="form-label">Upload Bukti Pembayaran</label>
                  <input class="form-control" type="file" id="bukti_bayar" name="bukti_bayar">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="kirimBayar()">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('permohonan_ajax.php'); ?>