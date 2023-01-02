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
                <td>: <?= $dataPermohonan->kode_registrasi ?></td>
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
                <th scope="col">Nama Analist</th>
                <?php if($dataPermohonan->status != '1' or $dataPermohonan->status != '0'){ ?>
                  <th scope="col">Surat Tugas</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($detailPermohonan as $key => $value) {?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                <?php if($dataPermohonan->status == '1' || $dataPermohonan->status == '0'){ ?>
                <td>
                  <select name="id_analist<?= $no ?>" id="id_analist<?= $no ?>" class="form-select" aria-label="Default select example">
                    <option selected disabled>Open this select menu</option>
                    <?php foreach ($dataAnalist as $kAnalist => $vAnalist) { 
                      if($vAnalist->jml_analist < $batas_analist){ ?>
                      <option value="<?= $vAnalist->id ?>"><?= $vAnalist->nama_pegawai ?></option>
                    <?php }} ?>
                  </select>
                </td>
                <input type="hidden" id="id<?= $no; ?>" value="<?= $value->id ?>">
              <?php }else{ ?>
                <td><?= ($value->nama_pegawai) ? ($value->nama_pegawai) : '-' ?></td>
                <td><?= ($value->surat_tugas) ? ($value->surat_tugas) : '-' ?></td>
              <?php } ?>
              </tr>
            <?php $no++;} ?>
            </tbody>
          </table>
          <!-- End Tables without borders -->

        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary" onclick="simpanAdmin();">Submit</button>
          <a href="<?php echo base_url('admin/permohonan'); ?>" class="btn btn-danger">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('permohonan_ajax.php'); ?>