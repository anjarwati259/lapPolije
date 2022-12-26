<section class="section">
    <div class="row align-items-top">
        <div class="col-lg-12">
	        <div class="card">
	            <div class="card-body">
	              <h5 class="card-title">Form Permohonan Pengujian</h5>
	              <div class="row">
	              	<div class="col-md-6">
	              		<form>
			                <div class="row mb-3">
			                  <label for="kode_registrasi" class="col-sm-4 col-form-label">Kode Registrasi</label>
			                  <div class="col-sm-8">
			                    <input type="text" value="<?= $kode_registrasi ?>" class="form-control" id="kode_registrasi" readOnly>
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Kirim</label>
			                  <div class="col-sm-8">
			                    <input type="Date" name="tgl_kirim" class="form-control" id="tgl_kirim">
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Jenis Sample</label>
			                  <div class="col-sm-8">
			                    <input type="text" value="jenis_sample" class="form-control" id="jenis_sample">
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Jumlah Sample</label>
			                  <div class="col-sm-8">
			                    <input type="text" value="jml_sample" class="form-control" id="jml_sample">
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Penyimpanan</label>
			                  <div class="col-sm-8">
			                    <select name="penyimpanan" id="penyimpanan" class="form-select" aria-label="Default select example">
				                  <option selected disabled>Open this select menu</option>
				                  <?php foreach ($penyimpanan_sample as $kpSample => $vpSample) {?>
				                  <option value="<?= $vpSample->id ?>"><?= $vpSample->nama_penyimpanan ?></option>
				                  <?php } ?>
				                </select>
			                  </div>
			                </div>

			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan Sample</label>
			                  <div class="col-sm-8">
			                    <select name="keterangan_sample" id="keterangan_sample" class="form-select" aria-label="Default select example">
				                  <option selected disabled>Open this select menu</option>
				                  <?php foreach ($ket_sample as $kkSample => $vkSample) {?>
				                  <option value="<?= $vkSample->id ?>"><?= $vkSample->keterangan_sample ?></option>
				                  <?php } ?>
				                </select>
			                  </div>
			                </div>
			            </form>
	              	</div>

	              	<div class="col-md-6">
	              		<form>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Customer</label>
			                  <input type="hidden" value="<?= $customer->id ?>" name="id_customer" id="id_customer">
			                  <div class="col-sm-8">
			                    <input type="text" value="<?= $customer->nama_customer ?>" class="form-control" id="inputText" readOnly>
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Instansi</label>
			                  <div class="col-sm-8">
			                    <input type="number" class="form-control" id="inputText" readOnly>
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Alamat Customer</label>
			                  <div class="col-sm-8">
			                    <textarea class="form-control" style="height: 100px;" readOnly><?= $customer->alamat ?></textarea>
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Nomor Telephon</label>
			                  <div class="col-sm-8">
			                    <input type="number" value="<?= $customer->no_telp ?>" class="form-control" id="inputText" readOnly>
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
			                  <div class="col-sm-8">
			                    <input type="text" value="<?= $customer->email ?>" class="form-control" id="inputEmail" readOnly>
			                  </div>
			                </div>
			            </form>
	              	</div>
	              </div>

	              <div class="card">
		            <div class="card-body">
		            	<h5 class="card-title">Informasi Analisa</h5>
		            	<table class="table table-striped">
			                <thead>
			                  	<tr>
				                    <th scope="col">No</th>
				                    <th scope="col">Jenis Analisa</th>
				                    <th scope="col">Metode Analisa</th>
				                    <th scope="col">Action</th>
			                  	</tr>
			                </thead>
			                <tbody style="border: none; border-color: #a6a8ab;">
			                  	<tr id="tr1">
				                	<th scope="row">1</th>
				                    <td>
				                    	<select name="jenis_analisa1" id="jenis_analisa1" class="form-select" onchange="setMetode('1')">
				                    		<?php foreach ($jenis_analisa as $key => $value) { ?>
				                    			<option value="<?= $value->id ?>"><?= $value->jenis_analisa ?></option>
				                    		<?php } ?>
				                    	</select>
				                    </td>
				                    <td>
				                    	<select name="metode_analisa1" id="metode_analisa1" class="form-select">
				                    		
				                    	</select>
				                    </td>
				                    <td>
				                    	<button type="button" class="btn btn-danger btn-sm"> Hapus</button>
				                    </td>
				                </tr>
			                </tbody>
			                <tbody style="border: none; border-color: #a6a8ab;" id="addForm">
			                	
			                </tbody>
			            </table>
		            </div>

		          </div>
		          <div class="text-center">
	                  <button type="submit" class="btn btn-success">Submit</button>
	                  <button type="reset" class="btn btn-primary" onclick="addFrom()">Tambah</button>
	              </div>
	            </div>
	        </div>
	    </div>
	</div>
</section>

<?php include('permohonan_ajax.php'); ?>