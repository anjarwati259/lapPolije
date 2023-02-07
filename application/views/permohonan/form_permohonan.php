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
			                  <label for="no_permohonan" class="col-sm-4 col-form-label">No. Permohonan</label>
			                  <div class="col-sm-8">
			                    <input type="text" value="<?= $no_permohonan ?>" class="form-control" id="no_permohonan" readOnly>
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
			                    <input type="text" name="jenis_sample" class="form-control" id="jenis_sample">
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Jumlah Sample</label>
			                  <div class="col-sm-8">
			                    <input type="number" name="jml_sample" class="form-control" id="jml_sample" onkeyup="jmlSample()">
			                  </div>
			                </div>
			                <div class="row mb-3">
			                  <label for="inputEmail3" class="col-sm-4 col-form-label">Penyimpanan</label>
			                  <div class="col-sm-8">
			                    <select name="penyimpanan" id="penyimpanan" class="form-select" aria-label="Default select example">
				                  <option selected disabled>Open this select menu</option>
				                  <?php foreach ($penyimpanan_sample as $kpSample => $vpSample) {?>
				                  <option value="<?= $vpSample->nama_penyimpanan ?>"><?= $vpSample->nama_penyimpanan ?></option>
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
				                  <option value="<?= $vkSample->keterangan_sample ?>"><?= $vkSample->keterangan_sample ?></option>
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

            	<h5 class="card-title">Informasi Analisa</h5>
            	<div class="tbl-analisa" id="tbl-analisa">
            		<div class="card border-secondary">
	            		<h5 class="card-header"><b>Analisa Sample 1</b></h5>
			            <div class="card-body">
			            	<table class="table table-striped" id="tbl-1">
				                <thead>
				                  	<tr>
					                    <th scope="col">No</th>
					                    <th scope="col">Jenis Analisa</th>
					                    <th scope="col">Metode Analisa</th>
					                    <th scope="col" width="200">Action</th>
				                  	</tr>
				                </thead>
				                <tbody style="border: none; border-color: #a6a8ab;">
				                  	<tr id="tr1">
					                	<th scope="row">1</th>
					                    <td>
					                    	<select name="jenis_analisa1" id="jenis_analisa1" class="form-select" onchange="setMetode('1','1')">
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
					                    	<button type="button" class="btn btn-danger btn-sm" onclick="delPermohonan('1','1')"> Hapus</button>
					                    </td>
					                    <input type="hidden" value="0" name="status1" id="status1">
					                </tr>
				                </tbody>
				                <tbody style="border: none; border-color: #a6a8ab;" id="addForm">
				                	
				                </tbody>
				            </table>
				            <div class="row">
			                  	<label for="inputEmail3" class="col-sm-4 col-form-label"><b>Catatan</b></label>
			                  	<textarea style="height: 100px;" type="text" class="form-control" id="catatan1" placeholder="Bisa diisi varian dari sample. contoh: "></textarea>
			                </div>
			                <div class="button-tambah text-center mt-3">
				            	<button type="button" class="btn btn-primary btn-md" onclick="addFrom('1')"> Tambah Analisa</button>
				            </div>
			            </div>
			        </div>
            	</div>
            	

		        <div class="text-center group-button">
	                <button type="submit" class="btn btn-success" onclick="simpan('submit')">Submit</button>
	                <button type="reset" class="btn btn-primary" onclick="">Draft</button>
	                <button type="reset" class="btn btn-secondary" onclick="">Cancel</button>
	            </div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
<script type="text/javascript">
	function setMetode(idtable,id){
		var idJenisanalisa = $("#tbl-"+idtable+" #jenis_analisa"+id).val();
		// console.log(idJenisanalisa);
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/getMetodeanalisa'); ?>",
            data:{id:idJenisanalisa, type:'analisa'},
            dataType : 'html',
            success: function(hasil) {
                $("#tbl-"+idtable+" #metode_analisa"+id).html(hasil);
            }
        });
	}

	function addFrom(id){
		let jmlAnalisa = $("#tbl-"+id+">tbody>tr").length;
		let index = jmlAnalisa+1;
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/getMetodeanalisa'); ?>",
            data:{index:index, type:'add', idtable:id},
            dataType : 'html',
            success: function(hasil) {
            	var html = '<tr id="tr'+index+'"><th scope="row">'+index+'</th><td>'+hasil+'</td><td><select name="metode_analisa'+index+'" id="metode_analisa'+index+'" class="form-select"></>select></td> <td><button type="button" class="btn btn-danger btn-sm" onclick="delPermohonan('+"\'"+id+"\'"+","+"\'"+index+"\'"+')"> Hapus</button></td>';
                var input = '<input type="hidden" value="0" name="status'+index+'" id="status'+index+'">';
                $("#tbl-"+id+" #addForm").append(html);
                $("#tbl-"+id+" #addForm").append(input);
                // console.log(html);
            }
        });
	}

	function delPermohonan(idtable,id){
        $("#tbl-"+idtable+" #tr"+id).hide();
        $("#tbl-"+idtable+" #status"+id).val('1');
        // index = index-1;
    }

    function jmlSample(){
    	var jml_sample = $('#jml_sample').val();
    	$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/tambahFormAnalisa'); ?>",
            data:{jml_sample:jml_sample},
            dataType : 'html',
            success: function(hasil) {
                // console.log(hasil) 
                $("#tbl-analisa").html(hasil);
            }
        });
    }

    function simpan(action){
    	var data = {}
    	var jml_sample = $('#jml_sample').val();
    	var no_permohonan = $('#no_permohonan').val();
        var tgl_kirim = $('#tgl_kirim').val();
        var jenis_sample = $('#jenis_sample').val();
        var jml_sample = $('#jml_sample').val();
        var penyimpanan = $('#penyimpanan').val();
        var keterangan_sample = $('#keterangan_sample').val();
        var id_customer = $('#id_customer').val();

        data['0'] = {['no_permohonan']:no_permohonan, 
                     ['id_customer']:id_customer, 
                     ['tgl_kirim']: tgl_kirim,
                     ['jenis_sample']: jenis_sample,
                     ['jml_sample']: jml_sample,
                     ['penyimpanan']: penyimpanan,
                     ['keterangan_sample']: keterangan_sample,
                 }

    	data.action = action;
    	var listcatatan = {}
    	for (var i = 1; i <= jml_sample; i++) {
    		var dataAnalisa = {}
    		var row = 0;
    		var catatan  = $('#catatan'+i).val();
    		listcatatan[i] = catatan;
    		$("#tbl-"+i+">tbody>tr").each(function(index, val){
	        	index+=1;
	        	let jenis_analisa = $('#jenis_analisa'+index).val();
		        let metode_analisa = $('#metode_analisa'+index).val();
		        let status = $('#status'+index).val();
		        if(status == '0'){
		        	row+=1;
		        	dataAnalisa[row] = {['jenis_analisa']:jenis_analisa,
		        						  ['metode_analisa']:metode_analisa}
			    }
		    });
		    data[i] = dataAnalisa;
    	}
    	data.catatan = listcatatan;
    	console.log(data);
    	$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/simpanPermohonan'); ?>",
            data:data,
            dataType : 'json',
            success: function(hasil) {
                console.log(hasil)
                var url = "<?php echo base_url('permohonan/riwayatPermohonan'); ?>";
                if(hasil.status == 'success'){
                    localStorage.setItem("sukses",hasil.message)
                    window.location.replace(url);
                }else{
                    // localStorage.setItem("error",data.message)
                    Swal.fire('Oppss...',hasil.message,'error')
                } 
            }
        });
    }
</script>
<?php //include('permohonan_ajax.php'); ?>