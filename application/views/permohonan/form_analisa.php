<?php for ($i=1; $i <= $jml_sample; $i++) {?>
<div class="card border-secondary">
	<h5 class="card-header"><b>Analisa Sample <?= $i; ?></b></h5>
    <div class="card-body">
    	<table class="table table-striped" id="tbl-<?= $i; ?>">
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
                    	<select name="jenis_analisa1" id="jenis_analisa1" class="form-select" onchange="setMetode('<?= $i; ?>','1')">
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
                    	<button type="button" class="btn btn-danger btn-sm" onclick="delPermohonan('<?= $i; ?>','1')"> Hapus</button>
                    </td>
                    <input type="hidden" value="0" name="status<?= $i; ?>" id="status<?= $i; ?>">
                </tr>
            </tbody>
            <tbody style="border: none; border-color: #a6a8ab;" id="addForm">
            	
            </tbody>
        </table>
        <div class="row">
            <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Catatan</b></label>
            <textarea style="height: 100px;" type="text" class="form-control" id="catatan<?= $i; ?>" placeholder="Bisa diisi varian dari sample. contoh: "></textarea>
        </div>
        <div class="button-tambah text-center mt-3">
        	<button type="button" class="btn btn-primary btn-md" onclick="addFrom('<?= $i; ?>')"> Tambah Analisa</button>
        </div>
        
    </div>
</div>
<?php } ?>