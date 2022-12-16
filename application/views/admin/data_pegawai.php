<div class="card">
    <div class="card-header">
    	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Tambah</button>
    </div>
    <div class="card-body">
      <table class="table" id="pegawai-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">NIP</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Unit Kerja</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
          </table>
    </div>
</div>

 <div class="modal fade" id="largeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pegawai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
	        <form class="row g-3" id="form-pegawai">
            <input type="hidden" class="form-control" name="id" id="id">
              <div class="col-md-12">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" id="nip" required>
              </div>
	            <div class="col-md-12">
	              <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
	              <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" required>
	            </div>
              <div class="col-md-12">
                <label for="email" class="form-label">Jabatan</label>
                <select name="id_jabatan" id="id_jabatan" class="form-select" aria-label="Default select example">
                  <option selected disabled>Open this select menu</option>
                  <?php foreach ($jabatan as $kJabatan => $vJabatan) {?>
                  <option value="<?= $vJabatan->id ?>"><?= $vJabatan->nama_jabatan ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12">
                <label for="email" class="form-label">Unit Kerja</label>
                <select name="id_unit" id="id_unit" class="form-select" aria-label="Default select example">
                  <option selected disabled>Open this select menu</option>
                  <?php foreach ($unit as $kUnit => $vUnit) {?>
                  <option value="<?= $vUnit->id ?>"><?= $vUnit->nama_unit ?></option>
                  <?php } ?>
                </select>
              </div>
	            <div class="col-md-6">
	              <label for="email" class="form-label">Email</label>
	              <input type="email" class="form-control" name="email" id="email" required>
	            </div>
	            <div class="col-md-6">
	              <label for="no_telp" class="form-label">Nomor Telpon</label>
	              <input type="number" class="form-control" name="no_telp" id="no_telp" required>
	            </div>
	            <div class="col-12">
	              <label for="alamat" class="form-label">Alamat</label>
	              <textarea class="form-control" name="alamat" id="alamat" style="height: 100px;" required></textarea>
	            </div>
	        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="SubmitPegawai()">Simpan</button>
        </div>
      </div>
    </div>
</div><!-- End Large Modal-->
<?php include('admin_ajax.php'); ?>