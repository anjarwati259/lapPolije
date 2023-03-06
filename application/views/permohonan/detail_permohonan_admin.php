<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Permohonan</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <input type="hidden" id="no_permohonan" value="<?= $dataPermohonan->no_permohonan ?>">
                <th style="width: 250px;">Kode Pesanan</th>
                <td>: <?= $dataPermohonan->no_pesanan ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Terima Sampel</th>
                <td>: <?= ($dataPermohonan->tgl_terima_sample) ? (dateDefault($dataPermohonan->tgl_terima_sample)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Perkiraan Selesai (Hari)</th>
                <td>: <?= ($dataPermohonan->perkiraan_selesai) ? (dateDefault($dataPermohonan->perkiraan_selesai)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Perkiraan Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_perkiraan_selesai) ? (dateDefault($dataPermohonan->tgl_perkiraan_selesai)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_selesai) ? (dateDefault($dataPermohonan->tgl_selesai)) : '-' ?></td>
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
                    <td>: <?= ($dataPermohonan->instansi) ? ($dataPermohonan->instansi) : '-' ?></td>
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
                  <?php if($daftarDocument){ ?>
                  <?php $no=1; foreach ($daftarDocument as $key => $value) { ?>
                    <tr>
                      <td><a href="<?= base_url('permohonan/cetakDoc/').urlencode(base64_encode($value->kode_dokumen)); ?>"><?= $value->kode_dokumen; ?></a></td>
                      <td><?= $value->type; ?></td>
                    </tr>
                  <?php } ?>
                <?php }else{ ?>
                  <p>Dokument Belum Tersedia</p>
                <?php } ?>
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
          <?php for ($no_sampel=1; $no_sampel <= $dataPermohonan->jml_sample; $no_sampel++){ 
            $no_blanko = getNoBlanko($dataPermohonan->id, $no_sampel);
            ?>
          <div class="card border-secondary">
            <h5 class="card-header"><b>No. Blanko: <a href="<?= base_url('permohonan/blankoPermohonan/').urlencode(base64_encode($no_blanko)) ?>" target="_blank"><?= $no_blanko ?></a></b></h5>
            <div class="card-body">
              <table class="table table-striped" id="tbl">
                <thead>
                    <tr>
                      <th scope="col">Kode Sampel</th>
                      <th scope="col">Jenis Analisa</th>
                      <th scope="col">Metode Analisa</th>
                      <th scope="col">Nama Analist</th>
                      <th scope="col">Ulangan 1</th>
                      <th scope="col">Ulangan 2</th>
                      <th scope="col">Rata - Rata</th>
                      <th scope="col">Standart Deviasi</th>
                      <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody style="border: none; border-color: #a6a8ab;">
                  <?php $no=1; foreach ($detailPermohonan as $key => $value) {
                        if($value->no_sample == $no_sampel){ 
                    ?>
                    <tr>
                      <td><?= ($value->kode_sample) ? ($value->kode_sample) : '-' ?></td>
                      <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                      <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                      <td><?= ($value->nama_pegawai) ? ($value->nama_pegawai) : '-' ?></td>
                      <td><?= ($value->pengulangan_1) ? ($value->pengulangan_1) : '-' ?></td>
                      <td><?= ($value->pengulangan_2) ? ($value->pengulangan_2) : '-' ?></td>
                      <td><?= ($value->rata_rata) ? ($value->rata_rata) : '-' ?></td>
                      <td><?= ($value->standart_deviasi) ? ($value->standart_deviasi) : '-' ?></td>
                      <td>
                        <div class="btn-sm btn-group" role="group" aria-label="Button group with nested dropdown">
                          <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              Document
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <li><a class="dropdown-item" href="<?= base_url('permohonan/suratTugas/').urlencode(base64_encode($value->surat_tugas)) ?>" target="_blank">Surat Tugas</a></li>
                              <li><a class="dropdown-item" href="<?= base_url('permohonan/selesaiTugas/').urlencode(base64_encode($value->selesai_tugas)) ?>" target="_blank">Selesai Tugas</a></li>
                            </ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php } } ?>
                </tbody>
              </table>
              <div class="row">
                <div class="col-md-6">
                  <label for="inputEmail3" class="col-form-label"><b>Catatan:</b></label><br>
                  <label><?= $detailPermohonan[$no_sampel]->catatan; ?></label>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail3" class="col-form-label"><b>Sertifikat:</b></label>
                  <table class="table">
                    <thead>
                      <tr>
                        <td><a href="<?= base_url('permohonan/sertifikat/en/').base64_encode(urlencode($detailPermohonan[$no_sampel]->no_sertifikat)); ?>" target="_blank">Bahasa Inggris</a></td>
                        <td><a href="<?= base_url('permohonan/sertifikat/in/').base64_encode(urlencode($detailPermohonan[$no_sampel]->no_sertifikat)); ?>" target="_blank">Bahasa Indonesia</a></td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Catatan:</b></label>
                <label><?= $detailPermohonan[$no_sampel]->catatan; ?></label> -->
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  
</script>