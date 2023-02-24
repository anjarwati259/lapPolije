<div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Tambah</button>
    </div>
    <div class="card-body">
      <table class="table" id="Analist-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">NIP</th>
                <th scope="col">Nama Analisa</th>
                <th scope="col">Jumlah Analisa</th>
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
          <h5 class="modal-title">Tambah Analis</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row g-3" id="form-Analist-data">
            <input type="hidden" class="form-control" name="id" id="id">
              <div class="col-md-12">
                <label for="email" class="form-label">Jenis Analisa</label>
                <select name="id_pegawai" id="id_pegawai" class="form-select" aria-label="Default select example">
                  <option selected disabled>Open this select menu</option>
                  <?php foreach ($pegawai as $kpegawai => $vpegawai) {?>
                  <option value="<?= $vpegawai->id ?>"><?= $vpegawai->nama_pegawai ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12">
                <label for="jml_analist" class="form-label">Jumlah Analist</label>
                <input type="text" class="form-control" name="jml_analist" id="jml_analist" value="0" required>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="SubmitAnalist()">Simpan</button>
        </div>
      </div>
    </div>
</div><!-- End Large Modal-->

<script type="text/javascript">
  

</script>
<?php include('analist_ajax.php'); ?>