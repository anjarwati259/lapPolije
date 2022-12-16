<div class="card">
    <div class="card-header">
    	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Tambah</button>
    </div>
    <div class="card-body">
      <table class="table" id="jabatan-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Jabatan</th>
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
          <h5 class="modal-title">Tambah Jabatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
	        <form class="row g-3" id="form-jabatan">
            <input type="hidden" class="form-control" name="id" id="id">
	            <div class="col-md-12">
	              <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
	              <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" required>
	            </div>
	        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="SubmitJabatan()">Simpan</button>
        </div>
      </div>
    </div>
</div><!-- End Large Modal-->
<?php include('admin_ajax.php'); ?>