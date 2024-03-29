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
                <th style="width: 250px;">Kode Registrasi</th>
                <td id="kode_registrasi">: <?= $dataPermohonan->kode_registrasi ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
              </tr>
              <?php if($dataPermohonan->status == '1' || $dataPermohonan->status == '0'){ ?>
              <tr>
                <th style="width: 250px;">Tanggal Terima Sampel</th>
                <td style="display: flex;">:&nbsp;<input type="date" name="tgl_terima_sample" id="tgl_terima_sample" value="" class="form-control"></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Perkiraan Selesai</th>
                <td style="display: flex;">:&nbsp;<input type="date" name="tgl_perkiraan_selesai" id="tgl_perkiraan_selesai" value="" class="form-control"></td>
              </tr>
            <?php }else{ ?>
              <tr>
                <th style="width: 250px;">Tanggal Terima Sampel</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_terima_sample) ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Perkiraan Selesai</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_terima_sample) ?></td>
              </tr>
            <?php } ?>
              <tr>
                <th style="width: 250px;">Tanggal Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_selesai) ? ($dataPermohonan->tgl_selesai) : '-' ?></td>
              </tr>
              <?php if($dataPermohonan->status == '1' || $dataPermohonan->status == '0'){ ?>
              <tr>
                <th style="width: 250px;">Kode Sampel</th>
                <td style="display: flex;">:&nbsp;<input type="number" name="kode_sample" id="kode_sample" value="<?= $kode_sample ?>" class="form-control"></td>
              </tr>
              <tr>
                <th style="width: 250px;">Kode Order</th>
                <td style="display: flex;">:&nbsp;<input type="text" name="kode_order" id="kode_order" value="<?= $kode_order ?>" class="form-control"></td>
              </tr>
            <?php }else{ ?>
              <tr>
                <th style="width: 250px;">Kode Sampel</th>
                <td>: <?= ($dataPermohonan->kode_sample) ? ($dataPermohonan->kode_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Kode Order</th>
                <td>: <?= ($dataPermohonan->kode_order) ? ($dataPermohonan->kode_order) : '-' ?></td>
              </tr>
            <?php } ?>
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Daftar Dokumen</h5>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Kode Dokumen</th>
                    <th scope="col">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Analisa</th>
                <th scope="col">Metode Analisa</th>
                <th scope="col">Ulangan 1</th>
                <th scope="col">Ulangan 2</th>
                <th scope="col">Rata - Rata</th>
                <th scope="col">status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1; 
              $status = false; 
              foreach ($detailPermohonan as $key => $value) {
              	$viewStatus = ($value->status == '1') ? ('Selesai') : ('Belum Selesai')
              	?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                <?php if($value->status == '0'){ $status = false; ?>
                <td>
                	<input type="number" name="ulangan1" id="ulangan1" class="form-control">
                </td>
                <td>
                	<input type="number" name="ulangan2" id="ulangan2" class="form-control">
                </td>
                <td>
                	<input type="number" name="rata_rata" id="rata_rata" class="form-control">
                </td>
            	<?php }else{ $status = true; ?>
            	<td><?= ($value->pengulangan_1) ? ($value->pengulangan_1) : '-' ?></td>
                <td><?= ($value->pengulangan_2) ? ($value->pengulangan_2) : '-' ?></td>
                <td><?= ($value->rata_rata) ? ($value->rata_rata) : '-' ?></td>
            	<?php } ?>
                <td><?= ($value->status) ? ($viewStatus) : '-' ?></td>
              </tr>
              <input type="hidden" name="id" id="id_detail" value="<?= $value->id ?>">
              <input type="hidden" name="id_analist" id="id_analist" value="<?= $value->id_analist ?>">
            <?php $no++;} ?>
            </tbody>
          </table>
          <!-- End Tables without borders -->

        </div>
        <?php if($status == false){ ?>
        <div class="text-center">
          <button type="submit" class="btn btn-primary" onclick="submitAnalist();">Submit</button>
          <a href="<?php echo base_url('admin/permohonan'); ?>" class="btn btn-danger">Cancel</a>
        </div>
    	<?php } ?>
      </div>
    </div>
  </div>
</section>

<?php include('permohonan_ajax.php'); ?>