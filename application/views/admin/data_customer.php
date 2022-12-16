<div class="card">
    <div class="card-header">
    	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Tambah</button>
    </div>
    <div class="card-body">
      <table class="table" id="customer-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Customer</th>
                <th scope="col">Alamat Customer</th>
                <th scope="col">Email</th>
                <th scope="col">Nomor Telpon</th>
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
          <h5 class="modal-title">Tambah Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
	        <form class="row g-3" id="form-customer">
            <input type="hidden" class="form-control" name="id" id="id">
	            <div class="col-md-12">
	              <label for="nama_customer" class="form-label">Nama Customer</label>
	              <input type="text" class="form-control" name="nama_customer" id="nama_customer" required>
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
          <button type="button" class="btn btn-primary" onclick="SubmitCustomer()">Simpan</button>
        </div>
      </div>
    </div>
</div><!-- End Large Modal-->
<?php include('admin_ajax.php'); ?>