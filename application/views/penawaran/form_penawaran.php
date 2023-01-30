<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Permohonan</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <input type="hidden" id="kode_registrasi" value="<?= $dataPermohonan->kode_registrasi ?>">
                <th style="width: 250px;">Kode Penawaran</th>
                <td>: <?= $dataPermohonan->kode_registrasi ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jenis Sampel</th>
                <td>: <?= ($dataPermohonan->jenis_sample) ? ($dataPermohonan->jenis_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jumlah Sampel</th>
                <td>: <?= ($dataPermohonan->jml_sample) ? ($dataPermohonan->jml_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 200px;">Penyimpanan</th>
                <td>: <?= ($dataPermohonan->penyimpanan) ? ($dataPermohonan->penyimpanan) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">keterangan Sampel</th>
                <td>: <?= ($dataPermohonan->keterangan_sample) ? ($dataPermohonan->keterangan_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Status</th>
                <td>: <?= '<span class="badge '.$dataPermohonan->class_color.'">'.$dataPermohonan->keterangan.'</span>' ?></td>
              </tr>
            </tbody>
          </table>
          <!-- End Tables without borders -->

        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Pemohon</h5>
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th scope="row">Nama Pemohon</th>
                    <td>: <?= ($dataPermohonan->nama_customer) ? ($dataPermohonan->nama_customer) : '-' ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Nama Instansi</th>
                    <td>: -</td>
                  </tr>
                  <tr>
                    <th scope="row">Nomor Telephon</th>
                    <td>: <?= ($dataPermohonan->no_telp) ? ($dataPermohonan->no_telp) : '-' ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Email</th>
                    <td>: <?= ($dataPermohonan->email) ? ($dataPermohonan->email) : '-' ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Alamat</th>
                    <td>: <?= ($dataPermohonan->alamat) ? ($dataPermohonan->alamat) : '-' ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Informasi Analisa Sample</h5>
          <table class="table table-striped" id="tbl-penawaran">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Analisa</th>
                <th scope="col">Metode Analisa</th>
                <th scope="col">Nomor Sampel</th>
                <th scope="col">Harga (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($detailPermohonan as $key => $value) {?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                <td><?= generateNomorSample($dataPermohonan->kode_registrasi, $value->id_sampel) ?></td>
                <td id="harga" data-id ="<?= $value->id; ?>"><?= number_format($value->harga,0,',','.'); ?></td>
              </tr>
              <?php $no++;} ?>
            </tbody>
            <tfoot>
            	<tr>
            		<th colspan="4" class="text-end">Total</th>
            		<th id="total"><?= number_format($totalHarga,0,',','.'); ?></th>
            	</tr>
            </tfoot>
          </table>

          <?php if($this->session->userdata('hak_akses')=="1"){ ?>
          <div class="text-center group-button">
            <button type="submit" class="btn btn-primary" onclick="simpan('submit')">Submit</button>
            <button type="reset" class="btn btn-secondary" onclick="">Cancel</button>
          </div>
      	  <?php }else{ ?>
      	  	<div class="text-center group-button">
	            <button type="button" class="btn btn-primary" onclick="konfirm('approved')">Approved</button>
	            <button type="button" class="btn btn-danger" onclick="konfirm('reject')">Reject</button>
	        </div>
      	  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<button type="button" class="btn btn-primary btn-approved" data-bs-toggle="modal" data-bs-target="#modal_approved">Approved</button>
<div class="modal fade" id="modal_approved" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title">Basic Modal</h5>
	      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	    </div>
	    <div class="modal-body">
	      Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	      <button type="button" class="btn btn-primary">Save changes</button>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$('.btn-approved').click();
	function simpan(action){
		var data = {};
		var kode_registrasi = '<?= $dataPermohonan->kode_registrasi ?>';
		var total_harga = $('#total').text();

		data.kode_registrasi = kode_registrasi;
		data.total_harga = total_harga;
		dataharga = {}
		$("#tbl-penawaran>tbody>tr").each(function(index, val){
			var harga = $(this).find('#harga').text();
			var id = $(this).find('#harga').attr("data-id");
	        dataharga[index] = {['id']:id,
	        					['harga']:harga}
	    });
	    data.data = dataharga;
	    $.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/simpanPenawaran'); ?>",
            data:data,
            dataType : 'json',
            success: function(hasil) {
                console.log(hasil)
                var url = "<?php echo base_url('admin/permohonan'); ?>";
                if(hasil.status == 'success'){
                    localStorage.setItem("success", JSON.stringify({['message']:hasil.message, ['tapid']:'pmn'}));
                    window.location.replace(url);
                }else{
                    // localStorage.setItem("error",data.message)
                    Swal.fire('Oppss...',hasil.message,'error')
                } 
            }
        });
	}

	function konfirm(action){
		var kode_registrasi = '<?= $dataPermohonan->kode_registrasi; ?>';
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/appPenawaran'); ?>",
            data:{kode_registrasi:kode_registrasi, action:action},
            dataType : 'json',
            success: function(hasil) {
                console.log(hasil)
                if(hasil.status == 'success' && action == 'approved'){
                	console.log('app')
	                $('#modal-approved').show();
	                $('#modal-reject').hide();
	            }else if(hasil.status == 'success' && action == 'reject'){
	            	console.log('re')
	            	$('#modal-reject').show();
	                $('#modal-approved').hide();
	            }else{
	            	Swal.fire('Oppss...',hasil.message,'error')
	            	console.log('error')
	            }
            }
        });
	}
</script>
<?php include('penawaran_ajax.php'); ?>