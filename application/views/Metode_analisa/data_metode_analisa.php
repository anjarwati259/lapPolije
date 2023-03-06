<div class="card">
    <div class="card-header">
    	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Tambah</button>
    </div>
    <div class="card-body">
      <table class="table" id="metode_analisa-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Analisa</th>
                <th scope="col">Metode Analisa</th>
                <th scope="col">Harga</th>
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
          <h5 class="modal-title">Tambah Metode Analisa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
	        <form class="row g-3" id="form-metode_analisa">
            <input type="hidden" class="form-control" name="id" id="id">
              <div class="col-md-12">
                <label for="email" class="form-label">Jenis Analisa</label>
                <select name="id_jenis_analisa" id="id_jenis_analisa" class="form-select" aria-label="Default select example">
                  <option selected disabled>Open this select menu</option>
                  <?php foreach ($jenis_analisa as $kjenAnalisa => $vjenAnalisa) {?>
                  <option value="<?= $vjenAnalisa->id ?>"><?= $vjenAnalisa->jenis_analisa ?></option>
                  <?php } ?>
                </select>
              </div>
	            <div class="col-md-12">
	              <label for="metode_analisa" class="form-label">Metode Analisa</label>
	              <input type="text" class="form-control" name="metode_analisa" id="metode_analisa" required>
	            </div>
              <div class="col-md-12">
                <label for="harga" class="form-label">Harga Analisa</label>
                <input type="number" class="form-control" name="harga" id="harga" required>
              </div>

              <div class="col-md-12">
                <label for="formFile" class="form-label">Upload File</label>
                <input class="form-control" type="file" id="upload_file" name="upload_file">
              </div>
	        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="SubmitMetodeanalisa()">Simpan</button>
        </div>
      </div>
    </div>
</div><!-- End Large Modal-->
<?php include('metode_analisa_ajax.php'); ?>